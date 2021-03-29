<?php
namespace App\Controller\Admin;

use App\Entity\Arme;
use App\Entity\Armure;
use App\Entity\Ennemi;
use App\Entity\Potion;
use App\Form\EnnemiType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EnnemiController extends AbstractController
{

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ennemi", name="ennemi_index", methods={"GET"})
     */
    public function showEnnemis(Request $request)
    {
        $ennemis = $this->getDoctrine()->getRepository(Ennemi::class)->findAll();
        return $this->render('admin/bdd/showEnnemis.html.twig', ['ennemis' => $ennemis]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ennemi/add", name="ennemi_add", methods={"GET", "POST"})
     */
    public function addEnnemi(Request $request) {
        $ennemi = new Ennemi();
        $form = $this->createForm(EnnemiType::class, $ennemi);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if ($form->get('sprite')->getData()){
                $photoFile = $form->get('sprite')->getData();
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $photoFile->guessExtension();
                $ennemi->setSprite($newFilename);
                try {
                    $photoFile->move(
                        $this->getParameter('ennemis_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('notice', 'erreur');
                }
            }
            $this->getDoctrine()->getManager()->persist($ennemi);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('notice', 'Ennemi ' . $ennemi->getNom() . ' ajouté');
            return $this->redirectToRoute('ennemi_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Créer','element' => 'un Ennemi','element2' => 'ennemi']);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ennemi/edit/{id}", name="ennemi_edit", methods={"GET","PUT"})
     */
    public function editEnnemi(Request $request, $id=null, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ennemi = $this->getDoctrine()->getRepository(Ennemi::class)->find($id);
        if (!$ennemi) throw $this->createNotFoundException('No enemy found for id '.$id);
        $form = $this->createForm(EnnemiType::class, $ennemi, [
            'action' => $this->generateUrl('ennemi_edit',['id'=>$id]),
            'method' => 'PUT',]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('sprite')->getData()){
                $photoFile = $form->get('sprite')->getData();
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $photoFile->guessExtension();
                $ennemi->setSprite($newFilename);
                try {
                    $photoFile->move(
                        $this->getParameter('ennemis_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('notice', 'erreur');
                }
            }
            $entityManager->persist($ennemi);
            $entityManager->flush();
            $this->addFlash('notice', 'Ennemi ' . $ennemi->getNom() . ' modifié');
            return $this->redirectToRoute('ennemi_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Modifier','element' => 'un Ennemi','element2' => 'ennemi']);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ennemi/delete", name="ennemi_delete", methods={"GET", "DELETE"})
     */
    public function deleteEnnemi(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $ennemi = $entityManager->getRepository(Ennemi::class)->find($id);
        if (!$ennemi)  throw $this->createNotFoundException('No enemy found for id '.$id);

        $entityManager->remove($ennemi);
        $entityManager->flush();
        $this->addFlash('notice', 'Ennemi ' . $ennemi->getNom() . ' supprimé');
        return $this->redirectToRoute('ennemi_index');
    }
}
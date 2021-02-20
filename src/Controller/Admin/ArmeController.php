<?php
namespace App\Controller\Admin;

use App\Entity\Arme;
use App\Form\ArmeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArmeController extends AbstractController
{

    /**
     * @Route("/arme", name="arme_index", methods={"GET"})
     * Permet d'ajouter, de modifier et de supprimer des armes dans la BDD
     */
    public function showArmes(Request $request)
    {
        $armes = $this->getDoctrine()->getRepository(Arme::class)->findAll();
        return $this->render('admin/bdd/showArmes.html.twig', ['armes' => $armes]);
    }

    /**
     * @Route("/arme/add", name="arme_add", methods={"GET", "POST"})
     */
    public function addArme(Request $request) {
        $arme = new Arme();
        $form = $this->createForm(ArmeType::class, $arme);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if ($form->get('sprite')->getData()){
                $photoFile = $form->get('sprite')->getData();
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $photoFile->guessExtension();
                $arme->setSprite($newFilename);
                try {
                    $photoFile->move(
                        $this->getParameter('armes_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('notice', 'erreur');
                }
            }
            $this->getDoctrine()->getManager()->persist($arme);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('notice', 'Arme ' . $arme->getNom() . ' ajoutée');
            return $this->redirectToRoute('arme_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Créer','element' => 'une Arme','element2' => 'arme']);
    }

    /**
     * @Route("/arme/edit/{id}", name="arme_edit", methods={"GET","PUT"})
     */
    public function editArme(Request $request, $id=null, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $arme = $this->getDoctrine()->getRepository(Arme::class)->find($id);
        if (!$arme) throw $this->createNotFoundException('No weapon found for id '.$id);
        $form = $this->createForm(ArmeType::class, $arme, [
            'action' => $this->generateUrl('arme_edit',['id'=>$id]),
            'method' => 'PUT',]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('sprite')->getData()){
                $photoFile = $form->get('sprite')->getData();
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $photoFile->guessExtension();
                $arme->setSprite($newFilename);
                try {
                    $photoFile->move(
                        $this->getParameter('armes_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('notice', 'erreur');
                }
            }

            $entityManager->persist($arme);
            $entityManager->flush();
            $this->addFlash('notice', 'Arme ' . $arme->getNom() . ' modifiée');
            return $this->redirectToRoute('arme_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Modifier','element' => 'une Arme','element2' => 'arme']);
    }

    /**
     * @Route("/arme/delete", name="arme_delete", methods={"GET", "DELETE"})
     */
    public function deleteArme(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $arme = $entityManager->getRepository(Arme::class)->find($id);

        if (!$arme)  throw $this->createNotFoundException('No weapon found for id '.$id);

        $entityManager->remove($arme);
        $entityManager->flush();

        $this->addFlash('notice', 'Arme ' . $arme->getNom() . ' supprimée');
        return $this->redirectToRoute('arme_index');
    }
}
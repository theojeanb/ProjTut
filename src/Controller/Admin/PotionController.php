<?php
namespace App\Controller\Admin;

use App\Entity\Potion;
use App\Form\PotionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PotionController extends AbstractController
{

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/potion", name="potion_index", methods={"GET"})
     */
    public function showPotions(Request $request)
    {
        $potions = $this->getDoctrine()->getRepository(Potion::class)->findAll();

        return $this->render('admin/bdd/showPotions.html.twig', ['potions' => $potions]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/potion/add", name="potion_add", methods={"GET", "POST"})
     */
    public function addPotion(Request $request) {
        $potion = new Potion();
        $form = $this->createForm(PotionType::class, $potion);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if ($form->get('sprite')->getData()){
                $photoFile = $form->get('sprite')->getData();
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $photoFile->guessExtension();
                $potion->setSprite($newFilename);
                try {
                    $photoFile->move(
                        $this->getParameter('potions_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('notice', 'erreur');
                }
            }
            $this->getDoctrine()->getManager()->persist($potion);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('notice', 'Potion ' . $potion->getNom() . ' ajoutée');
            return $this->redirectToRoute('potion_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Créer','element' => 'une Potion','element2' => 'potion']);
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/potion/edit/{id}", name="potion_edit", methods={"GET","PUT"})
     */
    public function editPotion(Request $request, $id=null, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $potion = $this->getDoctrine()->getRepository(Potion::class)->find($id);
        if (!$potion) throw $this->createNotFoundException('No enemy found for id '.$id);
        $form = $this->createForm(PotionType::class, $potion, [
            'action' => $this->generateUrl('potion_edit',['id'=>$id]),
            'method' => 'PUT',]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('sprite')->getData()){
                $photoFile = $form->get('sprite')->getData();
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $photoFile->guessExtension();
                $potion->setSprite($newFilename);
                try {
                    $photoFile->move(
                        $this->getParameter('potions_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('notice', 'erreur');
                }
            }
            $entityManager->persist($potion);
            $entityManager->flush();
            $this->addFlash('notice', 'Potion ' . $potion->getNom() . ' modifiée');
            return $this->redirectToRoute('potion_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Modifier','element' => 'une Potion','element2' => 'potion']);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/potion/delete", name="potion_delete", methods={"GET", "DELETE"})
     */
    public function deletePotion(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $potion = $entityManager->getRepository(Potion::class)->find($id);
        if (!$potion)  throw $this->createNotFoundException('No potion found for id '.$id);

        $entityManager->remove($potion);
        $entityManager->flush();
        $this->addFlash('notice', 'Potion ' . $potion->getNom() . ' supprimée');
        return $this->redirectToRoute('potion_index');
    }
}
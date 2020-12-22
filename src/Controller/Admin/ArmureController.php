<?php
namespace App\Controller\Admin;

use App\Entity\Armure;
use App\Entity\Type;
use App\Form\ArmureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ArmureController extends AbstractController
{

    /**
     * @Route("/armure", name="armure_index", methods={"GET"})
     */
    public function showArmures(Request $request)
    {
        $armures = $this->getDoctrine()->getRepository(Armure::class)->findAll();
        return $this->render('admin/bdd/showArmures.html.twig', ['armures' => $armures]);
    }

    /**
     * @Route("/armure/add", name="armure_add", methods={"GET", "POST"})
     */
    public function addArmure(Request $request) {
        $armure = new Armure();
        $form = $this->createForm(ArmureType::class, $armure);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $armure->setEstEquipe(true);
            $this->getDoctrine()->getManager()->persist($armure);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('notice', 'Armure ' . $armure->getNom() . ' ajoutée');
            return $this->redirectToRoute('armure_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Créer','element' => 'une Armure']);
    }


    /**
     * @Route("/armure/edit/{id}", name="armure_edit", methods={"GET","PUT"})
     */
    public function editArmure(Request $request, $id=null, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $armure = $this->getDoctrine()->getRepository(Armure::class)->find($id);
        if (!$armure) throw $this->createNotFoundException('No armor found for id '.$id);
        $form = $this->createForm(ArmureType::class, $armure, [
            'action' => $this->generateUrl('armure_edit',['id'=>$id]),
            'method' => 'PUT',]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($armure);
            $entityManager->flush();
            $this->addFlash('notice', 'Armure ' . $armure->getNom() . ' modifiée');
            return $this->redirectToRoute('armure_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Modifier','element' => 'une Armure']);
    }

    /**
     * @Route("/armure/delete", name="armure_delete", methods={"GET", "DELETE"})
     */
    public function deleteArmure(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);

        $entityManager->remove($armure);
        $entityManager->flush();
        $this->addFlash('notice', 'Armure ' . $armure->getNom() . ' supprimée');
        return $this->redirectToRoute('armure_index');
    }
}
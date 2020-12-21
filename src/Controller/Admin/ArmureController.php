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



    //Fonctions à supprimer :
    public function validatorArmure($donnees)
    {
        $erreurs=array();

        if (! preg_match("/^[A-Za-z ]{1,}/",$donnees['nom'])) $erreurs['nom']='nom composé de 2 lettres minimum';

        if(! is_numeric($donnees['defense'])) $erreurs['defense'] = 'saisir une valeur numérique';
        else if ($donnees['defense'] < 0) $erreurs['defense'] = "La défense ne doit pas être négative";

        if(! is_numeric($donnees['rarete'])) $erreurs['rarete'] = 'saisir une valeur numérique';
        else if ($donnees['rarete'] < 0) $erreurs['rarete'] = "La rareté ne doit pas être négative";

        if (! preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/",$donnees['sprite']))
            $erreurs['sprite']='nom de fichier incorrect (extension jpeg , jpg ou png)';

        return $erreurs;
    }

    /**
     * @Route("/armure/addUser/{id}", name="armure_addUser", methods={"POST"})
     */
    public function addArmureToUser(Request $request, $id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);
        $user = $this->getUser();
        $user->addArmure($armure);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @Route("/armure/removeUser", name="armure_removeUser", methods={"GET", "DELETE"})
     */
    public function removeArmureFromUser(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);

        $user = $this->getUser();
        $user->removeArmure($armure);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE ICI TA ROUTE');
    }
}
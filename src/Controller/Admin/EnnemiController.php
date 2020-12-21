<?php
namespace App\Controller\Admin;

use App\Entity\Arme;
use App\Entity\Armure;
use App\Entity\Ennemi;
use App\Entity\Potion;
use App\Form\EnnemiType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EnnemiController extends AbstractController
{

    /**
     * @Route("/ennemi", name="ennemi_index", methods={"GET"})
     */
    public function showEnnemis(Request $request)
    {
        $ennemis = $this->getDoctrine()->getRepository(Ennemi::class)->findAll();
        return $this->render('admin/bdd/showEnnemis.html.twig', ['ennemis' => $ennemis]);
    }

    /**
     * @Route("/ennemi/add", name="ennemi_add", methods={"GET", "POST"})
     */
    public function addEnnemi(Request $request) {
        $ennemi = new Ennemi();
        $form = $this->createForm(EnnemiType::class, $ennemi);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->persist($ennemi);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('notice', 'Ennemi ' . $ennemi->getNom() . ' ajouté');
            return $this->redirectToRoute('ennemi_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Créer','element' => 'un Ennemi']);
    }

    /**
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
            $entityManager->persist($ennemi);
            $entityManager->flush();
            $this->addFlash('notice', 'Ennemi ' . $ennemi->getNom() . ' modifié');
            return $this->redirectToRoute('ennemi_index');
        }
        return $this->render('admin/bdd/_form.html.twig', ['form' => $form->createView(),'action' => 'Modifier','element' => 'un Ennemi']);
    }

    /**
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










    public function validatorEnnemi($donnees)
    {
        $erreurs=array();

        if (! preg_match("/^[A-Za-z ]{1,}/",$donnees['nom'])) $erreurs['nom']='nom composé de 2 lettres minimum';

        if(! is_numeric($donnees['degats'])) $erreurs['degats'] = 'saisir une valeur numérique';
        else if ($donnees['degats'] < 0) $erreurs['degats'] = "Les dégâts ne doivent pas être négatifs";

        if(! is_numeric($donnees['pv'])) $erreurs['pv'] = 'saisir une valeur numérique';
        else if ($donnees['pv'] < 0) $erreurs['pv'] = "Les PV ne doivent pas être négatifs";

        if (! preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/",$donnees['sprite']))
            $erreurs['sprite']='nom de fichier incorrect (extension jpeg , jpg ou png)';

        return $erreurs;
    }
}
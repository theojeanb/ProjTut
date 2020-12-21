<?php
namespace App\Controller\Admin;

use App\Entity\Arme;
use App\Form\ArmeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Serializer\SerializerInterface;

class ArmeController extends AbstractController
{

    /**
     * @Route("/arme", name="arme_index", methods={"GET"})
     */
    public function showArmes(Request $request)
    {
        $armes = $this->getDoctrine()->getRepository(Arme::class)->findAll();

        return $this->render('admin/bdd/armes/showArmes.html.twig', ['armes' => $armes]);
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
            $arme->setEstEquipe(true);
            $this->getDoctrine()->getManager()->persist($arme);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('notice', 'Arme ' . $arme->getNom() . ' ajoutée');
            return $this->redirectToRoute('arme_index');
        }
        return $this->render('admin/bdd/armes/addArme.html.twig', ['form' => $form->createView()]);
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
            $entityManager->persist($arme);
            $entityManager->flush();
            $this->addFlash('notice', 'Arme ' . $arme->getNom() . ' modifiée');
            return $this->redirectToRoute('arme_index');
        }
        return $this->render('admin/bdd/armes/editArme.html.twig', ['form' => $form->createView()]);
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

    public function validatorArme($donnees)
    {
        $erreurs=array();
        if (! preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/",$donnees['sprite']))
            $erreurs['sprite']='nom de fichier incorrect (extension jpeg , jpg ou png)';

        return $erreurs;
    }
    /**
     * @Route("/arme/addUser/{id}", name="arme_addUser", methods={"POST"})
     */
    public function addArmeToUser(Request $request, $id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $arme = $entityManager->getRepository(Arme::class)->find($id);
        if (!$arme)  throw $this->createNotFoundException('No weapon found for id '.$id);
        $user = $this->getUser();
        $user->addArme($arme);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @Route("/arme/removeUser", name="arme_removeUser", methods={"GET", "DELETE"})
     */
    public function removeArmeFromUser(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $arme = $entityManager->getRepository(Arme::class)->find($id);
        if (!$arme)  throw $this->createNotFoundException('No weapon found for id '.$id);

        $user = $this->getUser();
        $user->removeArme($arme);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE ICI TA ROUTE');
    }
}
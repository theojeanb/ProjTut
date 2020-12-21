<?php
namespace App\Controller\Admin;

use App\Entity\Arme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
        $entityManager = $this->getDoctrine()->getManager();

        if($request->getMethod() == 'GET'){
            return $this->render('INSERE TA PAGE ICI');
        }

        $donnees['nom']=$_POST['nom'];
        $donnees['degats']=$_POST['degats'];
        $donnees['rarete']=$_POST['rarete'];
        $donnees['estEquipe']=false; // Valeur uniquement modifiée en jeu
        $donnees['sprite']=$_POST['sprite'];

        $erreurs=$this->validatorArme($donnees);
        $arme = new Arme();
        if(empty($erreurs))
        {
            $arme->setNom($donnees['nom']);
            $arme->setDegats($donnees['degats']);
            $arme->setRarete($donnees['rarete']);
            $arme->setEstEquipe($donnees['estEquipe']);
            if($donnees['sprite'] != "")
                $arme->setSprite($donnees['sprite']);
            $entityManager->persist($arme);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }

        return $this->render('INSERE TA PAGE ICI', ['donnees'=>$donnees,'erreurs'=>$erreurs]);
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
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @Route("/arme/edit/{id}", name="arme_edit", methods={"GET"})
     * @Route("/arme/edit", name="arme_edit_valid", methods={"PUT"})
     */
    public function editArme(Request $request, $id=null, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if($request->getMethod() == 'GET') {
            $arme = $entityManager->getRepository(Arme::class)->find($id);
            if (!$arme) throw $this->createNotFoundException('No weapon found for id '.$id);
            return $this->render('INSERE TA PAGE ICI', ['donnees' => $arme]);
        }

        $donnees['nom']=$_POST['nom'];
        $donnees['degats']=$_POST['degats'];
        $donnees['rarete']=$_POST['rarete'];
        $donnees['estEquipe']=false; // Valeur uniquement modifiée en jeu
        $donnees['sprite']=$_POST['sprite'];

        $erreurs=$this->validatorArme($donnees);
        if (empty($erreurs)) {
            $arme = $entityManager->getRepository(Arme::class)->find($donnees['id']);
            if (!$arme) throw $this->createNotFoundException('No weapon found for id '.$donnees['id']);
            $arme->setNom($donnees['nom']);
            $arme->setDegats($donnees['degats']);
            $arme->setRarete($donnees['rarete']);
            if($donnees['sprite'] != "")
                $arme->setSprite($donnees['sprite']);
            $entityManager->persist($arme);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }
        return $this->render('INSERE TA PAGE ICI', ['donnees' => $donnees, 'erreurs' => $erreurs]);
    }

    public function validatorArme($donnees)
    {
        $erreurs=array();

        if (! preg_match("/^[A-Za-z ]{1,}/",$donnees['nom'])) $erreurs['nom']='nom composé de 2 lettres minimum';

        if(! is_numeric($donnees['degats'])) $erreurs['degats'] = 'saisir une valeur numérique';
        else if ($donnees['degats'] < 0) $erreurs['degats'] = "Les dégâts ne doivent pas être négatifs";

        if(! is_numeric($donnees['rarete'])) $erreurs['rarete'] = 'saisir une valeur numérique';
        else if ($donnees['rarete'] < 0) $erreurs['rarete'] = "La rareté ne doit pas être négative";

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
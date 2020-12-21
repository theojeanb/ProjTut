<?php
namespace App\Controller\Admin;

use App\Entity\Arme;
use App\Entity\Armure;
use App\Entity\Ennemi;
use App\Entity\Potion;
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

        return $this->render('INSERE TA PAGE ICI', ['ennemis' => $ennemis]);
    }

    /**
     * @Route("/ennemi/add", name="ennemi_add", methods={"GET", "POST"})
     */
    public function addEnnemi(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $armes= $this->getDoctrine()->getRepository(Arme::class)->findAll();
        $armures= $this->getDoctrine()->getRepository(Armure::class)->findAll();
        $potions= $this->getDoctrine()->getRepository(Potion::class)->findAll();
        if($request->getMethod() == 'GET'){
            return $this->render('INSERE TA PAGE ICI', ['armes' => $armes, 'armures' => $armures, 'potions' => $potions]);
        }
        $donnees['nom']=$_POST['nom'];
        $donnees['degats']=$_POST['degats'];
        $donnees['pv']=$_POST['pv'];
        $donnees['sprite']=$_POST['sprite'];
        $donnees['arme_id']=$_POST['arme_id'];
        $donnees['armure_id']=$_POST['armure_id'];
        $donnees['potion_id']=$_POST['potion_id'];

        $erreurs=$this->validatorEnnemi($donnees);
        $ennemi = new Ennemi();
        if(empty($erreurs))
        {
            $ennemi->setNom($donnees['nom']);
            $ennemi->setDegats($donnees['degats']);
            $ennemi->setPv($donnees['pv']);
            if($donnees['sprite'] != "")
                $ennemi->setSprite($donnees['sprite']);
            $arme = $this->getDoctrine()->getRepository(Arme::class)->find($donnees['arme_id']);
            $armure = $this->getDoctrine()->getRepository(Armure::class)->find($donnees['armure_id']);
            $potion = $this->getDoctrine()->getRepository(Potion::class)->find($donnees['potion_id']);
            $ennemi->setArme($arme);
            $ennemi->setArmure($armure);
            $ennemi->setPotion($potion);
            $entityManager->persist($ennemi);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }

        return $this->render('INSERE TA PAGE ICI', ['donnees'=>$donnees,'erreurs'=>$erreurs, 'armes' => $armes, 'armures' => $armures, 'potions' => $potions]);
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
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @Route("/ennemi/edit/{id}", name="ennemi_edit", methods={"GET"})
     * @Route("/ennemi/edit", name="ennemi_edit_valid", methods={"PUT"})
     */
    public function editEnnemi(Request $request, $id=null, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $armes= $this->getDoctrine()->getRepository(Arme::class)->findAll();
        $armures= $this->getDoctrine()->getRepository(Armure::class)->findAll();
        $potions= $this->getDoctrine()->getRepository(Potion::class)->findAll();
        if($request->getMethod() == 'GET') {
            $ennemi = $entityManager->getRepository(Ennemi::class)->find($id);
            if (!$ennemi) throw $this->createNotFoundException('No enemy found for id '.$id);
            return $this->render('INSERE TA PAGE ICI', ['donnees' => $ennemi, 'armes' => $armes, 'armures' => $armures, 'potions' => $potions]);
        }
        $donnees['nom']=$_POST['nom'];
        $donnees['degats']=$_POST['degats'];
        $donnees['pv']=$_POST['pv'];
        $donnees['sprite']=$_POST['sprite'];
        $donnees['arme_id']=$_POST['arme_id'];
        $donnees['armure_id']=$_POST['armure_id'];
        $donnees['potion_id']=$_POST['potion_id'];

        $erreurs=$this->validatorEnnemi($donnees);
        if (empty($erreurs)) {
            $ennemi = $entityManager->getRepository(Ennemi::class)->find($donnees['id']);
            $ennemi->setNom($donnees['nom']);
            $ennemi->setDegats($donnees['degats']);
            $ennemi->setPv($donnees['pv']);
            if($donnees['sprite'] != "")
                $ennemi->setSprite($donnees['sprite']);
            $arme = $this->getDoctrine()->getRepository(Arme::class)->find($donnees['arme_id']);
            $armure = $this->getDoctrine()->getRepository(Armure::class)->find($donnees['armure_id']);
            $potion = $this->getDoctrine()->getRepository(Potion::class)->find($donnees['potion_id']);
            $ennemi->setArme($arme);
            $ennemi->setArmure($armure);
            $ennemi->setPotion($potion);
            $entityManager->persist($ennemi);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }
        return $this->render('INSERE TA PAGE ICI', ['donnees' => $donnees, 'erreurs' => $erreurs, 'armes' => $armes, 'armures' => $armures, 'potions' => $potions]);
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
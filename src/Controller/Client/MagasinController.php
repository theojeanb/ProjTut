<?php


namespace App\Controller\Client;


use App\Entity\Arme;
use App\Entity\Armure;
use App\Entity\Inventaire;
use App\Entity\Potion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MagasinController extends AbstractController
{
    /**
     * @Route("/shop", name="shop", methods={"GET"})
     */
    public function shop(Request $request){
        $armes = $this->getDoctrine()->getRepository(Arme::class)->findAll();
        $armures = $this->getDoctrine()->getRepository(Armure::class)->findAll();
        $potions = $this->getDoctrine()->getRepository(Potion::class)->findAll();
        $items = ["armes" => $armes, "potions" => $potions, "armures" => $armures];
        return $this->render('user/shop.html.twig',['items'=> $items ]);
    }

    /**
     * @Route("/shop/buy", name="shop.buy", methods={"GET"})
     */
    public function buy(Request $request){
        $id= $request->get('id');
        $group= $request->get('group');
        if($group == "armes"){
            $this->addArmeToUser($id);
        }
        if($group == "armures"){
            $this->addArmureToUser()($id);
        }
        if($group == "potions"){
            $this->addPotionToUser($id);
        }
        return $this->redirectToRoute('shop');
    }

    public function addArmeToUser($id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $arme = $entityManager->getRepository(Arme::class)->find($id);
        if (!$arme)  throw $this->createNotFoundException('No weapon found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setArme($arme);
        $inventaire->setEstEquipe(false);
        $user = $this->getUser();
        $user->addInventaire($inventaire);
        $entityManager->persist($inventaire);
        $entityManager->flush();
    }

    public function addArmureToUser($id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setArmure($armure);
        $inventaire->setEstEquipe(false);
        $user = $this->getUser();
        $user->addInventaire($inventaire);
        $entityManager->persist($inventaire);
        $entityManager->flush();
    }

    public function addPotionToUser($id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $potion = $entityManager->getRepository(Potion::class)->find($id);
        if (!$potion)  throw $this->createNotFoundException('No potion found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setPotion($potion);
        $inventaire->setEstEquipe(false);
        $user = $this->getUser();
        $user->addInventaire($inventaire);
        $entityManager->persist($inventaire);
        $entityManager->flush();
    }


}
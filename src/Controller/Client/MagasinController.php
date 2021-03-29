<?php


namespace App\Controller\Client;


use App\Entity\Arme;
use App\Entity\Armure;
use App\Entity\Inventaire;
use App\Entity\Potion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MagasinController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/shop", name="shop", methods={"GET"})
     */
    public function shop(Request $request){
        $armes = $this->getDoctrine()->getRepository(Arme::class)->findAll();
        $armures = $this->getDoctrine()->getRepository(Armure::class)->findAll();
        $potions = $this->getDoctrine()->getRepository(Potion::class)->findAll();
        $items = ["armes" => $armes, "potions" => $potions, "armures" => $armures];
        $user_id = $this->getUser()->getId();
        $userArmes = $this->getDoctrine()->getRepository(Inventaire::class)->findAllArmes($user_id);
        $userArmures = $this->getDoctrine()->getRepository(Inventaire::class)->findAllArmures($user_id);
        $userPotions = $this->getDoctrine()->getRepository(Inventaire::class)->findAllPotions($user_id);
        $inventory = ["armes" => $userArmes, "armures" => $userArmures, "potions" => $userPotions];
        $argent = $this->getUser()->getArgent();
        return $this->render('user/shop.html.twig',['armures'=> $armures,'armes' => $armes,'potions' => $potions, 'inventory' => $inventory, 'argent' => $argent]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/shop/buyArme", name="shop.buyArme", methods={"GET"})
     */
    public function addArmeToUser(Request $request) {
        $id= $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $arme = $entityManager->getRepository(Arme::class)->find($id);
        if (!$arme)  throw $this->createNotFoundException('No weapon found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setArme($arme);
        $user = $this->getUser();
        $user->setArgent(($user->getArgent())-($arme->getPrix()));
        $user->addInventaire($inventaire);
        $entityManager->persist($inventaire);
        $entityManager->flush();
        return $this->redirectToRoute('shop');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/shop/buyArmure", name="shop.buyArmure", methods={"GET"})
     */
    public function addArmureToUser(Request $request) {
        $id= $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setArmure($armure);
        $user = $this->getUser();
        $user->setArgent(($user->getArgent())-($armure->getPrix()));
        $user->addInventaire($inventaire);
        $entityManager->persist($inventaire);
        $entityManager->flush();
        return $this->redirectToRoute('shop');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/shop/buyPotion", name="shop.buyPotion", methods={"GET"})
     */
    public function addPotionToUser(Request $request) {
        $id= $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $potion = $entityManager->getRepository(Potion::class)->find($id);
        if (!$potion)  throw $this->createNotFoundException('No potion found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setPotion($potion);
        $user = $this->getUser();
        $user->setArgent(($user->getArgent())-($potion->getPrix()));
        $user->addInventaire($inventaire);
        $entityManager->persist($inventaire);
        $entityManager->flush();
        return $this->redirectToRoute('shop');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/shop/sell", name="shop.sell", methods={"GET"})
     */
    public function sell(Request $request) {
        $id = $request->get('id');
        $group= $request->get('group');
        $inventID = $request->get('inventID');
        $entityManager = $this->getDoctrine()->getManager();
        $inventaire = $entityManager->getRepository(Inventaire::class)->find($inventID);
        $user = $this->getUser();
        $user->removeInventaire($inventaire);

        if($group == "armes"){
            $this->sellArme($id);
        }
        if($group == "armures"){
            $this->sellArmure($id);
        }
        if($group == "potions"){
            $this->sellPotion($id);
        }
        return $this->redirectToRoute('shop');
    }

    public function sellArme($id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $arme = $entityManager->getRepository(Arme::class)->find($id);
        if (!$arme)  throw $this->createNotFoundException('No weapon found for id '.$id);
        $user = $this->getUser();
        $user->setArgent(($user->getArgent())+(($arme->getPrix() )-(($arme->getPrix() )*20/100) ));
        $entityManager->flush();
    }

    public function sellArmure($id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);
        $user = $this->getUser();
        $user->setArgent(($user->getArgent())+($armure->getPrix()));
        $entityManager->flush();
    }

    public function sellPotion($id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $potion = $entityManager->getRepository(Potion::class)->find($id);
        if (!$potion)  throw $this->createNotFoundException('No potion found for id '.$id);
        $user = $this->getUser();
        $user->setArgent(($user->getArgent())+($potion->getPrix()));
        $entityManager->flush();
    }


}
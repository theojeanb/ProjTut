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
        if($group == "Armes"){
            $inventaire = new Inventaire();
            #et là tu fait tes bails
        }
        if($group == "Armures"){
            $inventaire = new Inventaire();
            #et là tu fait tes bails
        }
        if($group == "Potions"){
            $inventaire = new Inventaire();
            #et là tu fait tes bails
        }
        $this->redirectToRoute('shop');
    }


}
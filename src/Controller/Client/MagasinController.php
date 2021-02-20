<?php


namespace App\Controller\Client;


use App\Entity\Arme;
use App\Entity\Armure;
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
}
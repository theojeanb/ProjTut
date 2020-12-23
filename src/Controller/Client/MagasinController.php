<?php


namespace App\Controller\Client;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MagasinController extends AbstractController
{
    /**
     * @Route("/shop", name="shop", methods={"GET"})
     */
    public function shop(Request $request){
        return $this->render('user/shop.html.twig');
    }
}
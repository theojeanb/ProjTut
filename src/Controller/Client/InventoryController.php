<?php


namespace App\Controller\Client;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    /**
     * @Route("/inventory", name="inventory")
     */
    public function inventory(Request $request)
    {
        return $this->render('user/inventory.html.twig');
    }
}
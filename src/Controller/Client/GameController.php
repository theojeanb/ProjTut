<?php


namespace App\Controller\Client;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/infos", name="infos")
     */
    public function infos(Request $request)
    {
        return $this->render('infos.html.twig');
    }

    /**
     * @Route("/dowload", name="download", methods={"GET"})
     */
    public function download(Request $request)
    {
        $exePath = $this->getParameter('download_dir').'/jeu.zip';
        return $this->file($exePath);
    }
}
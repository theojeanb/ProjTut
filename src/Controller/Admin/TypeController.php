<?php
namespace App\Controller\Admin;

use App\Entity\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/type", name="type_index", methods={"GET"})
     */
    public function showTypes(Request $request)
    {
        $types = $this->getDoctrine()->getRepository(Type::class)->findAll();

        return $this->render('admin/bdd/showTypes.html.twig', ['types' => $types]);
    }

}
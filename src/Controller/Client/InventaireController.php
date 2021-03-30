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
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Serializer\SerializerInterface;

class InventaireController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire", name="inventaire_index", methods={"GET"})
     */
    public function showInventaire(Request $request)
    {
        $armes = $this->getDoctrine()->getRepository(Inventaire::class)->findAllArmes($this->getUser()->getId());
        $armures = $this->getDoctrine()->getRepository(Inventaire::class)->findAllArmures($this->getUser()->getId());
        $potions = $this->getDoctrine()->getRepository(Inventaire::class)->findAllPotions($this->getUser()->getId());
        $user = $this->getUser();
        $equipement = $user->getEquipement();
        $items = [$armes + $armures + $potions];
        return $this->render('user/inventory.html.twig', ['items' => $items,'user' => $user,'armes' => $armes, 'armures' => $armures, 'potions' => $potions, 'equipement' => $equipement]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/equipe/{type}/{id}", name="inventaire_equipe", methods={"GET"})
     */
    public function equipe($type = null, $id =null) {
        $entityManager = $this->getDoctrine()->getManager();
        $inventaire = $entityManager->getRepository(Inventaire::class)->find($id);
        $user = $this->getUser();
        $equipement = $this->getUser()->getEquipement();
        switch($type) {
            case 1:
                $arme = $inventaire->getArme();
                $inventaire->setArme($equipement->getArme());
                $equipement->setArme($arme);
                break;
            case 2:
                $armure = $inventaire->getArmure();
                $inventaire->setArmure($equipement->getCasque());
                $equipement->setCasque($armure);
                break;
            case 3:
                $armure = $inventaire->getArmure();
                $inventaire->setArmure($equipement->getPlastron());
                $equipement->setPlastron($armure);
                break;
            case 4:
                $armure = $inventaire->getArmure();
                $inventaire->setArmure($equipement->getJambieres());
                $equipement->setJambieres($armure);
                break;
            case 5:
                $armure = $inventaire->getArmure();
                $inventaire->setArmure($equipement->getBottes());
                $equipement->setBottes($armure);
                break;
            case 6:
                $potion = $inventaire->getPotion();
                $inventaire->setPotion($equipement->getPotion());
                $equipement->setPotion($potion);
                break;
        }
        $entityManager->flush();
        return $this->redirectToRoute('inventaire_index');
    }

}
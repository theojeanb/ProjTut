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
     * @Route("/inventory", name="inventory", methods={"GET"})
     */
    public function inventory(Request $request){
        return $this->render('user/inventory.html.twig');
    }

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
        $items = $this->getUser()->getInventaires();
        return $this->render('user/inventory.html.twig', ['user' => $user,'armes' => $armes, 'armures' => $armures, 'potions' => $potions, 'equipe' => $items]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/armes", name="inventaire_armes", methods={"GET"})
     */
    public function showArmes(Request $request)
    {
        $armes = $this->getDoctrine()->getRepository(Inventaire::class)->findAllArmes($this->getUser()->getId());
        return $this->render('INSERE TA PAGE ICI', ['armes' => $armes]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/armures", name="inventaire_armures", methods={"GET"})
     */
    public function showArmures(Request $request)
    {
        $armures = $this->getDoctrine()->getRepository(Inventaire::class)->findAllArmures($this->getUser()->getId());
        return $this->render('INSERE TA PAGE ICI', ['armures' => $armures]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/potions", name="inventaire_potions", methods={"GET"})
     */
    public function showPotions(Request $request)
    {
        $potions = $this->getDoctrine()->getRepository(Inventaire::class)->findAllPotions($this->getUser()->getId());
        return $this->render('INSERE TA PAGE ICI', ['potions' => $potions]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/addArme/{id}", name="inventaire_addArme", methods={"POST"})
     */
    public function addArmeToUser(Request $request, $id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $arme = $entityManager->getRepository(Arme::class)->find($id);
        if (!$arme)  throw $this->createNotFoundException('No weapon found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setArme($arme);
        $inventaire->setEstEquipe(false);
        $user = $this->getUser();
        $user->addInventaire($inventaire);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/addArmure/{id}", name="inventaire_addArmure", methods={"POST"})
     */
    public function addArmureToUser(Request $request, $id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setArmure($armure);
        $inventaire->setEstEquipe(false);
        $user = $this->getUser();
        $user->addInventaire($inventaire);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/addPotion/{id}", name="inventaire_addPotion", methods={"POST"})
     */
    public function addPotionToUser(Request $request, $id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $potion = $entityManager->getRepository(Potion::class)->find($id);
        if (!$potion)  throw $this->createNotFoundException('No potion found for id '.$id);
        $inventaire = new Inventaire();
        $inventaire->setPotion($potion);
        $inventaire->setEstEquipe(false);
        $user = $this->getUser();
        $user->addInventaire($inventaire);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/remove/", name="inventaire_remove", methods={"GET", "DELETE"})
     */
    public function removeInventaire(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $inventaire = $entityManager->getRepository(Inventaire::class)->find($id);
        if (!$inventaire)  throw $this->createNotFoundException('No inventory found for id '.$id);

        $user = $this->getUser();
        $user->removeInventaire($inventaire);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE ICI TA ROUTE');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/inventaire/equipe/{id}", name="inventaire_equipe", methods={"POST"})
     */
    public function equipe(Request $request, $id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $inventaire = $entityManager->getRepository(Inventaire::class)->find($id);
        $type = 0;
        if (is_null($inventaire->getArme())) {$type = 1;}
        if (is_null($inventaire->getArmure())) {$type = 2;}
        if (is_null($inventaire->getPotion())) {$type = 3;}
        if ($type == 0) throw $this->createNotFoundException('No item for inventory id '.$id);
        $items = $this->getUser()->getInventaires();
        foreach ($items as $item) {
            if (!is_null($item->getArme()) and ($item->getEstEquipe()) and ($type == 1)) {
                $item->setEstEquipe(false);
            }

            if (!is_null($item->getArmure()) and ($item->getArmure()->getType() == $inventaire->getArmure()->getType()) and ($item->getEstEquipe()) and ($type == 2)) {
                $item->setEstEquipe(false);
            }

            if (!is_null($item->getPotion()) and ($item->getEstEquipe()) and ($type == 3)) {
                $item->setEstEquipe(false);
            }
        }
        $inventaire->setEstEquipe(true);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE ICI TA ROUTE');
    }

}
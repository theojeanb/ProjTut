<?php
namespace App\Controller\Admin;

use App\Entity\Potion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PotionController extends AbstractController
{

    /**
     * @Route("/potion", name="potion_index", methods={"GET"})
     */
    public function showPotions(Request $request)
    {
        $potions = $this->getDoctrine()->getRepository(Potion::class)->findAll();

        return $this->render('admin/bdd/potions/showPotions.html.twig', ['potions' => $potions]);
    }

    /**
     * @Route("/potion/add", name="potion_add", methods={"GET", "POST"})
     */
    public function addPotion(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        if($request->getMethod() == 'GET'){
            return $this->render('INSERE TA PAGE ICI');
        }

        $donnees['nom']=$_POST['nom'];
        $donnees['effet']=$_POST['effet'];
        $donnees['valeur']=$_POST['valeur'];
        $donnees['rarete']=$_POST['rarete'];
        $donnees['estEquipe']=false; // Valeur uniquement modifiée en jeu
        $donnees['sprite']=$_POST['sprite'];

        $erreurs=$this->validatorPotion($donnees);
        $potion = new Potion();
        if(empty($erreurs))
        {
            $potion->setNom($donnees['nom']);
            $potion->setEffet($donnees['effet']);
            $potion->setValeur($donnees['valeur']);
            $potion->setRarete($donnees['rarete']);
            $potion->setEstEquipe($donnees['estEquipe']);
            if($donnees['sprite'] != "")
                $potion->setSprite($donnees['sprite']);
            $entityManager->persist($potion);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }

        return $this->render('INSERE TA PAGE ICI', ['donnees'=>$donnees,'erreurs'=>$erreurs]);
    }

    /**
     * @Route("/potion/delete", name="potion_delete", methods={"GET", "DELETE"})
     */
    public function deletePotion(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $potion = $entityManager->getRepository(Potion::class)->find($id);
        if (!$potion)  throw $this->createNotFoundException('No potion found for id '.$id);

        $entityManager->remove($potion);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @Route("/potion/edit/{id}", name="potion_edit", methods={"GET"})
     * @Route("/potion/edit", name="potion_edit_valid", methods={"PUT"})
     */
    public function editPotion(Request $request, $id=null, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if($request->getMethod() == 'GET') {
            $potion = $entityManager->getRepository(Potion::class)->find($id);
            if (!$potion) throw $this->createNotFoundException('No potion found for id '.$id);
            return $this->render('INSERE TA PAGE ICI', ['donnees' => $potion]);
        }

        $donnees['nom']=$_POST['nom'];
        $donnees['effet']=$_POST['effet'];
        $donnees['valeur']=$_POST['valeur'];
        $donnees['rarete']=$_POST['rarete'];
        $donnees['estEquipe']=false; // Valeur uniquement modifiée en jeu
        $donnees['sprite']=$_POST['sprite'];

        $erreurs=$this->validatorPotion($donnees);
        if (empty($erreurs)) {
            $potion = $entityManager->getRepository(Potion::class)->find($donnees['id']);
            if (!$potion) throw $this->createNotFoundException('No potion found for id '.$donnees['id']);
            $potion->setNom($donnees['nom']);
            $potion->setEffet($donnees['effet']);
            $potion->setValeur($donnees['valeur']);
            $potion->setRarete($donnees['rarete']);
            if($donnees['sprite'] != "")
                $potion->setSprite($donnees['sprite']);
            $entityManager->persist($potion);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }
        return $this->render('INSERE TA PAGE ICI', ['donnees' => $donnees, 'erreurs' => $erreurs]);
    }

    public function validatorPotion($donnees)
    {
        $erreurs=array();

        if (! preg_match("/^[A-Za-z ]{1,}/",$donnees['nom'])) $erreurs['nom']='nom composé de 2 lettres minimum';

        if (! preg_match("/^[A-Za-z ]{1,}/",$donnees['effet'])) $erreurs['effet']='nom composé de 2 lettres minimum';


        if(! is_numeric($donnees['valeur'])) $erreurs['valeur'] = 'saisir une valeur numérique';
        else if ($donnees['valeur'] < 0) $erreurs['valeur'] = "La valeur ne doit pas être négative";

        if(! is_numeric($donnees['rarete'])) $erreurs['rarete'] = 'saisir une valeur numérique';
        else if ($donnees['rarete'] < 0) $erreurs['rarete'] = "La rareté ne doit pas être négative";

        if (! preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/",$donnees['sprite']))
            $erreurs['sprite']='nom de fichier incorrect (extension jpeg , jpg ou png)';

        return $erreurs;
    }

    /**
     * @Route("/potion/addUser/{id}", name="potion_addUser", methods={"POST"})
     */
    public function addPotionToUser(Request $request, $id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $potion = $entityManager->getRepository(Potion::class)->find($id);
        if (!$potion)  throw $this->createNotFoundException('No potion found for id '.$id);
        $user = $this->getUser();
        $user->addPotion($potion);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @Route("/potion/removeUser", name="potion_removeUser", methods={"GET", "DELETE"})
     */
    public function removePotionFromUser(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $potion = $entityManager->getRepository(Potion::class)->find($id);
        if (!$potion)  throw $this->createNotFoundException('No potion found for id '.$id);

        $user = $this->getUser();
        $user->removePotion($potion);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE ICI TA ROUTE');
    }
}
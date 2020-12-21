<?php
namespace App\Controller\Admin;

use App\Entity\Armure;
use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ArmureController extends AbstractController
{

    /**
     * @Route("/armure", name="armure_index", methods={"GET"})
     */
    public function showArmures(Request $request)
    {
        $armures = $this->getDoctrine()->getRepository(Armure::class)->findAll();

        return $this->render('INSERE TA PAGE ICI', ['armures' => $armures]);
    }

    /**
     * @Route("/armure/add", name="armure_add", methods={"GET", "POST"})
     */
    public function addArmure(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $types= $this->getDoctrine()->getRepository(Type::class)->findAll();

        if($request->getMethod() == 'GET'){
            return $this->render('INSERE TA PAGE ICI', ['types'=> $types]);
        }
        $donnees['nom']=$_POST['nom'];
        $donnees['defense']=$_POST['defense'];
        $donnees['rarete']=$_POST['rarete'];
        $donnees['estEquipe']=false; // Valeur uniquement modifiée en jeu
        $donnees['sprite']=$_POST['sprite'];
        $donnees['type_id'] = $_POST['type_id'];

        $erreurs=$this->validatorArmure($donnees);
        $armure = new Armure();
        if(empty($erreurs))
        {
            $armure->setNom($donnees['nom']);
            $armure->setDefense($donnees['defense']);
            $armure->setRarete($donnees['rarete']);
            $armure->setEstEquipe($donnees['estEquipe']);
            if($donnees['sprite'] != "")
                $armure->setSprite($donnees['sprite']);
            $type = $this->getDoctrine()->getRepository(Type::class)->find($donnees['type_id']);
            $armure->setType($type);
            $entityManager->persist($armure);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }

        return $this->render('INSERE TA PAGE ICI', ['donnees'=>$donnees,'erreurs'=>$erreurs, 'types'=> $types]);
    }

    /**
     * @Route("/armure/delete", name="armure_delete", methods={"GET", "DELETE"})
     */
    public function deleteArmure(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);

        $entityManager->remove($armure);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @Route("/armure/edit/{id}", name="armure_edit", methods={"GET"})
     * @Route("/armure/edit", name="armure_edit_valid", methods={"PUT"})
     */
    public function editArmure(Request $request, $id=null, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $types= $this->getDoctrine()->getRepository(Type::class)->findAll();
        if($request->getMethod() == 'GET') {
            $armure = $entityManager->getRepository(Armure::class)->find($id);
            if (!$armure) throw $this->createNotFoundException('No armor found for id '.$id);
            return $this->render('INSERE TA PAGE ICI', ['donnees' => $armure, 'types'=> $types]);
        }

        $donnees['nom']=$_POST['nom'];
        $donnees['defense']=$_POST['defense'];
        $donnees['rarete']=$_POST['rarete'];
        $donnees['estEquipe']=false; // Valeur uniquement modifiée en jeu
        $donnees['sprite']=$_POST['sprite'];
        $donnees['type_id'] = $_POST['type_id'];

        $erreurs=$this->validatorArmure($donnees);
        if (empty($erreurs)) {
            $armure = $entityManager->getRepository(Armure::class)->find($donnees['id']);
            if (!$armure) throw $this->createNotFoundException('No armor found for id '.$donnees['id']);
            $armure->setNom($donnees['nom']);
            $armure->setDefense($donnees['defense']);
            $armure->setRarete($donnees['rarete']);
            if($donnees['sprite'] != "")
                $armure->setSprite($donnees['sprite']);
            $type = $this->getDoctrine()->getRepository(Type::class)->find($donnees['type_id']);
            $armure->setType($type);
            $entityManager->persist($armure);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }
        return $this->render('INSERE TA PAGE ICI', ['donnees' => $donnees, 'erreurs' => $erreurs, 'types'=> $types]);
    }

    public function validatorArmure($donnees)
    {
        $erreurs=array();

        if (! preg_match("/^[A-Za-z ]{1,}/",$donnees['nom'])) $erreurs['nom']='nom composé de 2 lettres minimum';

        if(! is_numeric($donnees['defense'])) $erreurs['defense'] = 'saisir une valeur numérique';
        else if ($donnees['defense'] < 0) $erreurs['defense'] = "La défense ne doit pas être négative";

        if(! is_numeric($donnees['rarete'])) $erreurs['rarete'] = 'saisir une valeur numérique';
        else if ($donnees['rarete'] < 0) $erreurs['rarete'] = "La rareté ne doit pas être négative";

        if (! preg_match("/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/",$donnees['sprite']))
            $erreurs['sprite']='nom de fichier incorrect (extension jpeg , jpg ou png)';

        return $erreurs;
    }

    /**
     * @Route("/armure/addUser/{id}", name="armure_addUser", methods={"POST"})
     */
    public function addArmureToUser(Request $request, $id=null) {
        $entityManager = $this->getDoctrine()->getManager();
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);
        $user = $this->getUser();
        $user->addArmure($armure);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE TA ROUTE ICI');
    }

    /**
     * @Route("/armure/removeUser", name="armure_removeUser", methods={"GET", "DELETE"})
     */
    public function removeArmureFromUser(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $id= $request->request->get('id');
        $armure = $entityManager->getRepository(Armure::class)->find($id);
        if (!$armure)  throw $this->createNotFoundException('No armor found for id '.$id);

        $user = $this->getUser();
        $user->removeArmure($armure);
        $entityManager->flush();
        return $this->redirectToRoute('INSERE ICI TA ROUTE');
    }
}
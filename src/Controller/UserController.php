<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/home", name="home", methods={"GET"})
     */
    public function postLogin(Request $request) {
        return $this->render('accueil.html.twig');
    }

    /**
     * @Route("/user/edit", name="user_edit", methods={"GET"})
     * @Route("/user/valid", name="user_edit_valid", methods={"PUT"})
     */
    public function editUser(Request $request, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if($request->getMethod() == 'GET') {
            if (!$user) throw $this->createNotFoundException('No user found');
            return $this->render('INSERE TA PAGE ICI', ['donnees' => $user]);
        }

        $donnees['password']=$_POST['password'];
        $donnees['email']=$_POST['email'];
        $donnees['attaque'] = $_POST['attaque'];
        $donnees['defense'] = $_POST['defense'];
        $donnees['argent'] = $_POST['argent'];
        $donnees['pvMax'] = $_POST['pvMax'];
        $donnees['pv'] = $_POST['pv'];
        $donnees['niveau'] = $_POST['niveau'];
        $donnees['experience'] = $_POST['experience'];

        $erreurs=$this->validatorUser($donnees);

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $donnees['email']]);
        if ($user != null and $this->getUser()->getEmail() != $donnees['email']) {
            $erreurs['email'] = "Ce nom d'utilisateur existe déjà !";
        }

        if (empty($erreurs)) {
            $user->setEmail($donnees['email']);
            $password = $this->passwordEncoder->encodePassword($user, $donnees['password']);
            $user->setPassword($password);
            $user->setAttaque($donnees['attaque']);
            $user->setDefense($donnees['defense']);
            $user->setArgent($donnees['argent']);
            $user->setPvMax($donnees['pvMax']);
            $user->setPv($donnees['pv']);
            $user->setNiveau($donnees['niveau']);
            $user->setExperience($donnees['experience']);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }
        return $this->render('INSERE TA PAGE ICI', ['donnees' => $donnees, 'erreurs' => $erreurs]);
    }

    /**
     * @Route("/register", name="register", methods={"GET", "POST"})
     */
    public function addUser(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        if($request->getMethod() == 'GET'){
            return $this->render('INSERE TA PAGE ICI');
        }

        $donnees['password']=$_POST['password'];
        $donnees['email']=$_POST['email'];
        $donnees['attaque'] = 10;
        $donnees['defense'] = 10;
        $donnees['argent'] = 0;
        $donnees['pvMax'] = 100;
        $donnees['pv'] = 100;
        $donnees['niveau'] = 1;
        $donnees['experience'] = 0;

        $erreurs=$this->validatorUser($donnees);

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $donnees['email']]);
        if ($user != null) {
            $erreurs['email'] = "Ce nom d'utilisateur existe déjà !";
        }
        if (empty($erreurs)) {
            $user = new User();
            $user->setEmail($donnees['email']);
            $password = $this->passwordEncoder->encodePassword($user, $donnees['password']);
            $user->setPassword($password);
            $user->setAttaque($donnees['attaque']);
            $user->setDefense($donnees['defense']);
            $user->setArgent($donnees['argent']);
            $user->setPvMax($donnees['pvMax']);
            $user->setPv($donnees['pv']);
            $user->setNiveau($donnees['niveau']);
            $user->setExperience($donnees['experience']);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('INSERE TA ROUTE ICI');
        }
        return $this->render('INSERE TA PAGE ICI', ['donnees' => $donnees, 'erreurs' => $erreurs]);
    }
}
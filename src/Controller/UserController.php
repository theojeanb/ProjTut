<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $passwordEncoder;
    private $n = "7641743792047461691217802962928255710667124601088812189826971421203703652459726180054553349532686870856113940361566037662823365406366891324331269682419503804747539182226267593041803999070468662354229333249901475561597088977648720437559994785606812947823468162276323622913127207617617106693070686060263";
    private $c = "961";

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

    /* /**
     * @Route("/user/edit", name="user_edit", methods={"GET"})
     * @Route("/user/valid", name="user_edit_valid", methods={"PUT"})
     */
    /* public function editUser(Request $request, SerializerInterface $serializer)
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
    }*/

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/user/edit", name="edit_user", methods={"GET", "POST"})
     */
    public function editUser(Request $request,UserPasswordEncoderInterface $encoder) {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $arraypassword =$data->getPassword();
            $password = $this->cryptRSA($arraypassword);
            $user->setPassword($password);
            $user->setArgent(0);
            $user->setPvMax(100);
            $user->setPv(100);
            $user->setNiveau(1);
            $user->setExperience(0);
            $user->setAttaque(10);
            $user->setDefense(10);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/editUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register", name="register", methods={"GET", "POST"})
     */
    public function addUser(Request $request,UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $arraypassword =$data->getPassword();
            $password = $this->cryptRSA($arraypassword);
            $user->setPassword($password);
            $user->setArgent(0);
            $user->setPvMax(100);
            $user->setPv(100);
            $user->setNiveau(1);
            $user->setExperience(0);
            $user->setAttaque(10);
            $user->setDefense(10);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/addUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function cryptRSA($arraypassword) {
        $array = str_split($arraypassword);
        $password = "";
        foreach($array as $char) {
            $password .= sprintf("%03d", ord($char));
        }
        $password = bcpowmod($password, $this->c, $this->n);
        return $password;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/data", name="data", methods={"GET", "POST"})
     */
    public function getData(){
        return $this->render('user/data.html.twig',['user'=>$this->getUser()]);
    }
}
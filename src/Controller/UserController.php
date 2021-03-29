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
        if ($form->isSubmitted() && $form->isValid() && $this->captchaverify($request->get('g-recaptcha-response'))) {
            $data = $form->getData();
            $arraypassword =$data->getPassword();
            $password = $encoder->encodePassword($user, $arraypassword);
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
        if($form->isSubmitted() &&  $form->isValid() && !$this->captchaverify($request->get('g-recaptcha-response'))){
            $this->addFlash(
                'notice',
                'Captcha Required'
            );
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
        if ($form->isSubmitted() && $form->isValid() && $this->captchaverify($request->get('g-recaptcha-response'))) {
            $data = $form->getData();
            $arraypassword =$data->getPassword();
            $password = $encoder->encodePassword($user, $arraypassword);
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
        if($form->isSubmitted() &&  $form->isValid() && !$this->captchaverify($request->get('g-recaptcha-response'))){
            $this->addFlash(
                'notice',
                'Captcha Required'
            );
        }
        return $this->render('security/addUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    public function captchaverify($recaptcha_response){
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $recaptcha_secret = '6LeLhwIaAAAAALXoL4hxKtD64mo6GSuM1ZPpVQrt';
        $recaptcha = file_get_contents($url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $data = json_decode($recaptcha);
        $result = $data->success;
        return $result;
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/data", name="data", methods={"GET", "POST"})
     */
    public function getData(){
        return $this->render('user/data.html.twig',['user'=>$this->getUser()]);
    }
}
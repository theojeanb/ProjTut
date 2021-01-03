<?php
namespace App\Controller;

use App\Entity\Perso;
use App\Entity\User;
use App\Form\UserType;
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
            $perso = new Perso();
            $perso->setArgent(0);
            $perso->setPvMax(100);
            $perso->setPv(100);
            $perso->setNiveau(1);
            $perso->setExperience(0);
            $perso->setAttaque(10);
            $perso->setDefense(10);
            $user->setPerso($perso);
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
}
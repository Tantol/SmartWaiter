<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class RegisterController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Request
     * @internal param UserPasswordEncoderInterface #encoder
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('homepage', array(), 301);
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $user = new User();
        
        $form = $this->createForm(RegisterType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            // Create the user
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            
            $em->persist($user);
            $em->flush();
            
            $lastUserName = $user->getUsername();
            $errors = null;
            $message = 'U have been registerd';
            
            //return $this->redirectToRoute('login');
            return $this->render('login/login.html.twig', array(
            'errors' => $errors,
            'username' => $lastUserName,
            'message' => $message,
        ));
        }
        
        return $this->render('register/register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}

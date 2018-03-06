<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        
        $errors = $authenticationUtils->getLastAuthenticationError();
        
        $lastUserName = $authenticationUtils->getLastUsername();
        
        $message = null;
        
        return $this->render('login/login.html.twig', array(
            'errors' => $errors,
            'username' => $lastUserName,
            'message' => $message,
        ));
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        
        
    }
}

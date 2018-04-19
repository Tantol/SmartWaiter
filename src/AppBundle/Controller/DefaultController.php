<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');

    }
    
    /**
     * @Route("/adminPanel", name="adminPanel")
     */
    public function adminPanelAction(Request $request)
    {
        return $this->render('default/panel.html.twig');

    }
    
        /**
     * @Route("/cookPanel", name="cookPanel")
     */
    public function cookPanelAction(Request $request)
    {
        return $this->render('default/panel.html.twig');

    }
    
    /**
     * @Route("/waiterPanel", name="waiterPanel")
     */
    public function waiterPanelAction(Request $request)
    {
        return $this->render('default/panel.html.twig');

    }
    
    /**
     * @Route("/menedzerPanel", name="managerPanel")
     */
    public function manadzerPanelAction(Request $request)
    {
        return $this->render('default/panel.html.twig');

    }
}

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
      if ($this->get('security.authorization_checker')->isGranted('ROLE_WAITER')) {
          return $this->redirect($this->generateUrl('waiterPanel'));
      } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_COOK')) {
          return $this->redirect($this->generateUrl('cookPanel'));
      } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_MANAGER')) {
          return $this->redirect($this->generateUrl('managerPanel'));
      } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirect($this->generateUrl('adminPanel'));
      }

        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/panelUzytkownika", name="panelUzytkownika")
     */
    public function uzytkownikAction(Request $request)
    {
        return $this->render('default/panelUzytkownika.html.twig', array(
            'user' => $this->getUser(),
        ));

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

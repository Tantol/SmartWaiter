<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Danie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Danie controller.
 *
 * @Route("danie")
 */
class DanieController extends Controller
{
    /**
     * Lists all danie entities.
     *
     * @Route("/", name="danie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $danies = $em->getRepository('AppBundle:Danie')->findAll();

        return $this->render('danie/index.html.twig', array(
            'danies' => $danies,
        ));
    }

    /**
     * Finds and displays a danie entity.
     *
     * @Route("/{id}", name="danie_show")
     * @Method("GET")
     */
    public function showAction(Danie $danie)
    {

        return $this->render('danie/show.html.twig', array(
            'danie' => $danie,
        ));
    }
}

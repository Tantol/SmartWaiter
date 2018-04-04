<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pozycja_zamowienia;
use AppBundle\Security\Pozycja_zamowieniaVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Zamowienie;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Pozycja_zamowienium controller.
 *
 * @Route("pozycja_zamowienia")
 */
class Pozycja_zamowieniaController extends Controller
{
    /**
     * Lists all pozycja_zamowienium entities.
     *
     * @Route("/", name="pozycja_zamowienia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::VIEW, new Pozycja_zamowienia());
        
        $em = $this->getDoctrine()->getManager();

        $pozycja_zamowienias = $em->getRepository('AppBundle:Pozycja_zamowienia')->findAll();

        return $this->render('pozycja_zamowienia/index.html.twig', array(
            'pozycja_zamowienias' => $pozycja_zamowienias,
        ));
    }

    /**
     * Creates a new pozycja_zamowienium entity.
     *
     * @Route("/new", name="pozycja_zamowienia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pozycja_zamowienium = new Pozycja_zamowienia();
        
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::ADD, $pozycja_zamowienium);
        
        $form = $this->createForm('AppBundle\Form\Pozycja_zamowieniaType', $pozycja_zamowienium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $zamowienie = $this->get('session')->get('zamowienie');
            
            $pozycja_zamowienium->setCenaJedn($pozycja_zamowienium->getDanie()->getCena());
            $pozycja_zamowienium->setCzasPrzygotowania($pozycja_zamowienium->getDanie()->getCzasPrzygotowania());
            $em->persist($pozycja_zamowienium);
            
            $zamowienie->addPozycjeZamowien($pozycja_zamowienium);
            $this->get('session')->set('zamowienie', $zamowienie);
            
            return $this->redirectToRoute('zamowienie_new');
        }

        return $this->render('pozycja_zamowienia/new.html.twig', array(
            'pozycja_zamowienium' => $pozycja_zamowienium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pozycja_zamowienium entity.
     *
     * @Route("/{id}", name="pozycja_zamowienia_show")
     * @Method("GET")
     */
    public function showAction(Pozycja_zamowienia $pozycja_zamowienium)
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::VIEW, $pozycja_zamowienium);
        
        $deleteForm = $this->createDeleteForm($pozycja_zamowienium);

        return $this->render('pozycja_zamowienia/show.html.twig', array(
            'pozycja_zamowienium' => $pozycja_zamowienium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pozycja_zamowienium entity.
     *
     * @Route("/{id}/edit", name="pozycja_zamowienia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pozycja_zamowienia $pozycja_zamowienium)
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::EDIT, $pozycja_zamowienium);
        
        $deleteForm = $this->createDeleteForm($pozycja_zamowienium);
        $editForm = $this->createForm('AppBundle\Form\Pozycja_zamowieniaType', $pozycja_zamowienium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pozycja_zamowienia_edit', array('id' => $pozycja_zamowienium->getId()));
        }

        return $this->render('pozycja_zamowienia/edit.html.twig', array(
            'pozycja_zamowienium' => $pozycja_zamowienium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pozycja_zamowienium entity.
     *
     * @Route("/{id}", name="pozycja_zamowienia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pozycja_zamowienia $pozycja_zamowienium)
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::DELETE, $pozycja_zamowienium);
        
        $form = $this->createDeleteForm($pozycja_zamowienium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pozycja_zamowienium);
            $em->flush();
        }

        return $this->redirectToRoute('pozycja_zamowienia_index');
    }

    /**
     * Creates a form to delete a pozycja_zamowienium entity.
     *
     * @param Pozycja_zamowienia $pozycja_zamowienium The pozycja_zamowienium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pozycja_zamowienia $pozycja_zamowienium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pozycja_zamowienia_delete', array('id' => $pozycja_zamowienium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

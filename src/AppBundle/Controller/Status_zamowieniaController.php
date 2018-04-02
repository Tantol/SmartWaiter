<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Status_zamowienia;
use AppBundle\Security\Status_zamowieniaVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Status_zamowienium controller.
 *
 * @Route("status_zamowienia")
 */
class Status_zamowieniaController extends Controller
{
    /**
     * Lists all status_zamowienium entities.
     *
     * @Route("/", name="status_zamowienia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(Status_zamowieniaVoter::VIEW, new Status_zamowienia());
        
        $em = $this->getDoctrine()->getManager();

        $status_zamowienias = $em->getRepository('AppBundle:Status_zamowienia')->findAll();

        return $this->render('status_zamowienia/index.html.twig', array(
            'status_zamowienias' => $status_zamowienias,
        ));
    }

    /**
     * Creates a new status_zamowienium entity.
     *
     * @Route("/new", name="status_zamowienia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $status_zamowienium = new Status_zamowienia();
        
        $this->denyAccessUnlessGranted(Status_zamowieniaVoter::ADD, $status_zamowienium);
        
        $form = $this->createForm('AppBundle\Form\Status_zamowieniaType', $status_zamowienium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status_zamowienium);
            $em->flush();

            return $this->redirectToRoute('status_zamowienia_show', array('id' => $status_zamowienium->getId()));
        }

        return $this->render('status_zamowienia/new.html.twig', array(
            'status_zamowienium' => $status_zamowienium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a status_zamowienium entity.
     *
     * @Route("/{id}", name="status_zamowienia_show")
     * @Method("GET")
     */
    public function showAction(Status_zamowienia $status_zamowienium)
    {
        $this->denyAccessUnlessGranted(Status_zamowieniaVoter::VIEW, $status_zamowienium);
        
        $deleteForm = $this->createDeleteForm($status_zamowienium);

        return $this->render('status_zamowienia/show.html.twig', array(
            'status_zamowienium' => $status_zamowienium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing status_zamowienium entity.
     *
     * @Route("/{id}/edit", name="status_zamowienia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Status_zamowienia $status_zamowienium)
    {
        $this->denyAccessUnlessGranted(Status_zamowieniaVoter::EDIT, $status_zamowienium);
        
        $deleteForm = $this->createDeleteForm($status_zamowienium);
        $editForm = $this->createForm('AppBundle\Form\Status_zamowieniaType', $status_zamowienium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('status_zamowienia_edit', array('id' => $status_zamowienium->getId()));
        }

        return $this->render('status_zamowienia/edit.html.twig', array(
            'status_zamowienium' => $status_zamowienium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a status_zamowienium entity.
     *
     * @Route("/{id}", name="status_zamowienia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Status_zamowienia $status_zamowienium)
    {
        $this->denyAccessUnlessGranted(Status_zamowieniaVoter::DELETE, $status_zamowienium);
        
        $form = $this->createDeleteForm($status_zamowienium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($status_zamowienium);
            $em->flush();
        }

        return $this->redirectToRoute('status_zamowienia_index');
    }

    /**
     * Creates a form to delete a status_zamowienium entity.
     *
     * @param Status_zamowienia $status_zamowienium The status_zamowienium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Status_zamowienia $status_zamowienium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('status_zamowienia_delete', array('id' => $status_zamowienium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

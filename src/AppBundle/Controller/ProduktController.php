<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Produkt;
use AppBundle\Security\ProduktVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Produkt controller.
 *
 * @Route("produkt")
 */
class ProduktController extends Controller
{
    /**
     * Lists all produkt entities.
     *
     * @Route("/", name="produkt_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(ProduktVoter::VIEW, new Produkt());
        
        $em = $this->getDoctrine()->getManager();

        $produkts = $em->getRepository('AppBundle:Produkt')->findAll();

        return $this->render('produkt/index.html.twig', array(
            'produkts' => $produkts,
        ));
    }

    /**
     * Creates a new produkt entity.
     *
     * @Route("/new", name="produkt_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $produkt = new Produkt();
        
        $this->denyAccessUnlessGranted(ProduktVoter::ADD, $produkt);
        
        $form = $this->createForm('AppBundle\Form\ProduktType', $produkt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produkt);
            $em->flush();

            return $this->redirectToRoute('produkt_show', array('id' => $produkt->getId()));
        }

        return $this->render('produkt/new.html.twig', array(
            'produkt' => $produkt,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produkt entity.
     *
     * @Route("/{id}", name="produkt_show")
     * @Method("GET")
     */
    public function showAction(Produkt $produkt)
    {
        $this->denyAccessUnlessGranted(ProduktVoter::VIEW, $produkt);
        
        $deleteForm = $this->createDeleteForm($produkt);

        return $this->render('produkt/show.html.twig', array(
            'produkt' => $produkt,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produkt entity.
     *
     * @Route("/{id}/edit", name="produkt_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produkt $produkt)
    {
        $this->denyAccessUnlessGranted(ProduktVoter::EDIT, $produkt);
        
        $deleteForm = $this->createDeleteForm($produkt);
        $editForm = $this->createForm('AppBundle\Form\ProduktType', $produkt);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produkt_edit', array('id' => $produkt->getId()));
        }

        return $this->render('produkt/edit.html.twig', array(
            'produkt' => $produkt,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produkt entity.
     *
     * @Route("/{id}", name="produkt_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produkt $produkt)
    {
        $this->denyAccessUnlessGranted(ProduktVoter::DELETE, $produkt);
        
        $form = $this->createDeleteForm($produkt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produkt);
            $em->flush();
        }

        return $this->redirectToRoute('produkt_index');
    }

    /**
     * Creates a form to delete a produkt entity.
     *
     * @param Produkt $produkt The produkt entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produkt $produkt)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produkt_delete', array('id' => $produkt->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

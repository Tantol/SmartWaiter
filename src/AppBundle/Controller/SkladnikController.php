<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Skladnik;
use AppBundle\Security\SkladnikVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Skladnik controller.
 *
 * @Route("skladnik")
 */
class SkladnikController extends Controller
{
    /**
     * Lists all skladnik entities.
     *
     * @Route("/", name="skladnik_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(SkladnikVoter::VIEW, new Skladnik());
        
        $em = $this->getDoctrine()->getManager();

        $skladniks = $em->getRepository('AppBundle:Skladnik')->findAll();

        return $this->render('skladnik/index.html.twig', array(
            'skladniks' => $skladniks,
        ));
    }

    /**
     * Creates a new skladnik entity.
     *
     * @Route("/new", name="skladnik_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $skladnik = new Skladnik();
        
        $this->denyAccessUnlessGranted(SkladnikVoter::ADD, $skladnik);
        
        $form = $this->createForm('AppBundle\Form\SkladnikType', $skladnik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($skladnik);
            $em->flush();

            return $this->redirectToRoute('skladnik_show', array('id' => $skladnik->getId()));
        }

        return $this->render('skladnik/new.html.twig', array(
            'skladnik' => $skladnik,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a skladnik entity.
     *
     * @Route("/{id}", name="skladnik_show")
     * @Method("GET")
     */
    public function showAction(Skladnik $skladnik)
    {
        $this->denyAccessUnlessGranted(SkladnikVoter::VIEW, $skladnik);
        
        $deleteForm = $this->createDeleteForm($skladnik);

        return $this->render('skladnik/show.html.twig', array(
            'skladnik' => $skladnik,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing skladnik entity.
     *
     * @Route("/{id}/edit", name="skladnik_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Skladnik $skladnik)
    {
        $this->denyAccessUnlessGranted(SkladnikVoter::EDIT, $skladnik);
        
        $deleteForm = $this->createDeleteForm($skladnik);
        $editForm = $this->createForm('AppBundle\Form\SkladnikType', $skladnik);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('skladnik_edit', array('id' => $skladnik->getId()));
        }

        return $this->render('skladnik/edit.html.twig', array(
            'skladnik' => $skladnik,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a skladnik entity.
     *
     * @Route("/{id}", name="skladnik_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Skladnik $skladnik)
    {
        $this->denyAccessUnlessGranted(SkladnikVoter::DELETE, $skladnik);
        
        $form = $this->createDeleteForm($skladnik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($skladnik);
            $em->flush();
        }

        return $this->redirectToRoute('skladnik_index');
    }

    /**
     * Creates a form to delete a skladnik entity.
     *
     * @param Skladnik $skladnik The skladnik entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Skladnik $skladnik)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('skladnik_delete', array('id' => $skladnik->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

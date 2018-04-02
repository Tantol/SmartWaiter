<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dostawca;
use AppBundle\Security\DostawcaVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Dostawca controller.
 *
 * @Route("dostawca")
 */
class DostawcaController extends Controller
{
    /**
     * Lists all dostawca entities.
     *
     * @Route("/", name="dostawca_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(DostawcaVoter::VIEW, new Dostawca());
        
        $em = $this->getDoctrine()->getManager();

        $dostawcas = $em->getRepository('AppBundle:Dostawca')->findAll();

        return $this->render('dostawca/index.html.twig', array(
            'dostawcas' => $dostawcas,
        ));
    }

    /**
     * Creates a new dostawca entity.
     *
     * @Route("/new", name="dostawca_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dostawca = new Dostawca();
        
        $this->denyAccessUnlessGranted(DostawcaVoter::ADD, $dostawca);
        
        $form = $this->createForm('AppBundle\Form\DostawcaType', $dostawca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dostawca);
            $em->flush();

            return $this->redirectToRoute('dostawca_show', array('id' => $dostawca->getId()));
        }

        return $this->render('dostawca/new.html.twig', array(
            'dostawca' => $dostawca,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dostawca entity.
     *
     * @Route("/{id}", name="dostawca_show")
     * @Method("GET")
     */
    public function showAction(Dostawca $dostawca)
    {
        $this->denyAccessUnlessGranted(DostawcaVoter::VIEW, $dostawca);
        
        $deleteForm = $this->createDeleteForm($dostawca);

        return $this->render('dostawca/show.html.twig', array(
            'dostawca' => $dostawca,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dostawca entity.
     *
     * @Route("/{id}/edit", name="dostawca_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dostawca $dostawca)
    {
        $this->denyAccessUnlessGranted(DostawcaVoter::EDIT, $dostawca);
        
        $deleteForm = $this->createDeleteForm($dostawca);
        $editForm = $this->createForm('AppBundle\Form\DostawcaType', $dostawca);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dostawca_edit', array('id' => $dostawca->getId()));
        }

        return $this->render('dostawca/edit.html.twig', array(
            'dostawca' => $dostawca,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dostawca entity.
     *
     * @Route("/{id}", name="dostawca_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dostawca $dostawca)
    {
        $this->denyAccessUnlessGranted(DostawcaVoter::DELETE, $dostawca);
        
        $form = $this->createDeleteForm($dostawca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dostawca);
            $em->flush();
        }

        return $this->redirectToRoute('dostawca_index');
    }

    /**
     * Creates a form to delete a dostawca entity.
     *
     * @param Dostawca $dostawca The dostawca entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dostawca $dostawca)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dostawca_delete', array('id' => $dostawca->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

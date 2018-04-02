<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rodzaj;
use AppBundle\Security\RodzajVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Rodzaj controller.
 *
 * @Route("rodzaj")
 */
class RodzajController extends Controller
{
    /**
     * Lists all rodzaj entities.
     *
     * @Route("/", name="rodzaj_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(RodzajVoter::VIEW, new Rodzaj());
        
        $em = $this->getDoctrine()->getManager();

        $rodzajs = $em->getRepository('AppBundle:Rodzaj')->findAll();

        return $this->render('rodzaj/index.html.twig', array(
            'rodzajs' => $rodzajs,
        ));
    }

    /**
     * Creates a new rodzaj entity.
     *
     * @Route("/new", name="rodzaj_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rodzaj = new Rodzaj();
        
        $this->denyAccessUnlessGranted(RodzajVoter::ADD, $rodzaj);
        
        $form = $this->createForm('AppBundle\Form\RodzajType', $rodzaj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rodzaj);
            $em->flush();

            return $this->redirectToRoute('rodzaj_show', array('id' => $rodzaj->getId()));
        }

        return $this->render('rodzaj/new.html.twig', array(
            'rodzaj' => $rodzaj,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rodzaj entity.
     *
     * @Route("/{id}", name="rodzaj_show")
     * @Method("GET")
     */
    public function showAction(Rodzaj $rodzaj)
    {
        $this->denyAccessUnlessGranted(RodzajVoter::VIEW, $rodzaj);
        
        $deleteForm = $this->createDeleteForm($rodzaj);

        return $this->render('rodzaj/show.html.twig', array(
            'rodzaj' => $rodzaj,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rodzaj entity.
     *
     * @Route("/{id}/edit", name="rodzaj_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rodzaj $rodzaj)
    {
        $this->denyAccessUnlessGranted(RodzajVoter::EDIT, $rodzaj);
        
        $deleteForm = $this->createDeleteForm($rodzaj);
        $editForm = $this->createForm('AppBundle\Form\RodzajType', $rodzaj);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rodzaj_edit', array('id' => $rodzaj->getId()));
        }

        return $this->render('rodzaj/edit.html.twig', array(
            'rodzaj' => $rodzaj,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rodzaj entity.
     *
     * @Route("/{id}", name="rodzaj_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rodzaj $rodzaj)
    {
        $this->denyAccessUnlessGranted(RodzajVoter::DELETE, $rodzaj);
        
        $form = $this->createDeleteForm($rodzaj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rodzaj);
            $em->flush();
        }

        return $this->redirectToRoute('rodzaj_index');
    }

    /**
     * Creates a form to delete a rodzaj entity.
     *
     * @param Rodzaj $rodzaj The rodzaj entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rodzaj $rodzaj)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rodzaj_delete', array('id' => $rodzaj->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

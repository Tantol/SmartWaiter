<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pracownik;
use AppBundle\Security\PracownikVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pracownik controller.
 *
 * @Route("pracownik")
 */
class PracownikController extends Controller
{
    /**
     * Lists all pracownik entities.
     *
     * @Route("/", name="pracownik_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(PracownikVoter::VIEW, new Pracownik());
        
        $em = $this->getDoctrine()->getManager();

        $pracowniks = $em->getRepository('AppBundle:Pracownik')->findAll();

        return $this->render('pracownik/index.html.twig', array(
            'pracowniks' => $pracowniks,
        ));
    }

    /**
     * Creates a new pracownik entity.
     *
     * @Route("/new", name="pracownik_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pracownik = new Pracownik();
        
        $this->denyAccessUnlessGranted(PracownikVoter::ADD, $pracownik);
        
        $form = $this->createForm('AppBundle\Form\PracownikType', $pracownik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pracownik);
            $em->flush();

            return $this->redirectToRoute('pracownik_show', array('id' => $pracownik->getId()));
        }

        return $this->render('pracownik/new.html.twig', array(
            'pracownik' => $pracownik,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pracownik entity.
     *
     * @Route("/{id}", name="pracownik_show")
     * @Method("GET")
     */
    public function showAction(Pracownik $pracownik)
    {
        $this->denyAccessUnlessGranted(PracownikVoter::VIEW, $pracownik);
        
        $deleteForm = $this->createDeleteForm($pracownik);

        return $this->render('pracownik/show.html.twig', array(
            'pracownik' => $pracownik,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pracownik entity.
     *
     * @Route("/{id}/edit", name="pracownik_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pracownik $pracownik)
    {
        $this->denyAccessUnlessGranted(PracownikVoter::EDIT, $pracownik);
        
        $deleteForm = $this->createDeleteForm($pracownik);
        $editForm = $this->createForm('AppBundle\Form\PracownikType', $pracownik);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pracownik_edit', array('id' => $pracownik->getId()));
        }

        return $this->render('pracownik/edit.html.twig', array(
            'pracownik' => $pracownik,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pracownik entity.
     *
     * @Route("/{id}", name="pracownik_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pracownik $pracownik)
    {
        $this->denyAccessUnlessGranted(PracownikVoter::DELETE, $pracownik);
        
        $form = $this->createDeleteForm($pracownik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pracownik);
            $em->flush();
        }

        return $this->redirectToRoute('pracownik_index');
    }

    /**
     * Creates a form to delete a pracownik entity.
     *
     * @param Pracownik $pracownik The pracownik entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pracownik $pracownik)
    {    
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pracownik_delete', array('id' => $pracownik->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

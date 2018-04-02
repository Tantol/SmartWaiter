<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Zamowienie;
use AppBundle\Security\ZamowienieVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Zamowienie controller.
 *
 * @Route("zamowienie")
 */
class ZamowienieController extends Controller
{
    /**
     * Lists all zamowienie entities.
     *
     * @Route("/", name="zamowienie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(ZamowienieVoter::VIEW, new Zamowienie());
        
        $em = $this->getDoctrine()->getManager();

        $zamowienies = $em->getRepository('AppBundle:Zamowienie')->findAll();

        return $this->render('zamowienie/index.html.twig', array(
            'zamowienies' => $zamowienies,
        ));
    }

    /**
     * Creates a new zamowienie entity.
     *
     * @Route("/new", name="zamowienie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $zamowienie = new Zamowienie();
        
        $this->denyAccessUnlessGranted(ZamowienieVoter::ADD, $zamowienie);
        
        $form = $this->createForm('AppBundle\Form\ZamowienieType', $zamowienie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zamowienie);
            $em->flush();

            return $this->redirectToRoute('zamowienie_show', array('id' => $zamowienie->getId()));
        }

        return $this->render('zamowienie/new.html.twig', array(
            'zamowienie' => $zamowienie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a zamowienie entity.
     *
     * @Route("/{id}", name="zamowienie_show")
     * @Method("GET")
     */
    public function showAction(Zamowienie $zamowienie)
    {
        $this->denyAccessUnlessGranted(ZamowienieVoter::VIEW, $zamowienie);
        
        $deleteForm = $this->createDeleteForm($zamowienie);

        return $this->render('zamowienie/show.html.twig', array(
            'zamowienie' => $zamowienie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing zamowienie entity.
     *
     * @Route("/{id}/edit", name="zamowienie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Zamowienie $zamowienie)
    {
        $this->denyAccessUnlessGranted(ZamowienieVoter::EDIT, $zamowienie);
        
        $deleteForm = $this->createDeleteForm($zamowienie);
        $editForm = $this->createForm('AppBundle\Form\ZamowienieType', $zamowienie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('zamowienie_edit', array('id' => $zamowienie->getId()));
        }

        return $this->render('zamowienie/edit.html.twig', array(
            'zamowienie' => $zamowienie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a zamowienie entity.
     *
     * @Route("/{id}", name="zamowienie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Zamowienie $zamowienie)
    {
        $this->denyAccessUnlessGranted(ZamowienieVoter::DELETE, $zamowienie);
        
        $form = $this->createDeleteForm($zamowienie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zamowienie);
            $em->flush();
        }

        return $this->redirectToRoute('zamowienie_index');
    }

    /**
     * Creates a form to delete a zamowienie entity.
     *
     * @param Zamowienie $zamowienie The zamowienie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Zamowienie $zamowienie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zamowienie_delete', array('id' => $zamowienie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

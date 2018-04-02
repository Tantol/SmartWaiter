<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StanMagazynowy;
use AppBundle\Security\StanMagazynowyVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Stanmagazynowy controller.
 *
 * @Route("stanmagazynowy")
 */
class StanMagazynowyController extends Controller
{
    /**
     * Lists all stanMagazynowy entities.
     *
     * @Route("/", name="stanmagazynowy_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(StanMagazynowyVoter::VIEW, new StanMagazynowy());
        
        $em = $this->getDoctrine()->getManager();

        $stanMagazynowies = $em->getRepository('AppBundle:StanMagazynowy')->findAll();

        return $this->render('stanmagazynowy/index.html.twig', array(
            'stanMagazynowies' => $stanMagazynowies,
        ));
    }

    /**
     * Creates a new stanMagazynowy entity.
     *
     * @Route("/new", name="stanmagazynowy_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $stanMagazynowy = new Stanmagazynowy();
        
        $this->denyAccessUnlessGranted(StanMagazynowyVoter::ADD, $stanMagazynowy);
        
        $form = $this->createForm('AppBundle\Form\StanMagazynowyType', $stanMagazynowy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stanMagazynowy);
            $em->flush();

            return $this->redirectToRoute('stanmagazynowy_show', array('id' => $stanMagazynowy->getId()));
        }

        return $this->render('stanmagazynowy/new.html.twig', array(
            'stanMagazynowy' => $stanMagazynowy,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a stanMagazynowy entity.
     *
     * @Route("/{id}", name="stanmagazynowy_show")
     * @Method("GET")
     */
    public function showAction(StanMagazynowy $stanMagazynowy)
    {
        $this->denyAccessUnlessGranted(StanMagazynowyVoter::VIEW, $stanMagazynowy);
        
        $deleteForm = $this->createDeleteForm($stanMagazynowy);

        return $this->render('stanmagazynowy/show.html.twig', array(
            'stanMagazynowy' => $stanMagazynowy,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing stanMagazynowy entity.
     *
     * @Route("/{id}/edit", name="stanmagazynowy_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, StanMagazynowy $stanMagazynowy)
    {
        $this->denyAccessUnlessGranted(StanMagazynowyVoter::EDIT, $stanMagazynowy);
        
        $deleteForm = $this->createDeleteForm($stanMagazynowy);
        $editForm = $this->createForm('AppBundle\Form\StanMagazynowyType', $stanMagazynowy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stanmagazynowy_edit', array('id' => $stanMagazynowy->getId()));
        }

        return $this->render('stanmagazynowy/edit.html.twig', array(
            'stanMagazynowy' => $stanMagazynowy,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a stanMagazynowy entity.
     *
     * @Route("/{id}", name="stanmagazynowy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, StanMagazynowy $stanMagazynowy)
    {
        $this->denyAccessUnlessGranted(StanMagazynowyVoter::DELETE, $stanMagazynowy);
        
        $form = $this->createDeleteForm($stanMagazynowy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stanMagazynowy);
            $em->flush();
        }

        return $this->redirectToRoute('stanmagazynowy_index');
    }

    /**
     * Creates a form to delete a stanMagazynowy entity.
     *
     * @param StanMagazynowy $stanMagazynowy The stanMagazynowy entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StanMagazynowy $stanMagazynowy)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stanmagazynowy_delete', array('id' => $stanMagazynowy->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

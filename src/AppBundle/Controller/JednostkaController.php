<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jednostka;
use AppBundle\Security\JednostkaVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Jednostka controller.
 *
 * @Route("jednostka")
 */
class JednostkaController extends Controller
{
    /**
     * Lists all jednostka entities.
     *
     * @Route("/", name="jednostka_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(JednostkaVoter::VIEW, new Jednostka());
        
        $em = $this->getDoctrine()->getManager();

        $jednostkas = $em->getRepository('AppBundle:Jednostka')->findAll();

        return $this->render('jednostka/index.html.twig', array(
            'jednostkas' => $jednostkas,
        ));
    }

    /**
     * Creates a new jednostka entity.
     *
     * @Route("/new", name="jednostka_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $jednostka = new Jednostka();
        
        $this->denyAccessUnlessGranted(JednostkaVoter::ADD, $jednostka);
        
        $form = $this->createForm('AppBundle\Form\JednostkaType', $jednostka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jednostka);
            $em->flush();

            return $this->redirectToRoute('jednostka_show', array('id' => $jednostka->getId()));
        }

        return $this->render('jednostka/new.html.twig', array(
            'jednostka' => $jednostka,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jednostka entity.
     *
     * @Route("/{id}", name="jednostka_show")
     * @Method("GET")
     */
    public function showAction(Jednostka $jednostka)
    {
        $this->denyAccessUnlessGranted(JednostkaVoter::VIEW, $jednostka);
        
        $deleteForm = $this->createDeleteForm($jednostka);

        return $this->render('jednostka/show.html.twig', array(
            'jednostka' => $jednostka,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing jednostka entity.
     *
     * @Route("/{id}/edit", name="jednostka_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Jednostka $jednostka)
    {
        $this->denyAccessUnlessGranted(JednostkaVoter::EDIT, $jednostka);
        
        $deleteForm = $this->createDeleteForm($jednostka);
        $editForm = $this->createForm('AppBundle\Form\JednostkaType', $jednostka);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jednostka_edit', array('id' => $jednostka->getId()));
        }

        return $this->render('jednostka/edit.html.twig', array(
            'jednostka' => $jednostka,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jednostka entity.
     *
     * @Route("/{id}", name="jednostka_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Jednostka $jednostka)
    {
        $this->denyAccessUnlessGranted(JednostkaVoter::DELETE, $jednostka);
        
        $form = $this->createDeleteForm($jednostka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jednostka);
            $em->flush();
        }

        return $this->redirectToRoute('jednostka_index');
    }

    /**
     * Creates a form to delete a jednostka entity.
     *
     * @param Jednostka $jednostka The jednostka entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Jednostka $jednostka)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jednostka_delete', array('id' => $jednostka->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

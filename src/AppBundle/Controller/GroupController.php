<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Security\GroupVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Group controller.
 *
 * @Route("group")
 */
class GroupController extends Controller
{
    /**
     * Lists all group entities.
     *
     * @Route("/", name="group_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(GroupVoter::VIEW, new Group());
        
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AppBundle:Group')->findAll();

        return $this->render('group/index.html.twig', array(
            'groups' => $groups,
        ));
    }

    /**
     * Creates a new group entity.
     *
     * @Route("/new", name="group_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $group = new Group();
        
        $this->denyAccessUnlessGranted(GroupVoter::ADD, $group);
        
        $form = $this->createForm('AppBundle\Form\GroupType', $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('group_show', array('id' => $group->getId()));
        }

        return $this->render('group/new.html.twig', array(
            'group' => $group,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a group entity.
     *
     * @Route("/{id}", name="group_show")
     * @Method("GET")
     */
    public function showAction(Group $group)
    {
        $this->denyAccessUnlessGranted(GroupVoter::VIEW, $group);
        
        $deleteForm = $this->createDeleteForm($group);

        return $this->render('group/show.html.twig', array(
            'group' => $group,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing group entity.
     *
     * @Route("/{id}/edit", name="group_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Group $group)
    {
        $this->denyAccessUnlessGranted(GroupVoter::EDIT, $group);
        
        $deleteForm = $this->createDeleteForm($group);
        $editForm = $this->createForm('AppBundle\Form\GroupType', $group);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('group_edit', array('id' => $group->getId()));
        }

        return $this->render('group/edit.html.twig', array(
            'group' => $group,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a group entity.
     *
     * @Route("/{id}", name="group_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Group $group)
    {
        $this->denyAccessUnlessGranted(GroupVoter::DELETE, $group);
        
        $form = $this->createDeleteForm($group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
        }

        return $this->redirectToRoute('group_index');
    }

    /**
     * Creates a form to delete a group entity.
     *
     * @param Group $group The group entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Group $group)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('group_delete', array('id' => $group->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

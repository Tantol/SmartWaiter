<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gallery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\GalleryVoter;

/**
 * Gallery controller.
 *
 * @Route("gallery")
 */
class GalleryController extends Controller
{
    /**
     * Lists all gallery entities.
     *
     * @Route("/", name="gallery_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(GalleryVoter::VIEW, new Gallery());

        $em = $this->getDoctrine()->getManager();

        $galleries = $em->getRepository('AppBundle:Gallery')->findAll();

        return $this->render('gallery/index.html.twig', array(
            'galleries' => $galleries,
        ));
    }

    /**
     * Creates a new gallery entity.
     *
     * @Route("/new", name="gallery_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $gallery = new Gallery();
        $this->denyAccessUnlessGranted(GalleryVoter::ADD, $gallery);

        $form = $this->createForm('AppBundle\Form\GalleryType', $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('name')->getData();
            $imageFile = $form->get('image')->getData();
            $imageName = $this->get('app.image_upload')->upload($imageFile);
            $gallery->setName($name);
            $gallery->setImage($imageName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($gallery);
            $em->flush();

            return $this->redirectToRoute('danie_new');
        }

        return $this->render('gallery/new.html.twig', array(
            'gallery' => $gallery,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gallery entity.
     *
     * @Route("/{id}", name="gallery_show")
     * @Method("GET")
     */
    public function showAction(Gallery $gallery)
    {
        $this->denyAccessUnlessGranted(GalleryVoter::VIEW, $gallery);

        $deleteForm = $this->createDeleteForm($gallery);

        return $this->render('gallery/show.html.twig', array(
            'gallery' => $gallery,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gallery entity.
     *
     * @Route("/{id}/edit", name="gallery_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Gallery $gallery)
    {
        $this->denyAccessUnlessGranted(GalleryVoter::EDIT, $gallery);

        $deleteForm = $this->createDeleteForm($gallery);
        $editForm = $this->createForm('AppBundle\Form\GalleryType', $gallery);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
             $imageFile = $editForm->get('image')->getData();

            if(null != $imageFile) {
                //remove the old image
                $oldImg = $this->getDoctrine()->getRepository('AppBundle:Gallery')->find($gallery);
                $this->get('app.image_remove')->removeFile($oldImg->getImage());

                //upload the new image
                $img = $this->get('app.image_upload')->upload($imageFile);

                //update in the db the old img name with the new one
                $gallery->setImage($img);
                $this->getDoctrine()->getManager()->flush();

                //return to the current page
                return $this->redirectToRoute('gallery_edit',['id'=>$gallery->getId()]);
            } else {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('gallery_edit',['id'=>$gallery->getId()]);
            }
        }

        return $this->render('gallery/edit.html.twig', array(
            'gallery' => $gallery,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gallery entity.
     *
     * @Route("/{id}", name="gallery_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Gallery $gallery)
    {
        $this->denyAccessUnlessGranted(GalleryVoter::DELETE, $gallery);

        $form = $this->createDeleteForm($gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gallery);
            $em->flush();
        }

        return $this->redirectToRoute('gallery_index');
    }

    /**
     * Creates a form to delete a gallery entity.
     *
     * @param Gallery $gallery The gallery entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gallery $gallery)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gallery_delete', array('id' => $gallery->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

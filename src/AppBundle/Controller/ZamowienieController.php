<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Zamowienie;
use AppBundle\Security\ZamowienieVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
        $em = $this->getDoctrine()->getManager();
        
        if (!$this->get('session')->has('zamowienie')){
            $zamowienie = new Zamowienie();
            $this->get('session')->set('zamowienie', $zamowienie);
        } else {
            $zamowienie = $this->get('session')->get('zamowienie');
        }
        
        $this->denyAccessUnlessGranted(ZamowienieVoter::ADD, $zamowienie);
        
        $zamowienieForm = $this->createForm('AppBundle\Form\ZamowienieType', $zamowienie);
        $zamowienieForm->handleRequest($request);

        if ($zamowienieForm->isSubmitted() && $zamowienieForm->isValid()) {
            $dbZamowienie = new Zamowienie();
            $dbZamowienie->setCzasZlozenia(new \DateTime);
            $dbZamowienie->setKonto($this->getUser());
            
            $em->persist($dbZamowienie);
            
            foreach ($zamowienie->getPozycjeZamowien() as $editPozycja){
                $editPozycja->setZamowienie($dbZamowienie);
                $editPozycja->setStatus(
                        $em->getRepository('AppBundle:Status_zamowienia')
                        ->findOneBy(array('nazwa' => 'Czeka na przyjecie')));
                $em->merge($editPozycja);
            }
            
            $em->flush();
            $this->get('session')->remove('zamowienie');
            
            return $this->redirectToRoute('zamowienie_show', array('id' => $dbZamowienie->getId()));  
        }

        return $this->render('zamowienie/new.html.twig', array(
            'zamowienie' =>  $zamowienie,
            'zamowienieForm' => $zamowienieForm->createView(),
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

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Skladnik;
use AppBundle\Security\SkladnikVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Danie;

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
            
            $danie = $this->get('session')->get('danie');
            $danie->addSkladniki($skladnik);
            $this->get('session')->set('danie', $danie);
            
            $em->persist($skladnik);
            
            if ($danie->getId() != null){
                return $this->redirectToRoute('danie_edit', array('id' => $danie->getId()));
            } else {
                return $this->redirectToRoute('danie_new');
            }

        }

        return $this->render('skladnik/new.html.twig', array(
            'skladnik' => $skladnik,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Creates a new skladnik entity.
     *
     * @Route("/new/edit/{id}", name="skladnik_edit_new")
     * @Method({"GET", "POST"})
     */
    public function newEditAction(Request $request, Danie $danie)
    {
        $this->denyAccessUnlessGranted(\AppBundle\Security\DanieVoter::EDIT, $danie);
        
        
        $skladnik = new Skladnik();
        $form = $this->createForm('AppBundle\Form\SkladnikType', $skladnik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skladnik->setDanie($danie);
            $em = $this->getDoctrine()->getManager();
            $em->persist($skladnik);
            $em->flush();
            return $this->redirectToRoute('danie_edit', array('id' => $danie->getId()));
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
        

        return $this->render('skladnik/show.html.twig', array(
            'skladnik' => $skladnik,
        ));
    }

    /**
     * Displays a form to edit an existing skladnik entity.
     *
     * @Route("/{id}/edit", name="skladnik_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        // wyciaganie z sesji, na szybko ...
        $tempIle = 1;
        foreach ($this->get('session')->get('danie')->getSkladniki() as $tempSkl) {
            if ($id == $tempIle) {
                $skladnik = $tempSkl;
                break;
            }
            $tempIle += 1;
        }
        
        $this->denyAccessUnlessGranted(SkladnikVoter::EDIT, $skladnik);
        
        $deleteForm = $this->createDeleteForm($skladnik, $id);
        $editForm = $this->createForm('AppBundle\Form\SkladnikType', $skladnik);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            // tu byls slasch ? todo
            return $this->redirectToRoute('skladnik_edit', array('id' => $id));
        }

        return $this->render('skladnik/edit.html.twig', array(
            'skladnik' => $skladnik,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'id' => $id,
        ));
    }
    
    /**
     * Deletes a skladnik from danie.
     *
     * @Route("/{id}/deleteD", name="skladnik_danie_delete")
     */
    public function deleteFromDanieAction($id)
    {
        
        $danie = $this->get('session')->get('danie');
        
        $this->denyAccessUnlessGranted(\AppBundle\Security\DanieVoter::DELETE, $danie);
        
        $em = $this->getDoctrine()->getManager();
        
        $tempIle = 1;
        foreach ($danie->getSkladniki()  as $tempSkl) {
            if ($id == $tempIle) {
                $danie->removeSkladniki($tempSkl);
                $em->remove($tempSkl);
                break;
            }
            $tempIle += 1;
        }
        
        $this->get('session')->set('danie', $danie);
        return $this->redirectToRoute('danie_new'); 
    }

    /**
     * Deletes a skladnik entity.
     *
     * @Route("/{id}/delete", name="skladnik_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Skladnik $skladnik)
    {
        $this->denyAccessUnlessGranted(SkladnikVoter::DELETE, $skladnik);
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($skladnik);
            $em->persist($skladnik->getDanie());
            $em->flush();

        return $this->redirectToRoute('danie_edit', array('id' => $skladnik->getDanie()->getId()));
    }

}

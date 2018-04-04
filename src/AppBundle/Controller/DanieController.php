<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Danie;
use AppBundle\Security\DanieVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Danie controller.
 *
 * @Route("danie")
 */
class DanieController extends Controller
{
    /**
     * Lists all danie entities.
     *
     * @Route("/", name="danie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(DanieVoter::VIEW, new Danie());
        
        $em = $this->getDoctrine()->getManager();

        $danies = $em->getRepository('AppBundle:Danie')->findAll();

        return $this->render('danie/index.html.twig', array(
            'danies' => $danies,
        ));
    }

    /**
     * Creates a new danie entity.
     *
     * @Route("/new", name="danie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        
        if (!$this->get('session')->has('danie')){
            $danie = new Danie();
            $this->get('session')->set('danie', $danie);
        } else {
            $danie = $this->get('session')->get('danie');
        }
        
        $this->denyAccessUnlessGranted(DanieVoter::ADD, $danie);
        
        $form = $this->createForm('AppBundle\Form\DanieType', $danie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dbDanie = new Danie();
            
            $skladniki = $danie->getSkladniki();
            
            $tempKalorie = 0;
            // $tempDostepne = sizeof($skladniki);
            foreach($skladniki as $skladnik){
                $tempKalorie += $skladnik->getProdukt()->getIloscKalorii() * $skladnik->getIlosc();
                /*
                $tempProduktStanMagazynowy = $tempProdukt->getStanyMagazynowe();
                if ($tempProduktStanMagazynowy !== null){
                    $tempWymaganaIlosc = $tempIlosc;
                    foreach ($tempProduktStanMagazynowy as $stan){
                        $tempWymaganaIlosc -= $stan->getIlosc();
                        
                        if ($tempWymaganaIlosc <= 0){
                            $tempDostepne--;
                            break;
                        }
                    }
                }
                 */
                    
            }
            /*
            if ($tempDostepne === 0){
                $dbDanie->setDostepne(1);
            } else {
                $dbDanie->setDostepne(0);
            }
            */
            $dbDanie->setDostepne(0);
            $dbDanie->setIloscKalorii($tempKalorie);
            
            $dbDanie->setCena($danie->getCena());
            $dbDanie->setCzasPrzygotowania($danie->getCzasPrzygotowania());
            $dbDanie->setJednostka($danie->getJednostka());
            $dbDanie->setNazwa($danie->getNazwa());
            $dbDanie->setRodzaj($danie->getRodzaj());
            
            $em->persist($dbDanie);
            
            foreach ($skladniki as $editSkladnik){
                $editSkladnik->setDanie($dbDanie);
                $em->merge($editSkladnik);
            }
            
            $em->flush();
            $this->get('session')->remove('danie');

            return $this->redirectToRoute('danie_show', array('id' => $dbDanie->getId()));
        }

        return $this->render('danie/new.html.twig', array(
            'danie' => $danie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a danie entity.
     *
     * @Route("/{id}", name="danie_show")
     * @Method("GET")
     */
    public function showAction(Danie $danie)
    {
        $this->denyAccessUnlessGranted(DanieVoter::VIEW, $danie);
        
        $deleteForm = $this->createDeleteForm($danie);

        return $this->render('danie/show.html.twig', array(
            'danie' => $danie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing danie entity.
     *
     * @Route("/{id}/edit", name="danie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Danie $danie)
    {
        $this->denyAccessUnlessGranted(DanieVoter::EDIT, $danie);
        
        $deleteForm = $this->createDeleteForm($danie);
        $editForm = $this->createForm('AppBundle\Form\DanieType', $danie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('danie_edit', array('id' => $danie->getId()));
        }

        return $this->render('danie/edit.html.twig', array(
            'danie' => $danie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a danie entity.
     *
     * @Route("/{id}", name="danie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Danie $danie)
    {
        $this->denyAccessUnlessGranted(DanieVoter::DELETE, $danie);
        
        $form = $this->createDeleteForm($danie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($danie);
            $em->flush();
        }

        return $this->redirectToRoute('danie_index');
    }

    /**
     * Creates a form to delete a danie entity.
     *
     * @param Danie $danie The danie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Danie $danie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('danie_delete', array('id' => $danie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

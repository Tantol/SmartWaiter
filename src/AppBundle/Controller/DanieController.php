<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Danie;
use AppBundle\Security\DanieVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Zamowienie;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Doctrine\Common\Collections\ArrayCollection;

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
        $em = $this->getDoctrine()->getManager();

        $danies = $em->getRepository('AppBundle:Danie')->findAll();
        
        foreach($danies as $danie){
            $danie->setDostepne($this->isAvailable($danie));
        }

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
            
            /*
            $tempKalorie = 0;
            $tempDostepne = sizeof($skladniki);
            foreach($skladniki as $skladnik){
                $tempKalorie += $skladnik->getProdukt()->getIloscKalorii() * $skladnik->getIlosc();
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
            }
            */
            /*
            if ($tempDostepne === 0){
                $dbDanie->setDostepne(1);
            } else {
                $dbDanie->setDostepne(0);
            }
            */
            $dbDanie->setDostepne(0);
            $dbDanie->setIloscKalorii($danie->getIloscKalorii());
            $dbDanie->setCena($danie->getCena());
            $dbDanie->setCzasPrzygotowania($danie->getCzasPrzygotowania());
            $dbDanie->setJednostka($danie->getJednostka());
            $dbDanie->setNazwa($danie->getNazwa());
            $dbDanie->setRodzaj($danie->getRodzaj());
            $dbDanie->setImage($danie->getImage());
            $dbDanie->setObjetosc($danie->getObjetosc());
            
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
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Danie $danie)
    {
        $this->denyAccessUnlessGranted(DanieVoter::VIEW, $danie);
        
        $danie->setDostepne($this->isAvailable($danie));
        
        $deleteForm = $this->createDeleteForm($danie);
        
        $zamowienieForm = $this->createFormBuilder()
        ->add('ilosc', RangeType::class, array(
            'attr' => array('min' => 1, 'max' => $danie->getDostepne())))
        ->getForm();
        $zamowienieForm->handleRequest($request);
        
        if ($zamowienieForm->isSubmitted() && $zamowienieForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $pozycja = new \AppBundle\Entity\Pozycja_zamowienia();
            $pozycja->setCenaJedn($danie->getCena());
            $pozycja->setPrzewidywanyCzasPrzygotowania($danie->getCzasPrzygotowania());
            $pozycja->setDanie($danie);
            $pozycja->setIlosc($zamowienieForm['ilosc']->getData());
            
            if ($this->get('session')->has('editZamowienie')){
                $zamowienieEdit = $this->get('session')->get('editZamowienie');
                $pozycja->setStatus(
                        $em->getRepository('AppBundle:Status_zamowienia')
                        ->findOneBy(array('nazwa' => 'Czeka na przyjecie')));
                $pozycja->setZamowienie($zamowienieEdit);
                $em->merge($pozycja);
                $em->flush();
                $this->get('session')->remove('editZamowienie');
                return $this->redirectToRoute('zamowienie_show', array('id' => $zamowienieEdit->getId()));
            } else {
                $em->persist($pozycja);

                if (!$this->get('session')->has('zamowienie')){
                    $zamowienie = new Zamowienie();
                    $this->get('session')->set('zamowienie', $zamowienie);
                } else {
                    $zamowienie = $this->get('session')->get('zamowienie');
                }

                $zamowienie->addPozycjeZamowien($pozycja);
                $this->get('session')->set('zamowienie', $zamowienie);

                return $this->redirectToRoute('zamowieniNowe');
            }
        }
        
        $errorDelete = $this->get('session')->get('errorDelete');
        $this->get('session')->remove('errorDelete');

        return $this->render('danie/show.html.twig', array(
            'danie' => $danie,
            'delete_form' => $deleteForm->createView(),
            'zamowienie_form' => $zamowienieForm->createView(),
            'errorDelete' => $errorDelete,
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
        
        $danie->setIloscKalorii(null);
        $deleteForm = $this->createDeleteForm($danie);
        $editForm = $this->createForm('AppBundle\Form\DanieType', $danie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('danie_show', array('id' => $danie->getId()));
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
            if (!$danie->getPozycjeZamowien()->isEmpty()){
                $this->get('session')->set('errorDelete', 'Nie mozesz usunac dania, ktore jest przypiete do zamowienia.'
                        . ' Aby to zrobic, usun wpierw zamowienie zawierajace to danie');
                return $this->redirectToRoute('danie_show', array(
                   'id' => $danie->getId(),
                ));
            } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($danie);
            $em->flush();
            }
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
    
    private function isAvailable(Danie $danie){
        
        $skladniki = $danie->getSkladniki();
        
        if (count($skladniki) === 0){
            return 0;
        }
        
        $tempDostepnosc = 999;

        foreach($skladniki as $skladnik){
            $produkt = $skladnik->getProdukt();
            $wMagazynie = 0;
            
            foreach($produkt->getStanyMagazynowe() as $stan){
                $wMagazynie += $stan->getIlosc();
            }

            $temp = $wMagazynie/$skladnik->getIlosc();
            $skladnik->setDostepne(floor($temp));

            if ($temp < $tempDostepnosc){
                $tempDostepnosc = $temp;
            }
        }
        
        return floor($tempDostepnosc);
    }
}

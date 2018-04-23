<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pozycja_zamowienia;
use AppBundle\Security\Pozycja_zamowieniaVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pozycja_zamowienium controller.
 *
 * @Route("pozycja_zamowienia")
 */
class Pozycja_zamowieniaController extends Controller
{
    /**
     * Lists all pozycja_zamowienium entities.
     *
     * @Route("/", name="pozycja_zamowienia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::VIEW, new Pozycja_zamowienia());
        
        $em = $this->getDoctrine()->getManager();
        
        $pozycja_zamowienias = $em->getRepository('AppBundle:Pozycja_zamowienia')->findAllForCook();

        return $this->render('pozycja_zamowienia/index.html.twig', array(
            'data' => $pozycja_zamowienias,
        ));
    }

    /**
     * Creates a new pozycja_zamowienium entity.
     *
     * @Route("/new", name="pozycja_zamowienia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pozycja_zamowienium = new Pozycja_zamowienia();
        
        //$this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::ADD, $pozycja_zamowienium);
        
        $form = $this->createForm('AppBundle\Form\Pozycja_zamowieniaType', $pozycja_zamowienium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $zamowienie = $this->get('session')->get('zamowienie');
            
            $pozycja_zamowienium->setCenaJedn($pozycja_zamowienium->getDanie()->getCena());
            $pozycja_zamowienium->setPrzewidywanyCzasPrzygotowania($pozycja_zamowienium->getDanie()->getCzasPrzygotowania());
            $em->persist($pozycja_zamowienium);
            
            $zamowienie->addPozycjeZamowien($pozycja_zamowienium);
            $this->get('session')->set('zamowienie', $zamowienie);
            
            return $this->redirectToRoute('zamowieniNowe');
        }

        return $this->render('pozycja_zamowienia/new.html.twig', array(
            'pozycja_zamowienium' => $pozycja_zamowienium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pozycja_zamowienium entity.
     *
     * @Route("/{id}", name="pozycja_zamowienia_show")
     * @Method("GET")
     */
    public function showAction(Pozycja_zamowienia $pozycja_zamowienium)
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::VIEW, $pozycja_zamowienium);
        
        $deleteForm = $this->createDeleteForm($pozycja_zamowienium);

        return $this->render('pozycja_zamowienia/show.html.twig', array(
            'pozycja_zamowienium' => $pozycja_zamowienium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pozycja_zamowienium entity.
     *
     * @Route("/{id}/edit", name="pozycja_zamowienia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pozycja_zamowienia $pozycja_zamowienium)
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::EDIT, $pozycja_zamowienium);
        
        $deleteForm = $this->createDeleteForm($pozycja_zamowienium);
        $editForm = $this->createForm('AppBundle\Form\Pozycja_zamowieniaType', $pozycja_zamowienium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pozycja_zamowienia_edit', array('id' => $pozycja_zamowienium->getId()));
        }

        return $this->render('pozycja_zamowienia/edit.html.twig', array(
            'pozycja_zamowienium' => $pozycja_zamowienium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a skladnik from danie.
     *
     * @Route("/{id}/deleteD", name="pozycja_zamowienia_delete")
     */
    public function deleteFromZamowienieAction($id)
    {
        $zamowienie = $this->get('session')->get('zamowienie');
        
        $this->denyAccessUnlessGranted(\AppBundle\Security\ZamowienieVoter::ADD, $zamowienie);
        
        $em = $this->getDoctrine()->getManager();
        
        $tempIle = 1;
        foreach ($zamowienie->getPozycjeZamowien()  as $temp) {
            if ($id == $tempIle) {
                $zamowienie->removePozycjeZamowien($temp);
                $em->remove($temp);
                break;
            }
            $tempIle += 1;
        }
        
        $this->get('session')->set('zamowienie', $zamowienie);
        return $this->redirectToRoute('zamowieniNowe'); 
    }

        /**
     * Deletes a skladnik entity.
     *
     * @Route("/{id}/delete", name="pozycja_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Pozycja_zamowienia $pozycja)
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::DELETE, $pozycja);
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($pozycja);
            $em->persist($pozycja->getZamowienie());
            $em->flush();

        return $this->redirectToRoute('zamowienie_edit', array('id' => $pozycja->getZamowienie()->getId()));
    }
    
    /**
     * Displays a form to edit an existing zamowienie entity.
     *
     * @Route("/{id}/status{status}", name="pozycja_status")
     * @Method({"GET"})
     */
    public function editStatusAction(Request $request, Pozycja_zamowienia $pozycja, $status)
    {
        $this->denyAccessUnlessGranted(Pozycja_zamowieniaVoter::EDIT, $pozycja);
        $em = $this->getDoctrine()->getManager();
        
        if ($status === 'W trakcie realizacji'){
            $pozycja->setKucharz($this->getUser()->getPracownik());
            $pozycja->setCzasPrzyjecia(new \DateTime);
            
            $this->updateStan($pozycja);
            
        } else if ($status === 'Do wydania'){
            $pozycja->setCzasWydania(new \DateTime);
        } else if ($status === 'Zrealizowane'){
            $pozycja->setKelner($this->getUser()->getPracownik());
            
            $czyWszystko = 1;
            $zamowienie = $pozycja->getZamowienie();
            $wszystkiePozycje = $zamowienie->getPozycjeZamowien();
            foreach($wszystkiePozycje as $temp){
                if (($temp->getStatus()->getNazwa() === 'Zrealizowane') || ($temp->getStatus()->getNazwa() === 'Niezrealizowane')){
                    $czyWszystko += 1;
                }
            }
            
            if (count($wszystkiePozycje) === $czyWszystko){
                $zamowienie->setCzasRealizacji(new \DateTime);
            }
            
        } else if ($status === 'Niezrealizowane'){
            $pozycja->setKelner($this->getUser()->getPracownik());
            
            $czyWszystko = 1;
            $zamowienie = $pozycja->getZamowienie();
            $wszystkiePozycje = $zamowienie->getPozycjeZamowien();
            foreach($wszystkiePozycje as $temp){
                if (($temp->getStatus()->getNazwa() === 'Zrealizowane') || ($temp->getStatus()->getNazwa() === 'Niezrealizowane')){
                    $czyWszystko += 1;
                }
            }
            
            if (count($wszystkiePozycje) === $czyWszystko){
                $zamowienie->setCzasRealizacji(new \DateTime);
            }
        }
        
        $pozycja->setStatus(
                        $em->getRepository('AppBundle:Status_zamowienia')
                        ->findOneBy(array('nazwa' => $status)));
        
        $em->flush();
        
        return $this->redirectToRoute('pozycja_zamowienia_index');
    }
    
     private function updateStan(Pozycja_zamowienia $pozycja){
        
        $em = $this->getDoctrine()->getManager();
        
        //$stanMagazynowy = $em->getRepository('AppBundle:StanMagazynowy')->findAll();
        
        foreach ($pozycja->getDanie()->getSkladniki() as $skladnik){
            $ilosc = $skladnik->getIlosc() * $pozycja->getIlosc();
            $kosztWytPoz = 0;
            foreach ($skladnik->getProdukt()->getStanyMagazynowe() as $stan){
                
                $tempIlosc = $stan->getIlosc() - $ilosc;
                if ($tempIlosc === 0){
                    $kosztWytPoz += $stan->getIlosc() * $stan->getCena();
                    $ilosc -= $stan->getIlosc();
                    $em->remove($stan);
                } else if ($tempIlosc > 0){
                    $stan->setIlosc($tempIlosc);
                    $kosztWytPoz += $ilosc * $stan->getCena();
                    $ilosc = 0;
                    $em->merge($stan);
                    break;
                } else if ($tempIlosc < 0) {
                    $kosztWytPoz += $stan->getIlosc() * $stan->getCena();
                    $ilosc -= $stan->getIlosc();
                    $em->remove($stan);
                }
            }
        }
        $pozycja->setKosztWytPoz($kosztWytPoz);
    }
}

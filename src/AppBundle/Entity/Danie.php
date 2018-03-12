<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:00
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="danie")
 */
class Danie{


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Rodzaj", inversedBy="dania")
     * @ORM\JoinColumn(name="rodzaj", referencedColumnName="id")
     */
    protected $rodzaj;

    /**
     * @ORM\ManyToOne(targetEntity="Jednostka", inversedBy="dania")
     * @ORM\JoinColumn(name="jednostka", referencedColumnName="id")
     */
    protected $jednostka;

    /**
     * @ORM\OneToMany(targetEntity="Skladnik", mappedBy="danie")
     */
    protected $skladniki;

    /**
     * @ORM\OneToMany(targetEntity="Pozycja_zamowienia", mappedBy="danie")
     */
    protected $pozycje_zamowien;

    public function __construct()    {
        $this->skladniki= new ArrayCollection();
        $this->pozycje_zamowien= new ArrayCollection();
    }


    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $nazwa;


    /**
     * @ORM\Column(type="datetime")
     */
    protected $czas_przygotowania;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $koszt_przygotowania;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $cena;

    /**
     * @ORM\Column(type="integer")
     */
    protected $dostepne;


    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $ilosc_kalorii;





    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set czasPrzygotowania
     *
     * @param \DateTime $czasPrzygotowania
     *
     * @return Danie
     */
    public function setCzasPrzygotowania($czasPrzygotowania)
    {
        $this->czas_przygotowania = $czasPrzygotowania;

        return $this;
    }

    /**
     * Get czasPrzygotowania
     *
     * @return \DateTime
     */
    public function getCzasPrzygotowania()
    {
        return $this->czas_przygotowania;
    }

    /**
     * Set kosztPrzygotowania
     *
     * @param string $kosztPrzygotowania
     *
     * @return Danie
     */
    public function setKosztPrzygotowania($kosztPrzygotowania)
    {
        $this->koszt_przygotowania = $kosztPrzygotowania;

        return $this;
    }

    /**
     * Get kosztPrzygotowania
     *
     * @return string
     */
    public function getKosztPrzygotowania()
    {
        return $this->koszt_przygotowania;
    }

    /**
     * Set cena
     *
     * @param \DateTime $cena
     *
     * @return Danie
     */
    public function setCena($cena)
    {
        $this->cena = $cena;

        return $this;
    }

    /**
     * Get cena
     *
     * @return \DateTime
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * Set dostepne
     *
     * @param integer $dostepne
     *
     * @return Danie
     */
    public function setDostepne($dostepne)
    {
        $this->dostepne = $dostepne;

        return $this;
    }

    /**
     * Get dostepne
     *
     * @return integer
     */
    public function getDostepne()
    {
        return $this->dostepne;
    }

    /**
     * Set iloscKalorii
     *
     * @param string $iloscKalorii
     *
     * @return Danie
     */
    public function setIloscKalorii($iloscKalorii)
    {
        $this->ilosc_kalorii = $iloscKalorii;

        return $this;
    }

    /**
     * Get iloscKalorii
     *
     * @return string
     */
    public function getIloscKalorii()
    {
        return $this->ilosc_kalorii;
    }

    /**
     * Set rodzaj
     *
     * @param \AppBundle\Entity\Rodzaj $rodzaj
     *
     * @return Danie
     */
    public function setRodzaj(\AppBundle\Entity\Rodzaj $rodzaj = null)
    {
        $this->rodzaj = $rodzaj;

        return $this;
    }

    /**
     * Get rodzaj
     *
     * @return \AppBundle\Entity\Rodzaj
     */
    public function getRodzaj()
    {
        return $this->rodzaj;
    }

    /**
     * Set jednostka
     *
     * @param \AppBundle\Entity\Jednostka $jednostka
     *
     * @return Danie
     */
    public function setJednostka(\AppBundle\Entity\Jednostka $jednostka = null)
    {
        $this->jednostka = $jednostka;

        return $this;
    }

    /**
     * Get jednostka
     *
     * @return \AppBundle\Entity\Jednostka
     */
    public function getJednostka()
    {
        return $this->jednostka;
    }

    /**
     * Add skladniki
     *
     * @param \AppBundle\Entity\Skladnik $skladniki
     *
     * @return Danie
     */
    public function addSkladniki(\AppBundle\Entity\Skladnik $skladniki)
    {
        $this->skladniki[] = $skladniki;

        return $this;
    }

    /**
     * Remove skladniki
     *
     * @param \AppBundle\Entity\Skladnik $skladniki
     */
    public function removeSkladniki(\AppBundle\Entity\Skladnik $skladniki)
    {
        $this->skladniki->removeElement($skladniki);
    }

    /**
     * Get skladniki
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSkladniki()
    {
        return $this->skladniki;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Danie
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Add pozycjeZamowien
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycjeZamowien
     *
     * @return Danie
     */
    public function addPozycjeZamowien(\AppBundle\Entity\Pozycja_zamowienia $pozycjeZamowien)
    {
        $this->pozycje_zamowien[] = $pozycjeZamowien;

        return $this;
    }

    /**
     * Remove pozycjeZamowien
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycjeZamowien
     */
    public function removePozycjeZamowien(\AppBundle\Entity\Pozycja_zamowienia $pozycjeZamowien)
    {
        $this->pozycje_zamowien->removeElement($pozycjeZamowien);
    }

    /**
     * Get pozycjeZamowien
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPozycjeZamowien()
    {
        return $this->pozycje_zamowien;
    }
}

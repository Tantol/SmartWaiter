<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:50
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Zamowienie;
use AppBundle\Entity\Danie;
use AppBundle\Entity\Status_zamowienia;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Pozycja_zamowieniaRepository");
 * @ORM\Table(name="pozycja_zamowienia")
 */
class Pozycja_zamowienia implements \Serializable{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Danie", inversedBy="pozycje_zamowien")
     * @ORM\JoinColumn(name="danie", referencedColumnName="id")
     */
    protected $danie;

    /**
     * @ORM\ManyToOne(targetEntity="Zamowienie", inversedBy="pozycje_zamowien")
     * @ORM\JoinColumn(name="zamowienie", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $zamowienie;

    /**
     * @ORM\Column(type="integer")
     */
    protected $ilosc;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $cena_jedn;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $przewidywany_czas_przygotowania;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $czas_przyjecia;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $czas_wydania;
    
    /**
     * @ORM\ManyToOne(targetEntity="Status_zamowienia", inversedBy="pozycja_zamowienia")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     */
    protected $status;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pracownik", inversedBy="pozycja_zamowienia_kucharz")
     * @ORM\JoinColumn(name="kucharz", referencedColumnName="id")
     */
    protected $kucharz;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pracownik", inversedBy="pozycja_zamowienia_kelner")
     * @ORM\JoinColumn(name="kelner", referencedColumnName="id")
     */
    protected $kelner;
    
    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true) 
     */
    protected $kosztWytPoz;
    
    public function serialize()
    {
      return serialize(
        [
          $this->id,
          $this->danie,
          $this->zamowienie,
          $this->ilosc,
          $this->cena_jedn,
          $this->przewidywany_czas_przygotowania,
          $this->czas_przyjecia,
          $this->czas_wydania,
          $this->status,
          $this->kucharz,
          $this->kelner,
          $this->kosztWytPoz,
        ]
      );
    }

    public function unserialize($serialized)
    {
      $data = unserialize($serialized);
      list(
        $this->id,
        $this->danie,
        $this->zamowienie,
        $this->ilosc,
        $this->cena_jedn,
        $this->przewidywany_czas_przygotowania,
        $this->czas_przyjecia,
        $this->czas_wydania,
        $this->status,
        $this->kucharz,
        $this->kelner,
        $this->kosztWytPoz,
        ) = $data;
    }
    
     /**
     * Set status
     *
     * @param \AppBundle\Entity\Status_zamowienia $status
     *
     * @return Pozycja_zamowienia
     */
    public function setStatus(\AppBundle\Entity\Status_zamowienia $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\Status_zamowienia
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set kucharz
     *
     * @param \AppBundle\Entity\Pracownik $pracownik
     *
     * @return Pozycja_zamowienia
     */
    public function setKucharz(\AppBundle\Entity\Pracownik $pracownik = null)
    {
        $this->kucharz = $pracownik;

        return $this;
    }

    /**
     * Get kucharz
     *
     * @return \AppBundle\Entity\Pracownik
     */
    public function getKucharz()
    {
        return $this->kucharz;
    }
    
    /**
     * Set kelner
     *
     * @param \AppBundle\Entity\Pracownik $pracownik
     *
     * @return Pozycja_zamowienia
     */
    public function setKelner(\AppBundle\Entity\Pracownik $pracownik = null)
    {
        $this->kelner = $pracownik;

        return $this;
    }

    /**
     * Get kelner
     *
     * @return \AppBundle\Entity\Pracownik
     */
    public function getKelner()
    {
        return $this->kucharz;
    }
    
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
     * Set ilosc
     *
     * @param string $ilosc
     *
     * @return Pozycja_zamowienia
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get ilosc
     *
     * @return string
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * Set cenaJedn
     *
     * @param string $cenaJedn
     *
     * @return Pozycja_zamowienia
     */
    public function setCenaJedn($cenaJedn)
    {
        $this->cena_jedn = $cenaJedn;

        return $this;
    }

    /**
     * Get cenaJedn
     *
     * @return string
     */
    public function getCenaJedn()
    {
        return $this->cena_jedn;
    }
    
    /**
     * Set kosztWytPoz
     *
     * @param string $cenaJedn
     *
     * @return Pozycja_zamowienia
     */
    public function setKosztWytPoz($cena)
    {
        $this->kosztWytPoz = $cena;

        return $this;
    }

    /**
     * Get kosztWytPoz
     *
     * @return string
     */
    public function getKosztWytPoz()
    {
        return $this->kosztWytPoz;
    }

    /**
     * Set danie
     *
     * @param \AppBundle\Entity\Danie $danie
     *
     * @return Pozycja_zamowienia
     */
    public function setDanie(\AppBundle\Entity\Danie $danie = null)
    {
        $this->danie = $danie;

        return $this;
    }

    /**
     * Get danie
     *
     * @return \AppBundle\Entity\Danie
     */
    public function getDanie()
    {
        return $this->danie;
    }

    /**
     * Set zamowienie
     *
     * @param \AppBundle\Entity\Zamowienie $zamowienie
     *
     * @return Pozycja_zamowienia
     */
    public function setZamowienie(\AppBundle\Entity\Zamowienie $zamowienie = null)
    {
        $this->zamowienie = $zamowienie;

        return $this;
    }

    /**
     * Get zamowienie
     *
     * @return \AppBundle\Entity\Zamowienie
     */
    public function getZamowienie()
    {
        return $this->zamowienie;
    }

    /**
     * Set czasPrzygotowania
     *
     * @param integer $czasPrzygotowania
     *
     * @return Pozycja_zamowienia
     */
    public function setPrzewidywanyCzasPrzygotowania($czasPrzygotowania)
    {
        $this->przewidywany_czas_przygotowania = $czasPrzygotowania;
    
        return $this;
    }

    /**
     * Get czasPrzygotowania
     *
     * @return integer
     */
    public function getPrzewidywanyCzasPrzygotowania()
    {
        return $this->przewidywany_czas_przygotowania;
    }
    
    /**
     * Set czasPrzyjecia
     *
     * @param \DateTime $czasPrzyjecia
     *
     * @return Pozycja_zamowienia
     */
    public function setCzasPrzyjecia($czas)
    {
        $this->czas_przyjecia = $czas;

        return $this;
    }

    /**
     * Get czasPrzyjecia
     *
     * @return \DateTime
     */
    public function getCzasPrzyjecia()
    {
        return $this->czas_przyjecia;
    }
    
    /**
     * Set czasWydania
     *
     * @param \DateTime $czasWydania
     *
     * @return Pozycja_zamowienia
     */
    public function setCzasWydania($czas)
    {
        $this->czas_wydania = $czas;

        return $this;
    }

    /**
     * Get czasWydania
     *
     * @return \DateTime
     */
    public function getCzasWydania()
    {
        return $this->czas_wydania;
    }
}

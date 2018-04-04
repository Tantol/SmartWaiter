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
 * @ORM\Entity
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
     * @ORM\JoinColumn(name="zamowienie", referencedColumnName="id")
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
    protected $czas_przygotowania;
    
        /**
     * @ORM\ManyToOne(targetEntity="Status_zamowienia", inversedBy="pozycja_zamowienia")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     */
    protected $status;
    
    public function serialize()
    {
      return serialize(
        [
          $this->id,
          $this->danie,
          $this->zamowienie,
          $this->ilosc,
          $this->cena_jedn,
          $this->czas_przygotowania,
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
        $this->czas_przygotowania,
        ) = $data;
    }
    
     /**
     * Set status
     *
     * @param \AppBundle\Entity\Status_zamowienia $status
     *
     * @return Zamowienie
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
    public function setCzasPrzygotowania($czasPrzygotowania)
    {
        $this->czas_przygotowania = $czasPrzygotowania;
    
        return $this;
    }

    /**
     * Get czasPrzygotowania
     *
     * @return integer
     */
    public function getCzasPrzygotowania()
    {
        return $this->czas_przygotowania;
    }
}

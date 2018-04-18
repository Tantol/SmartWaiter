<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:13
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="skladnik")
 */
class Skladnik{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="Produkt", inversedBy="skladniki")
     * @ORM\JoinColumn(name="produkt", referencedColumnName="id")
     */
    protected $produkt;

    /**
     * @ORM\ManyToOne(targetEntity="Danie", inversedBy="skladniki")
     * @ORM\JoinColumn(name="danie", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $danie;

    /**
     * @ORM\Column(type="integer")
     */
    protected $ilosc;

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
     * @param integer $ilosc
     *
     * @return Skladnik
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get ilosc
     *
     * @return integer
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * Set produkt
     *
     * @param \AppBundle\Entity\Produkt $produkt
     *
     * @return Skladnik
     */
    public function setProdukt(\AppBundle\Entity\Produkt $produkt = null)
    {
        $this->produkt = $produkt;

        return $this;
    }

    /**
     * Get produkt
     *
     * @return \AppBundle\Entity\Produkt
     */
    public function getProdukt()
    {
        return $this->produkt;
    }

    /**
     * Set danie
     *
     * @param \AppBundle\Entity\Danie $danie
     *
     * @return Skladnik
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
}

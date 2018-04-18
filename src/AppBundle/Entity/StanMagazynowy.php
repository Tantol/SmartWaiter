<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 19:28
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stan_magazynowy")
 */
class StanMagazynowy{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Dostawca", inversedBy="stany_magazynowe")
     * @ORM\JoinColumn(name="dostawca", referencedColumnName="id", nullable=true)
     */
    protected $dostawca;

    /**
     * @ORM\ManyToOne(targetEntity="Produkt", inversedBy="stany_magazynowe")
     * @ORM\JoinColumn(name="produkt",referencedColumnName="id")
     */
    protected $produkt;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $ilosc;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $cena;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $data_umieszczenia;


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
     * @return StanMagazynowy
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
     * Set cena
     *
     * @param string $cena
     *
     * @return StanMagazynowy
     */
    public function setCena($cena)
    {
        $this->cena = $cena;

        return $this;
    }

    /**
     * Get cena
     *
     * @return string
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * Set dostawca
     *
     * @param \AppBundle\Entity\Dostawca $dostawca
     *
     * @return StanMagazynowy
     */
    public function setDostawca(\AppBundle\Entity\Dostawca $dostawca = null)
    {
        $this->dostawca = $dostawca;

        return $this;
    }

    /**
     * Get dostawca
     *
     * @return \AppBundle\Entity\Dostawca
     */
    public function getDostawca()
    {
        return $this->dostawca;
    }

    /**
     * Set produkt
     *
     * @param \AppBundle\Entity\Produkt $produkt
     *
     * @return StanMagazynowy
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
     * Set dataUmieszczenia
     *
     * @param \DateTime $dataUmieszczenia
     *
     * @return StanMagazynowy
     */
    public function setDataUmieszczenia($dataUmieszczenia)
    {
        $this->data_umieszczenia = $dataUmieszczenia;

        return $this;
    }

    /**
     * Get dataUmieszczenia
     *
     * @return \DateTime
     */
    public function getDataUmieszczenia()
    {
        return $this->data_umieszczenia;
    }
}

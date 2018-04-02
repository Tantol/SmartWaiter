<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 19:21
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="dostawca")
 */
class Dostawca{


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="StanMagazynowy", mappedBy="dostawca")
     */
    protected $stany_magazynowe;

    public function __construct()    {
        $this->stany_magazynowe= new ArrayCollection();
    }


    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $nazwa;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $miejscowosc;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $ulica;

    /**
     * @ORM\Column(type="string", length=5)
     */
    protected $nr_domu;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    protected $nr_lokalu;

    /**
     * @ORM\Column(type="string", length=6)
     */
    protected $kod_pocztowy;

    /**
     * @ORM\Column(type="string", length=15)
     */
    protected $telefon;



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
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Dostawca
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
     * Set miejscowosc
     *
     * @param string $miejscowosc
     *
     * @return Dostawca
     */
    public function setMiejscowosc($miejscowosc)
    {
        $this->miejscowosc = $miejscowosc;

        return $this;
    }

    /**
     * Get miejscowosc
     *
     * @return string
     */
    public function getMiejscowosc()
    {
        return $this->miejscowosc;
    }

    /**
     * Set ulica
     *
     * @param string $ulica
     *
     * @return Dostawca
     */
    public function setUlica($ulica)
    {
        $this->ulica = $ulica;

        return $this;
    }

    /**
     * Get ulica
     *
     * @return string
     */
    public function getUlica()
    {
        return $this->ulica;
    }

    /**
     * Set nrDomu
     *
     * @param string $nrDomu
     *
     * @return Dostawca
     */
    public function setNrDomu($nrDomu)
    {
        $this->nr_domu = $nrDomu;

        return $this;
    }

    /**
     * Get nrDomu
     *
     * @return string
     */
    public function getNrDomu()
    {
        return $this->nr_domu;
    }

    /**
     * Set nrLokalu
     *
     * @param string $nrLokalu
     *
     * @return Dostawca
     */
    public function setNrLokalu($nrLokalu)
    {
        $this->nr_lokalu = $nrLokalu;

        return $this;
    }

    /**
     * Get nrLokalu
     *
     * @return string
     */
    public function getNrLokalu()
    {
        return $this->nr_lokalu;
    }

    /**
     * Set kodPocztowy
     *
     * @param string $kodPocztowy
     *
     * @return Dostawca
     */
    public function setKodPocztowy($kodPocztowy)
    {
        $this->kod_pocztowy = $kodPocztowy;

        return $this;
    }

    /**
     * Get kodPocztowy
     *
     * @return string
     */
    public function getKodPocztowy()
    {
        return $this->kod_pocztowy;
    }

    /**
     * Set telefon
     *
     * @param string $telefon
     *
     * @return Dostawca
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get telefon
     *
     * @return string
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Add stanyMagazynowe
     *
     * @param \AppBundle\Entity\StanMagazynowy $stanyMagazynowe
     *
     * @return Dostawca
     */
    public function addStanyMagazynowe(\AppBundle\Entity\StanMagazynowy $stanyMagazynowe)
    {
        $this->stany_magazynowe[] = $stanyMagazynowe;

        return $this;
    }

    /**
     * Remove stanyMagazynowe
     *
     * @param \AppBundle\Entity\StanMagazynowy $stanyMagazynowe
     */
    public function removeStanyMagazynowe(\AppBundle\Entity\StanMagazynowy $stanyMagazynowe)
    {
        $this->stany_magazynowe->removeElement($stanyMagazynowe);
    }

    /**
     * Get stanyMagazynowe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStanyMagazynowe()
    {
        return $this->stany_magazynowe;
    }
    
    public function __toString() {
        return $this->nazwa;
    }
}

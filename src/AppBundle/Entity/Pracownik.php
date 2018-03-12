<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:22
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pracownik")
 */
class Pracownik{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Stanowisko", inversedBy="pracownicy")
     * @ORM\JoinColumn(name="stanowisko", referencedColumnName="id")
     */
    protected $stanowisko;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $imie;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $nazwisko;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $miejscowosc;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $ulica;

    /**
     * @ORM\Column(type="string", length=8)
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
     * Set imie
     *
     * @param string $imie
     *
     * @return Pracownik
     */
    public function setImie($imie)
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     *
     * @return Pracownik
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set miejscowosc
     *
     * @param string $miejscowosc
     *
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * Set stanowisko
     *
     * @param \AppBundle\Entity\Stanowisko $stanowisko
     *
     * @return Pracownik
     */
    public function setStanowisko(\AppBundle\Entity\Stanowisko $stanowisko = null)
    {
        $this->stanowisko = $stanowisko;

        return $this;
    }

    /**
     * Get stanowisko
     *
     * @return \AppBundle\Entity\Stanowisko
     */
    public function getStanowisko()
    {
        return $this->stanowisko;
    }
}
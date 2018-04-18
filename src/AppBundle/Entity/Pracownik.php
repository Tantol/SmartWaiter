<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:22
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\OneToMany(targetEntity="Pozycja_zamowienia", mappedBy="kucharz")
     */
    protected $pozycja_zamowienia_kucharz;
    
    /**
     * @ORM\OneToMany(targetEntity="Pozycja_zamowienia", mappedBy="kelner")
     */
    protected $pozycja_zamowienia_kelner;    

    public function __construct()    {
        $this->pozycja_zamowienia_kucharz = new ArrayCollection();
        $this->pozycja_zamowienia_kelner = new ArrayCollection();
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
     * Add pozycjaZamowieniaKucharz
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycjaZamowieniaKucharz
     *
     * @return Pracownik
     */
    public function addPozycjaZamowieniaKucharz(\AppBundle\Entity\Pozycja_zamowienia $pozycjaZamowieniaKucharz)
    {
        $this->pozycja_zamowienia_kucharz[] = $pozycjaZamowieniaKucharz;
    
        return $this;
    }

    /**
     * Remove pozycjaZamowieniaKucharz
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycjaZamowieniaKucharz
     */
    public function removePozycjaZamowieniaKucharz(\AppBundle\Entity\Pozycja_zamowienia $pozycjaZamowieniaKucharz)
    {
        $this->pozycja_zamowienia_kucharz->removeElement($pozycjaZamowieniaKucharz);
    }

    /**
     * Get pozycjaZamowieniaKucharz
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPozycjaZamowieniaKucharz()
    {
        return $this->pozycja_zamowienia_kucharz;
    }

    /**
     * Add pozycjaZamowieniaKelner
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycjaZamowieniaKelner
     *
     * @return Pracownik
     */
    public function addPozycjaZamowieniaKelner(\AppBundle\Entity\Pozycja_zamowienia $pozycjaZamowieniaKelner)
    {
        $this->pozycja_zamowienia_kelner[] = $pozycjaZamowieniaKelner;
    
        return $this;
    }

    /**
     * Remove pozycjaZamowieniaKelner
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycjaZamowieniaKelner
     */
    public function removePozycjaZamowieniaKelner(\AppBundle\Entity\Pozycja_zamowienia $pozycjaZamowieniaKelner)
    {
        $this->pozycja_zamowienia_kelner->removeElement($pozycjaZamowieniaKelner);
    }

    /**
     * Get pozycjaZamowieniaKelner
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPozycjaZamowieniaKelner()
    {
        return $this->pozycja_zamowienia_kelner;
    }
    
    public function __toString() {
        return $this->imie . ' ' . $this->nazwisko;
    }
}

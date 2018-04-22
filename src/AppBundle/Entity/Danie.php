<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:00
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="danie")
 */
class Danie implements \Serializable{


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
     * @ORM\Column(type="integer")
     */
    protected $objetosc;

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
     * @ORM\Column(type="integer")
     */
    protected $czas_przygotowania;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    protected $cena;

    protected $dostepne = 5;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $ilosc_kalorii;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="dania")
     * @ORM\JoinColumn(name="image", referencedColumnName="id", nullable=false)
     */
    protected $image;
    
    public function serialize()
    {
      return serialize(
        [
          $this->id,
          $this->rodzaj,
          $this->jednostka,
          $this->objetosc,
          $this->skladniki,
          $this->pozycje_zamowien,
          $this->nazwa,
          $this->czas_przygotowania,
          $this->cena,
          $this->dostepne,
          $this->image,
        ]
      );
    }

    public function unserialize($serialized)
    {
      $data = unserialize($serialized);
      list(
        $this->id,
        $this->rodzaj,
        $this->jednostka,
        $this->objetosc,
        $this->skladniki,
        $this->pozycje_zamowien,
        $this->nazwa,
        $this->czas_przygotowania,
        $this->cena,
        $this->dostepne,
        $this->image,
        ) = $data;
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
    
    public function __toString() {
        return $this->nazwa;
    }

    /**
     * Set czasPrzygotowania
     *
     * @param integer $czasPrzygotowania
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
     * @return integer
     */
    public function getCzasPrzygotowania()
    {
        return $this->czas_przygotowania;
    }

    /**
     * Set image.
     *
     * @param \AppBundle\Entity\Gallery $image
     *
     * @return Danie
     */
    public function setImage(\AppBundle\Entity\Gallery $image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image.
     *
     * @return \AppBundle\Entity\Gallery
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set objetosc.
     *
     * @param int $objetosc
     *
     * @return Danie
     */
    public function setObjetosc($objetosc)
    {
        $this->objetosc = $objetosc;
    
        return $this;
    }

    /**
     * Get objetosc.
     *
     * @return int
     */
    public function getObjetosc()
    {
        return $this->objetosc;
    }
}

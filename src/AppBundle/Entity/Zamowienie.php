<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:45
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZamowienieRepository")
 * @ORM\Table(name="zamowienie")
 */
class Zamowienie implements \Serializable{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="zamowienia")
     * @ORM\JoinColumn(name="konto", referencedColumnName="id", nullable=true)
     */
    protected $konto;

    /**
     * @ORM\OneToMany(targetEntity="Pozycja_zamowienia", mappedBy="zamowienie", cascade={"persist"})
     */
    protected $pozycje_zamowien;

    public function __construct(){
        $this->pozycje_zamowien=new ArrayCollection();
    }

    /**
     * @ORM\Column(type="datetime")
     */
    protected $czas_zlozenia;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $czas_realizacji;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $uregulowane;
    
    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $nrStolika;
    
    public function serialize()
    {
      return serialize(
        [
          $this->id,
          $this->konto,
          $this->pozycje_zamowien,
          $this->czas_zlozenia,
          $this->czas_realizacji,
          $this->uregulowane,
          $this->nrStolika,
        ]
      );
    }

    public function unserialize($serialized)
    {
      $data = unserialize($serialized);
      list(
        $this->id,
          $this->konto,
          $this->pozycje_zamowien,
          $this->czas_zlozenia,
          $this->czas_realizacji,
          $this->uregulowane,
          $this->nrStolika,
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
     * Set czasZlozenia
     *
     * @param \DateTime $czasZlozenia
     *
     * @return Zamowienie
     */
    public function setCzasZlozenia($czasZlozenia)
    {
        $this->czas_zlozenia = $czasZlozenia;

        return $this;
    }

    /**
     * Get czasZlozenia
     *
     * @return \DateTime
     */
    public function getCzasZlozenia()
    {
        return $this->czas_zlozenia;
    }

    /**
     * Set czasRealizacji
     *
     * @param \DateTime $czasRealizacji
     *
     * @return Zamowienie
     */
    public function setCzasRealizacji($czasRealizacji)
    {
        $this->czas_realizacji = $czasRealizacji;

        return $this;
    }

    /**
     * Get czasRealizacji
     *
     * @return \DateTime
     */
    public function getCzasRealizacji()
    {
        return $this->czas_realizacji;
    }

    /**
     * Set konto
     *
     * @param \AppBundle\Entity\User $konto
     *
     * @return Zamowienie
     */
    public function setKonto(\AppBundle\Entity\User $konto = null)
    {
        $this->konto = $konto;

        return $this;
    }

    /**
     * Get konto
     *
     * @return \AppBundle\Entity\User
     */
    public function getKonto()
    {
        return $this->konto;
    }

    /**
     * Add pozycjeZamowien
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycjeZamowien
     *
     * @return Zamowienie
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
        return $this->konto->__toString();
    }
    
    /**
     * Set uregulowane
     *
     * @param boolean $uregulowane
     *
     * @return Zamowienie
     */
    public function setUregulowane($uregulowane)
    {
        $this->uregulowane = $uregulowane;
    
        return $this;
    }

    /**
     * Get uregulowane
     *
     * @return boolean
     */
    public function getUregulowane()
    {
        return $this->uregulowane;
    }
    
    /**
     * Set nrStolika
     *
     * @param string $nrStolika
     *
     * @return Dostawca
     */
    public function setNrStolika($nr)
    {
        $this->nrStolika = $nr;

        return $this;
    }

    /**
     * Get nrStolika
     *
     * @return string
     */
    public function getNrStolika()
    {
        return $this->nrStolika;
    }
}

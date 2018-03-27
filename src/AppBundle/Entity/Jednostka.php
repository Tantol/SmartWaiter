<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 15:41
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="jednostka")
 */
class Jednostka{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Produkt", mappedBy="jednostka")
     */
    protected $produkty;

    /**
     * @ORM\OneToMany(targetEntity="Danie", mappedBy="jednostka")
     */
    protected $dania;

    public function __construct()    {
        $this->produkty= new ArrayCollection();
        $this->dania= new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=5, unique=true)
     */
    protected $skrot;

    /**
     * @ORM\Column(type="string", length=15, unique=true)
     */
    protected $nazwa;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    protected $opis;


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
     * @return Jednostka
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
     * Set skrot
     *
     * @param string $skrot
     *
     * @return Jednostka
     */
    public function setSkrot($skrot)
    {
        $this->skrot = $skrot;

        return $this;
    }

    /**
     * Get skrot
     *
     * @return string
     */
    public function getSkrot()
    {
        return $this->skrot;
    }

    /**
     * Set opis
     *
     * @param string $opis
     *
     * @return Jednostka
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;

        return $this;
    }

    /**
     * Get opis
     *
     * @return string
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * Add produkty
     *
     * @param \AppBundle\Entity\Produkt $produkty
     *
     * @return Jednostka
     */
    public function addProdukty(\AppBundle\Entity\Produkt $produkty)
    {
        $this->produkty[] = $produkty;

        return $this;
    }

    /**
     * Remove produkty
     *
     * @param \AppBundle\Entity\Produkt $produkty
     */
    public function removeProdukty(\AppBundle\Entity\Produkt $produkty)
    {
        $this->produkty->removeElement($produkty);
    }

    /**
     * Get produkty
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProdukty()
    {
        return $this->produkty;
    }

    /**
     * Add danium
     *
     * @param \AppBundle\Entity\Danie $danium
     *
     * @return Jednostka
     */
    public function addDanium(\AppBundle\Entity\Danie $danium)
    {
        $this->dania[] = $danium;

        return $this;
    }

    /**
     * Remove danium
     *
     * @param \AppBundle\Entity\Danie $danium
     */
    public function removeDanium(\AppBundle\Entity\Danie $danium)
    {
        $this->dania->removeElement($danium);
    }

    /**
     * Get dania
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDania()
    {
        return $this->dania;
    }
    
    public function __toString() {
        return $this->nazwa;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 18:09
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="produkt")
 */
class Produkt{

    /**
     * @ORM\OneToMany(targetEntity="StanMagazynowy", mappedBy="produkt")
     * @ORM\OrderBy({"data_umieszczenia" = "ASC"})
     */
    protected $stany_magazynowe;

    /**
     * @ORM\OneToMany(targetEntity="Skladnik", mappedBy="produkt")
     */
    protected $skladniki;

    public function __construct()    {
        $this->stany_magazynowe= new ArrayCollection();
        $this->skladniki= new ArrayCollection();
        $this->zawieta_gluten=false;
    }


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=15, unique=true)
     */
    protected $nazwa;

    /**
     * @ORM\Column(type="string", length=15, unique=false, nullable=false)
     */
    protected $marka;

    /**
     * @ORM\ManyToOne(targetEntity="Jednostka", inversedBy="produkty")
     * @ORM\JoinColumn(name="jednostka",referencedColumnName="id")
     */
    protected $jednostka;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $zawieta_gluten;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $ilosc_kalorii;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\Expression(
     *     "this.getMaxStan() > this.getMinStan()",
     *     message="Maksymalny stan musi byc większy od minimalnego"
     *  )
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $max_stan;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\Expression(
     *     "this.getMinStan() < this.getMaxStan()",
     *     message="Minimalny stan musi byc mniejszy od maksymalnego"
     *  )
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $min_stan;


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
     * @return Produkt
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
     * Set marka
     *
     * @param string $marka
     *
     * @return Produkt
     */
    public function setMarka($marka)
    {
        $this->marka = $marka;

        return $this;
    }

    /**
     * Get marka
     *
     * @return string
     */
    public function getMarka()
    {
        return $this->marka;
    }

    /**
     * Add stanyMagazynowe
     *
     * @param \AppBundle\Entity\StanMagazynowy $stanyMagazynowe
     *
     * @return Produkt
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

    /**
     * Set jednostka
     *
     * @param \AppBundle\Entity\Jednostka $jednostka
     *
     * @return Produkt
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
     * @return Produkt
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

    public function __toString() {
        return $this->nazwa . ' ' . $this->marka;
    }

    /**
     * Set zawietaGluten
     *
     * @param boolean $zawietaGluten
     *
     * @return Produkt
     */
    public function setZawietaGluten($zawietaGluten)
    {
        $this->zawieta_gluten = $zawietaGluten;

        return $this;
    }

    /**
     * Get zawietaGluten
     *
     * @return boolean
     */
    public function getZawietaGluten()
    {
        return $this->zawieta_gluten;
    }


     /**
     * Set iloscKalorii
     *
     * @param string $iloscKalorii
     *
     * @return Produkt
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
     * Set maxStan
     *
     * @param string $maxStan
     *
     * @return StanMagazynowy
     */
    public function setMaxStan($maxStan)
    {
        $this->max_stan = $maxStan;

        return $this;
    }

    /**
     * Get maxStan
     *
     * @return string
     */
    public function getMaxStan()
    {
        return $this->max_stan;
    }

    /**
     * Set minStan
     *
     * @param string $minStan
     *
     * @return Produkt
     */
    public function setMinStan($minStan)
    {
        $this->min_stan = $minStan;

        return $this;
    }

    /**
     * Get minStan
     *
     * @return string
     */
    public function getMinStan()
    {
        return $this->min_stan;
    }
}

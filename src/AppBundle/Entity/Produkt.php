<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 18:09
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="produkt")
 */
class Produkt{

    /**
     * @ORM\OneToMany(targetEntity="StanMagazynowy", mappedBy="produkt")
     */
    protected $stany_magazynowe;

    /**
     * @ORM\OneToMany(targetEntity="Skladnik", mappedBy="produkt")
     */
    protected $skladniki;

    public function __construct()    {
        $this->stany_magazynowe= new ArrayCollection();
        $this->skladniki= new ArrayCollection();
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
     * @ORM\ManyToOne(targetEntity="Jednostka", inversedBy="produkty")
     * @ORM\JoinColumn(name="jednostka",referencedColumnName="id")
     */
    protected $jednostka;

    /**
     * @ORM\Column(type="integer")
     */
    protected $zawieta_gluten;




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
     * Set zawietaGluten
     *
     * @param integer $zawietaGluten
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
     * @return integer
     */
    public function getZawietaGluten()
    {
        return $this->zawieta_gluten;
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
}

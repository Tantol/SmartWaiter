<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 19:59
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="rodzaj")
 */
class Rodzaj{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Danie", mappedBy="rodzaj")
     */
    protected $dania;

    public function __construct()    {
        $this->dania= new ArrayCollection();
    }


    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    protected $nazwa;


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
     * Add danium
     *
     * @param \AppBundle\Entity\Danie $danie
     *
     * @return Rodzaj
     */
    public function addDanium(\AppBundle\Entity\Danie $danie)
    {
        $this->dania[] = $danie;

        return $this;
    }

    /**
     * Remove danium
     *
     * @param \AppBundle\Entity\Danie $danie
     */
    public function removeDanium(\AppBundle\Entity\Danie $danie)
    {
        $this->dania->removeElement($danie);
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

    /**
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Rodzaj
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
}

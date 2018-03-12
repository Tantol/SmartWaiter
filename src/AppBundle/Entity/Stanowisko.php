<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:19
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="stanowisko")
 */

class Stanowisko{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Pracownik", mappedBy="stanowisko")
     */
    protected $pracownicy;

    public function __construct()    {
        $this->pracownicy= new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=30)
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
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Stanowisko
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
     * Add pracownicy
     *
     * @param \AppBundle\Entity\Pracownik $pracownicy
     *
     * @return Stanowisko
     */
    public function addPracownicy(\AppBundle\Entity\Pracownik $pracownicy)
    {
        $this->pracownicy[] = $pracownicy;

        return $this;
    }

    /**
     * Remove pracownicy
     *
     * @param \AppBundle\Entity\Pracownik $pracownicy
     */
    public function removePracownicy(\AppBundle\Entity\Pracownik $pracownicy)
    {
        $this->pracownicy->removeElement($pracownicy);
    }

    /**
     * Get pracownicy
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPracownicy()
    {
        return $this->pracownicy;
    }
}

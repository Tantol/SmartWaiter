<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 12.03.2018
 * Time: 20:42
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Pozycja_zamowienia;


/**
 * @ORM\Entity
 * @ORM\Table(name="status_zamowienia")
 */
class Status_zamowienia{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\OneToMany(targetEntity="Pozycja_zamowienia", mappedBy="status")
     */
    protected $pozycja_zamowienia;

    public function __construct()    {
        $this->pozycja_zamowienia= new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=20, unique=false)
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
     * @return Status_zamowienia
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
     * Add pozycja
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycja
     *
     * @return Status_zamowienia
     */
    public function addPozycjaZamowienia(\AppBundle\Entity\Pozycja_zamowienia $pozycja)
    {
        $this->pozycja_zamowienia[] = $pozycja;

        return $this;
    }

    /**
     * Remove pozycja
     *
     * @param \AppBundle\Entity\Pozycja_zamowienia $pozycja
     */
    public function removeZamowienium(\AppBundle\Entity\Pozycja_zamowienia $pozycja)
    {
        $this->pozycja_zamowienia->removeElement($pozycja);
    }

    /**
     * Get pozycje zamowienia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZamowienia()
    {
        return $this->pozycja_zamowienia;
    }
    
    public function __toString() {
        return $this->nazwa;
    }
}

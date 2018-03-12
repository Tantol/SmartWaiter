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
     * @ORM\OneToMany(targetEntity="Zamowienie", mappedBy="status")
     */
    protected $zamowienia;

    public function __construct()    {
        $this->zamowienia= new ArrayCollection();
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
     * Add zamowienium
     *
     * @param \AppBundle\Entity\Zamowienie $zamowienium
     *
     * @return Status_zamowienia
     */
    public function addZamowienium(\AppBundle\Entity\Zamowienie $zamowienium)
    {
        $this->zamowienia[] = $zamowienium;

        return $this;
    }

    /**
     * Remove zamowienium
     *
     * @param \AppBundle\Entity\Zamowienie $zamowienium
     */
    public function removeZamowienium(\AppBundle\Entity\Zamowienie $zamowienium)
    {
        $this->zamowienia->removeElement($zamowienium);
    }

    /**
     * Get zamowienia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZamowienia()
    {
        return $this->zamowienia;
    }
}

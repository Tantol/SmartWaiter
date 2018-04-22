<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 *
 * @ORM\Table(name="galleries")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GalleryRepository")
 */
class Gallery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    
    /**
     * @ORM\OneToMany(targetEntity="Danie", mappedBy="image")
     */
    protected $dania;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return Gallery
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dania = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add danium.
     *
     * @param \AppBundle\Entity\Danie $danium
     *
     * @return Gallery
     */
    public function addDanium(\AppBundle\Entity\Danie $danium)
    {
        $this->dania[] = $danium;
    
        return $this;
    }

    /**
     * Remove danium.
     *
     * @param \AppBundle\Entity\Danie $danium
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDanium(\AppBundle\Entity\Danie $danium)
    {
        return $this->dania->removeElement($danium);
    }

    /**
     * Get dania.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDania()
    {
        return $this->dania;
    }
    
    public function __toString() {
        return $this->name;
    }
}

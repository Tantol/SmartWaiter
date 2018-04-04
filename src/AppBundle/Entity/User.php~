<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Group;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="This username is already taken")
 * @UniqueEntity(fields={"email"}, message="This email is already taken")
 */
class User implements UserInterface
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
     * @ORM\OneToOne(targetEntity="Pracownik")
     * @ORM\JoinColumn(name="id_pracownik", referencedColumnName="id", nullable=true)
     */
    protected $pracownik;


    /**
     * @ORM\OneToMany(targetEntity="Zamowienie", mappedBy="konto")
     */
    protected $zamowienia;

    public function __construct()    {
        $this->zamowienia= new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\Valid()
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    
    /**
     * @var Group
     * 
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     */
    private $groups;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function eraseCredentials() {

    }

    public function getRoles() {
        return $this->groups->toArray();
    }

    public function getSalt() {

    }


    /**
     * Set pracownik
     *
     * @param \AppBundle\Entity\Pracownik $pracownik
     *
     * @return User
     */
    public function setPracownik(\AppBundle\Entity\Pracownik $pracownik = null)
    {
        $this->pracownik = $pracownik;

        return $this;
    }

    /**
     * Get pracownik
     *
     * @return \AppBundle\Entity\Pracownik
     */
    public function getPracownik()
    {
        return $this->pracownik;
    }

    /**
     * Add zamowienium
     *
     * @param \AppBundle\Entity\Zamowienie $zamowienium
     *
     * @return User
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

    /**
     * Add group
     *
     * @param \AppBundle\Entity\Group $group
     *
     * @return User
     */
    public function addGroup(\AppBundle\Entity\Group $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \AppBundle\Entity\Group $group
     */
    public function removeGroup(\AppBundle\Entity\Group $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }
    
    public function __toString() {
        return $this->username;
    }
}

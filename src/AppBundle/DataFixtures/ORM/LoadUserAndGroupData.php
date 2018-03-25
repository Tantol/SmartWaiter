<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Group;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserAndGroupData implements FixtureInterface, ContainerAwareInterface {
    
    private $container;
    
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        
        $group = new Group();
        $group->setName('Admin');
        $group->setRole('ROLE_ADMIN');
        
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'admin');
        $user->setPassword($password);
        $user->addGroup($group);
        
        $manager->persist($group);
        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Sets the container.
     *  
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}

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
        $encoder = $this->container->get('security.password_encoder');
        $password = null;
        
        /*
         * Groups ->
         */
        // ADMIN
        $groupAdmin = new Group();
        $groupAdmin->setName('Admin');
        $groupAdmin->setRole('ROLE_ADMIN');
        // CLIENT
        $groupKlient = new Group();
        $groupKlient->setName('Klient');
        $groupKlient->setRole('ROLE_CLIENT');
        // WAITER
        $groupKelner = new Group();
        $groupKelner->setName('Kelner');
        $groupKelner->setRole('ROLE_WAITER');
        // COOK
        $groupKucharz = new Group();
        $groupKucharz->setName('Kucharz');
        $groupKucharz->setRole('ROLE_COOK');
        // MANAGER
        $groupMenedzer = new Group();
        $groupMenedzer->setName('Menedzer');
        $groupMenedzer->setRole('ROLE_MANAGER');
        
        $groups = array($groupAdmin, $groupKlient, $groupKelner, $groupKucharz, $groupMenedzer); 
        
        /*
         * Users ->
         */
        // ADMIN
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('admin@admin.com');
        $password = $encoder->encodePassword($userAdmin, 'admin');  
        $userAdmin->setPassword($password);
        $userAdmin->addGroup($groupAdmin);
        // CLIENT
        $userKlient = new User();
        $userKlient->setUsername('klient');
        $userKlient->setEmail('klient@klient.com');
        $password = $encoder->encodePassword($userKlient, 'klient');  
        $userKlient->setPassword($password);
        $userKlient->addGroup($groupKlient);
        // WAITER
        $userKelner = new User();
        $userKelner->setUsername('kelner');
        $userKelner->setEmail('kelner@kelner.com');
        $password = $encoder->encodePassword($userKelner, 'kelner');  
        $userKelner->setPassword($password);
        $userKelner->addGroup($groupKelner);
        // COOK
        $userKucharz = new User();
        $userKucharz->setUsername('kucharz');
        $userKucharz->setEmail('kucharz@kucharz.com');
        $password = $encoder->encodePassword($userKucharz, 'kucharz');  
        $userKucharz->setPassword($password);
        $userKucharz->addGroup($groupKucharz);
        // MANAGER
        $userMenedzer = new User();
        $userMenedzer->setUsername('menedzer');
        $userMenedzer->setEmail('menedzer@menedzer.com');
        $password = $encoder->encodePassword($userMenedzer, 'menedzer');  
        $userMenedzer->setPassword($password);
        $userMenedzer->addGroup($groupMenedzer);
        
        $users = array($userAdmin, $userKlient, $userKelner, $userKucharz, $userMenedzer);
        
        foreach ($groups as $group){
            $manager->persist($group);
        }
        
        foreach ($users as $user){
            $manager->persist($user);
        }

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

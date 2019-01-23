<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Status;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadStatus implements FixtureInterface, ContainerAwareInterface {

    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        /*
         * Status ->
         */
        $sts = new Status_zamowienia();
        $sts->setNazwa('Do wydania');
        $manager->persist($sts);

        $sts = new Status_zamowienia();
        $sts->setNazwa('Niezrealizowane');
        $manager->persist($sts);

        $sts = new Status_zamowienia();
        $sts->setNazwa('Zrealizowane');
        $manager->persist($sts);

        $sts = new Status_zamowienia();
        $sts->setNazwa('W trakcie realizacji');
        $manager->persist($sts);

        $sts = new Status_zamowienia();
        $sts->setNazwa('Czeka na przyjecie');
        $manager->persist($sts);

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

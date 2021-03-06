<?php
namespace AppBundle\Repository;
/**
 * ZamowienieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ZamowienieRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllForClient($konto)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT z FROM AppBundle:Zamowienie z WHERE z.konto = :konto ORDER BY z.czas_zlozenia DESC'
            );
        $query->setParameter('konto', $konto);
        
        return $query->getResult();    
    }
    
    public function findAllForCook()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT z FROM AppBundle:Zamowienie z ORDER BY z.czas_zlozenia DESC'
            );
        
        return $query->getResult();  
    }
    
    public function findAllForWaiter()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT z FROM AppBundle:Zamowienie z WHERE z.uregulowane = 0 ORDER BY z.id DESC'
            );
        
        return $query->getResult();  
    }
}


<?php
namespace AppBundle\Repository;
/**
 * GroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StanMagazynowyRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllByDate()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT z FROM AppBundle:StanMagazynowy z WHERE z.konto = :konto ORDER BY z.czas_zlozenia DESC'
            );
        $query->setParameter('konto', $konto);
        
        return $query->getResult();    
    }  
}
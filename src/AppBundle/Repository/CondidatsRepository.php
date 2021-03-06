<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Offres;
use Doctrine\ORM\Query;

/**
 * CondidatsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CondidatsRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllNom()
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('nom')
            ->from($this->_entityName, 'nom')

        ;

        return $queryBuilder
            ->getQuery()
            ->getResult()
            ;

    }
    public function findAllPrenom()
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('prenom')
            ->from($this->_entityName, 'prenom')

        ;

        return $queryBuilder
            ->getQuery()
            ->getResult()
            ;

    }
    public function findAllDescription()
    {
        $queryBuilder = $this->createQueryBuilder('od')
            ->join('od.offre', 'o')
            ->addSelect('o.description')
        ;

        return  $queryBuilder
            ->getQuery()
            ->getResult()
            ;



    }
    public function findAllCourriel()
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('courriel')
            ->from($this->_entityName, 'courriel')

        ;

        return $queryBuilder
            ->getQuery()
            ->getResult()
            ;

    }
}

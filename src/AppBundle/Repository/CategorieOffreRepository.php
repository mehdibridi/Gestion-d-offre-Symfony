<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CategorieOffre;
use AppBundle\Entity\Offres;

/**
 * CategorieOffreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieOffreRepository extends \Doctrine\ORM\EntityRepository
{
   /* public function findOneByIdJoinedToCategorieOffrre($id, Offres $offres)
    {
        $qb = $this->createQueryBuilder('a')
        ->set('u', $offres)
        ->where('a.idOffres LIKE :id')
        ->setParameter('id', '%'.$id.'%');
        return $qb->getQuery()->getOneOrNullResult();
    }*/
}
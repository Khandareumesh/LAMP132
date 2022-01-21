<?php

namespace ActivityTimetable\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class ProjectRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.id')
                    ->getQuery()
                    ->getResult();
    }

    public function findByApiCriteria(array $criteria = [])
    {
        return $this->findAll();
    }
}

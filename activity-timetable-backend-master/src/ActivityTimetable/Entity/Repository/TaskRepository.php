<?php

namespace ActivityTimetable\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskRepository extends EntityRepository
{
    public function findByDay(\DateTime $day)
    {
        return $this->createQueryBuilder('t')
                    ->where('t.day = :day')
                        ->setParameter('day', $day)
                    ->orderBy('t.project')
                    ->addOrderBy('t.id')
                    ->getQuery()
                    ->getResult();
    }

    public function findAll()
    {
        return $this->createQueryBuilder('t')
                    ->orderBy('t.day')
                    ->addOrderBy('t.project')
                    ->addOrderBy('t.id')
                    ->getQuery()
                    ->getResult();
    }

    public function findByProject($projectId = null)
    {
        if ($projectId === null) {
            return $this->findAll();
        }

        return $this->createQueryBuilder('t')
                    ->innerJoin('t.project', 'p')
                    ->where('p.id = :projectId')
                        ->setParameter('projectId', $projectId)
                    ->getQuery()
                    ->getResult();
    }

    public function findByApiCriteria(array $criteria = [])
    {
        $qb = $this->createQueryBuilder('t')
                    ->addOrderBy('t.id');

        if ( array_key_exists('tasks', $criteria) && is_array($criteria['tasks']) && count($criteria['tasks'])>0 )
            $qb->andWhere('t.id IN (:tasks)')
                ->setParameter('tasks', $criteria['tasks']);

        if ( array_key_exists('projects', $criteria) && is_array($criteria['projects']) && count($criteria['projects'])>0 )
            $qb->andWhere('t.project IN (:projects)')
                ->setParameter('projects', $criteria['projects']);

        if ( array_key_exists('dayStart', $criteria) && $criteria['dayStart'] instanceof \DateTime )
            $qb->andWhere('t.day >= :dayStart')
                ->setParameter('dayStart', $criteria['dayStart']);

        if ( array_key_exists('dayEnd', $criteria) && $criteria['dayEnd'] instanceof \DateTime )
            $qb->andWhere('t.day <= :dayEnd')
                ->setParameter('dayEnd', $criteria['dayEnd']);

        return $qb
                ->getQuery()
                ->getResult();
    }
}

<?php

namespace Application\Bundle\CoreBundle\Repository;

use Application\Bundle\CoreBundle\Entity\Task;
use Doctrine\ORM\EntityRepository;

/**
 * SolutionRatingsRepository
 */
class SolutionRatingsRepository extends EntityRepository
{
    /**
     * @param Task $task
     *
     * @return array
     */
    public function findSolutionRatingsByTask(Task $task)
    {
        $qb = $this->createQueryBuilder('sr');
        $qb->addSelect('SUM(sr.ratingValue) totalRating')
            ->addSelect('COUNT(sr.id) countRatings')
            ->innerJoin('sr.solution', 's')
            ->andWhere('s.task = :task')
            ->setParameter('task', $task)
            ->addGroupBy('sr.solution');

        return $qb->getQuery()->execute();
    }
}

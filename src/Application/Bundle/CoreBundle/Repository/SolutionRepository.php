<?php

namespace Application\Bundle\CoreBundle\Repository;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\UserBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * SolutionRepository
 */
class SolutionRepository extends EntityRepository
{
    /**
     * Get solution by user and task
     *
     * @param Task $task Task
     * @param User $user User
     *
     * @return Solution
     */
    public function getSolutionByUserAndTask(Task $task, User $user)
    {
        return $this->findOneBy([
            'task' => $task,
            'user' => $user
        ]);
    }

    /**
     * Get solutions count for task
     *
     * @param Task $task Task
     *
     * @return array
     */
    public function getSolutionsCountForTask(Task $task)
    {
        $qb = $this->createQueryBuilder('s');

        return $qb->select($qb->expr()->count('s.id'))
                  ->where($qb->expr()->eq('s.task', ':task'))
                  ->setParameter('task', $task)
                  ->getQuery()
                  ->getSingleScalarResult();
    }
}

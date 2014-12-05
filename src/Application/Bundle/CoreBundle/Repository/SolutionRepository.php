<?php

namespace Application\Bundle\CoreBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use Application\Bundle\UserBundle\Entity\User;
use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\CoreBundle\Entity\Solution;

/**
 * SolutionRepository
 */
class SolutionRepository extends EntityRepository
{
    /**
     * @param User $user
     * @param Task $task
     *
     * @return Solution
     */
    public function getSolutionByUserAndTask($task, $user)
    {
        return $this->findOneBy(['task' => $task, 'user' => $user]);
    }
}

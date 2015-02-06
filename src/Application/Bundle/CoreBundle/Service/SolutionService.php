<?php

namespace Application\Bundle\CoreBundle\Service;

use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\CoreBundle\Repository\SolutionRepository;

/**
 * SolutionService
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class SolutionService
{
    /**
     * @var SolutionRepository $solutionRepository Solution repository
     */
    private $solutionRepository;

    /**
     * @param SolutionRepository $solutionRepository Solution repository
     */
    public function __construct($solutionRepository)
    {
        $this->solutionRepository = $solutionRepository;
    }

    /**
     * Get bonus for solution
     *
     * @param Task $task Task
     *
     * @return int
     */
    public function getBonusForSolution(Task $task)
    {
        $count = $this->solutionRepository->getSolutionsCountForTask($task);

        // @todo Get values from config
        switch ($count) {
            case 0:
                $bonus = 15; // First solution - the biggest bonus
                break;
            case 1:
                $bonus = 10; // Second solution - second place
                break;
            case 2:
                $bonus = 5; // Third solution - last place (third), smallest bonus
                break;
            default:
                $bonus = 0; // Next solutions get no bonus
        }

        return $bonus;
    }
}

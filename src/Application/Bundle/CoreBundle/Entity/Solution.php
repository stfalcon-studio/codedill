<?php

namespace Application\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Bundle\CoreBundle\Entity
 *
 * @ORM\Table(name="solutions")
 * @ORM\Entity(repositoryClass="Application\Bundle\CoreBundle\Repository\SolutionRepository")
 */
class Solution
{
    /**
     * @var int $id ID
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @todo Add relation to user
     * @var User $user User
     */
    private $user;

    /**
     * @var Task $task Task
     *
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="solutions")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     */
    private $task;

    /**
     * @var string $code Code
     *
     * @ORM\Column(name="code", type="text", nullable=false)
     */
    private $code;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }

    /**
     * Get ID
     *
     * @return int ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set task
     *
     * @param Task $task Task
     *
     * @return $this
     */
    public function setTask(Task $task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set code
     *
     * @param string $code Code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }
}

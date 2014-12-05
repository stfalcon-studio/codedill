<?php

namespace Application\Bundle\CoreBundle\Entity;

use Application\Bundle\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Application\Bundle\CoreBundle\Entity
 *
 * @ORM\Table(name="solutions")
 * @ORM\Entity(repositoryClass="Application\Bundle\CoreBundle\Repository\SolutionRepository") *
 */
class Solution
{
    use TimestampableEntity;

    /**
     * @var int $id ID
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User $user
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
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
     *
     * @Assert\NotBlank()
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

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Solution
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}

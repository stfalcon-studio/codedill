<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\CoreBundle\Entity;

use Application\Bundle\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Application\Bundle\CoreBundle\Entity
 *
 * @ORM\Table(
 *      name="solutions",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="unique_solution_for_task_from_user", columns={"user_id", "task_id"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="Application\Bundle\CoreBundle\Repository\SolutionRepository")
 * @UniqueEntity(
 *     fields={"user", "task"},
 *     errorPath="code",
 *     message="User can add a solution only once. Solution for this task is already added"
 * )
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
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
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
     * @var int $bonus Bonus
     *
     * @ORM\Column(name="bonus", type="smallint", nullable=false)
     */
    private $bonus = 0;

    /**
     * @var string $codeMode CodeMode
     *
     * @Assert\Choice(callback = "getValidCodeModes")
     * @ORM\Column(name="code_mode", type="string")
     */
    private $codeMode;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId() ?: 'New Solution';
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

    /**
     * Get bonus
     *
     * @return int Bonus
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set bonus
     *
     * @param int $bonus Bonus
     *
     * @return $this
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodeMode()
    {
        return $this->codeMode;
    }

    /**
     * Set code mode
     *
     * @param string $codeMode Code mode
     *
     * @return $this
     */
    public function setCodeMode($codeMode)
    {
        $this->codeMode = $codeMode;

        return $this;
    }

    /**
     * @return array
     */
    public static function getCodeModes()
    {
        return array(
            'ace/mode/html' => 'HTML',
            'ace/mode/php' => 'PHP',
            'ace/mode/css' => 'CSS',
            'ace/mode/java' => 'Java',
            'ace/mode/python' => 'Python',
            'ace/mode/sql' => 'SQL',
        );
    }

    /**
     * @return array
     */
    public static function getValidCodeModes()
    {
        return array_keys(self::getCodeModes());
    }
}

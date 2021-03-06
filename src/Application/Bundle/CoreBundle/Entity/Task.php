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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Application\Bundle\CoreBundle\Task
 *
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="Application\Bundle\CoreBundle\Repository\TaskRepository")
 */
class Task
{
    use TimestampableEntity;

    /**
     * @var int $id ID
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User $user User
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var ArrayCollection $solutions Solutions
     *
     * @ORM\OneToMany(targetEntity="Solution", mappedBy="task")
     */
    private $solutions;

    /**
     * @var string $title Title
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $title;

    /**
     * @var string $description Description
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solutions = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?: 'New Task';
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
     * Set solutions
     *
     * @param ArrayCollection $solutions Solutions
     *
     * @return $this
     */
    public function setSolutions($solutions)
    {
        $this->solutions = $solutions;

        return $this;
    }

    /**
     * Get solutions
     *
     * @return ArrayCollection|Solution[]
     */
    public function getSolutions()
    {
        return $this->solutions;
    }

    /**
     * Add solution
     *
     * @param Solution $solution Solution
     *
     * @return $this
     */
    public function addSolution(Solution $solution)
    {
        $solution->setTask($this);
        $this->solutions->add($solution);

        return $this;
    }

    /**
     * Remove solution
     *
     * @param Solution $solution Solution
     *
     * @return $this
     */
    public function removeSolution(Solution $solution)
    {
        if ($this->solutions->contains($solution)) {
            $this->solutions->removeElement($solution);
        }

        return $this;
    }

    /**
     * Set title
     *
     * @param string $title Title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get full title
     *
     * @return string Full title
     */
    public function getFullTitle()
    {
        return sprintf('#%s: %s', $this->id, $this->title);
    }

    /**
     * Set description
     *
     * @param string $description description
     *
     * @return $this Description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return Task
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}

<?php

namespace Application\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Application\Bundle\CoreBundle\Task
 *
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="Application\Bundle\CoreBundle\Repository\TaskRepository")
 */
class Task
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
     * @var ArrayCollection $solutions Solutions
     *
     * @ORM\OneToMany(targetEntity="Solution", mappedBy="task")
     */
    private $solutions;

    /**
     * @var string $title Title
     *
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private $title;

    /**
     * @var string $description Description
     *
     * @ORM\Column(name="description", type="text", nullable=false)
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
        return $this->getTitle();
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
}

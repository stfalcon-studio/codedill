<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\CoreBundle\Tests\Entity;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Task Entity Test
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test an empty Task entity
     */
    public function testEmptyTask()
    {
        $task = new Task();
        $this->assertEquals('New Task', $task->__toString());
        $this->assertNull($task->getId());
        $this->assertNull($task->getUser());
        $this->assertEquals(0, $task->getSolutions()->count());
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $task->getSolutions());
        $this->assertNull($task->getTitle());
        $this->assertNull($task->getDescription());
        $this->assertNull($task->getCreatedAt());
        $this->assertNull($task->getUpdatedAt());
    }

    /**
     * Test setter and getter for user
     */
    public function testSetGetUser()
    {
        $user = new User;
        $task = (new Task())->setUser($user);
        $this->assertEquals($user, $task->getUser());
    }

    /**
     * Test setter and getter for solutions
     */
    public function testSetGetSolutions()
    {
        $solutions = new ArrayCollection();
        $solutions->add(new Solution());
        $task = (new Task())->setSolutions($solutions);
        $this->assertEquals(1, $task->getSolutions()->count());
        $this->assertEquals($solutions, $task->getSolutions());
    }

    /**
     * Test add and remove solution
     */
    public function testAddRemoveSolution()
    {
        $task = new Task();
        $this->assertEquals(0, $task->getSolutions()->count());

        $task->addSolution(new Solution());
        $this->assertEquals(1, $task->getSolutions()->count());

        $solution = $task->getSolutions()->first();
        $task->removeSolution($solution);
        $this->assertEquals(0, $task->getSolutions()->count());
    }

    /**
     * Test setter and getter for title
     */
    public function testSetGetTitle()
    {
        $title = 'Title';
        $task = (new Task())->setTitle($title);
        $this->assertEquals($title, $task->getTitle());
    }

    /**
     * Test method getFullTitle
     */
    public function testGetFullTitle()
    {
        $title = 'Title';
        $task = (new Task())->setTitle($title);
        $this->assertEquals('#: Title', $task->getFullTitle());
    }

    /**
     * Test setter and getter for description
     */
    public function testSetGetDescription()
    {
        $description = 'Description';
        $task = (new Task())->setDescription($description);
        $this->assertEquals($description, $task->getDescription());
    }

    /**
     * Test setter and getter for created At
     */
    public function testSetGetCreatedAt()
    {
        $now = new \DateTime();
        $task = (new Task())->setCreatedAt($now);
        $this->assertEquals($now, $task->getCreatedAt());
    }

    /**
     * Test setter and getter for updated At
     */
    public function testSetGetUpdatedAt()
    {
        $now = new \DateTime();
        $task = (new Task())->setUpdatedAt($now);
        $this->assertEquals($now, $task->getUpdatedAt());
    }
}

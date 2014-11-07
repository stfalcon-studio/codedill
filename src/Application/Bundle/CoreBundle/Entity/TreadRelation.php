<?php


namespace Application\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *  Class TreadRelation
 *
 * @ORM\Entity
 * @ORM\Table(name="thread_relation", uniqueConstraints={@ORM\UniqueConstraint(name="relation_idx", columns={"relation"})})
 */
class TreadRelation
{

    const  SOLUTION_TYPE = 'solution_type';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $relationId;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(callback = "getAvailableTypes")
     */
    protected $relationType;

    /**
     * @ORM\OneToOne(targetEntity="Application\Bundle\CoreBundle\Entity\Thread")
     * @ORM\JoinColumn(name="thread", referencedColumnName="id")
     */
    protected $thread;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Thread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * @param Thread $thread
     */
    public function setThread($thread)
    {
        $this->thread = $thread;
    }

    /**
     * @return array
     */
    public function getAvailableTypes()
    {
        return [self::SOLUTION_TYPE];
    }
}

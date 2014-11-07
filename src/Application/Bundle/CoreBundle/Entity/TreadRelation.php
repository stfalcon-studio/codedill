<?php


namespace Application\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  Class TreadRelation
 *
 * @ORM\Entity
 * @ORM\Table(name="thread_relation", uniqueConstraints={@ORM\UniqueConstraint(name="relation_idx", columns={"relation"})})

 */
class TreadRelation {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=16)
     */
    protected $relation;

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
     * @return string
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * @param string $relation
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
    }
}

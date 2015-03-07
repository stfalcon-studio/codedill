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
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Application\Bundle\CoreBundle\Entity
 *
 * @ORM\Table(
 *      name="solutions_ratings",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="unique_rating_for_solution_from_user", columns={"user_id", "solution_id"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="Application\Bundle\CoreBundle\Repository\SolutionRatingsRepository")
 *
 * @UniqueEntity(
 *     fields={"user", "solution"},
 *     errorPath="solution",
 *     message="User can rate the solution only once. You already rated it"
 * )
 */
class SolutionRating
{
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
     * @var Solution $solution Solution
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\CoreBundle\Entity\Solution")
     * @ORM\JoinColumn(name="solution_id", referencedColumnName="id")
     */
    private $solution;

    /**
     * @var int $ratingValue Rating value
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $ratingValue;

    /**
     * @var \DateTime $createdAt Created at
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

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
     * @return int
     */
    public function getRatingValue()
    {
        return $this->ratingValue;
    }

    /**
     * @param int $ratingValue
     *
     * @return $this
     */
    public function setRatingValue($ratingValue)
    {
        $this->ratingValue = $ratingValue;

        return $this;
    }

    /**
     * @return Solution
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * @param Solution $solution
     *
     * @return $this
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

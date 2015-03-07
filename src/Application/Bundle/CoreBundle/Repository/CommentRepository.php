<?php

namespace Application\Bundle\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ThreadRepository
 */
class CommentRepository extends EntityRepository
{
    /**
     * @param integer $threadId Tread
     *
     * @return array
     */
    public function getThreadComments($threadId)
    {
        $result = [];
        if (!$threadId) {
            return $result;
        }

        $qb = $this->createQueryBuilder('c');
        $rawData = $qb->where('c.thread = :threadId')
            ->setParameter('threadId', $threadId)
            ->getQuery()
            ->getResult();

        return $rawData;
    }
}

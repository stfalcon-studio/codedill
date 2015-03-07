<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

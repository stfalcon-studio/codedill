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
class ThreadRepository extends EntityRepository
{
    /**
     * @param array $threadsIds Treads IDs
     *
     * @return array
     */
    public function getThreadsCommentsStats(array $threadsIds)
    {
        $result = [];

        if (empty($threadsIds)) {
            return $result;
        }

        $qb = $this->createQueryBuilder('t');

        $rawData = $qb->select('t.id as thread_id')
                      ->addSelect('t.numComments as number_of_comments')
                      ->where($qb->expr()->in('t.id', ':threadsIds'))
                      ->setParameter('threadsIds', $threadsIds)
                      ->getQuery()
                      ->getArrayResult();

        foreach ($rawData as $item) {
            $result[$item['thread_id']] = (int) $item['number_of_comments'];
        }

        return $result;
    }
}

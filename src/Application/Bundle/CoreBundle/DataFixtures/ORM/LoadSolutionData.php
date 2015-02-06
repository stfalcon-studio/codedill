<?php

namespace Application\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Bundle\CoreBundle\Entity\Solution;

/**
 * Load Solution fixtures
 */
class LoadSolutionData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Get dependencies
     *
     * @return array Dependencies
     */
    public function getDependencies()
    {
        return [
            'Application\Bundle\CoreBundle\DataFixtures\ORM\LoadTaskData',
        ];
    }

    /**
     * Load fixtures
     *
     * @param ObjectManager $manager Manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var \Application\Bundle\CoreBundle\Entity\Task $task1
         * @var \Application\Bundle\CoreBundle\Entity\Task $task2
         *
         * @var \Application\Bundle\UserBundle\Entity\User $user1
         * @var \Application\Bundle\UserBundle\Entity\User $user2
         * @var \Application\Bundle\UserBundle\Entity\User $user3
         */
        $task1 = $this->getReference('task-1');
        $task2 = $this->getReference('task-2');
        $user1 = $this->getReference('user_1');
        $user2 = $this->getReference('user_2');
        $user3 = $this->getReference('user_3');

        $solution1 = (new Solution())
            ->setTask($task1)
            ->setUser($user1)
            ->setBonus(15)
            ->setCode(<<<'DESC'
    /**
     * Preliminary checks that can skip some fake arrays of words
     *
     * @param array $words Words
     *
     * @return bool
     */
    protected function preliminaryChecks(array $words)
    {
        return CrosswordHelper::lengthOfWordsIsAllowed($words)
               && CrosswordHelper::canBeCrossword($words)
               && CrosswordHelper::firstAndLastLettersAreCompatible($words);
    }
DESC
        );
        $this->addReference('solution-1', $solution1);
        $manager->persist($solution1);

        $solution2 = (new Solution())
            ->setTask($task1)
            ->setUser($user2)
            ->setBonus(10)
            ->setCode(<<<'DESC'
    /**
     * Check allowed length for words
     *
     * Allowed only >= 3 and =< 30
     *
     * @param array $words
     *
     * @return bool
     */
    public static function lengthOfWordsIsAllowed(array $words)
    {
        $result = true;
        foreach ($words as $word) {
            $length = strlen($word);
            if ($length < 3 || $length > 30) {
                $result = false;
                break;
            }
        }
        return $result;
    }
DESC
        );
        $this->addReference('solution-2', $solution2);
        $manager->persist($solution2);

        $solution3 = (new Solution())
            ->setTask($task2)
            ->setUser($user1)
            ->setBonus(15)
            ->setCode(<<<'DESC'
    /**
     * Check if crossword could be made from array of words
     *
     * @param array $words
     *
     * @return bool
     */
    public static function canBeCrossword(array $words)
    {
        $result = false;
        $totalLength = 0;
        foreach ($words as $word) {
            $totalLength += strlen($word);
        }
        // Only even length is allowed for crossword creation
        if ($totalLength % 2 === 0) {
            $gte5 = 0;
            foreach ($words as $word) {
                if (strlen($word) >= 5) {
                    $gte5++;
                }
            }
            // Should be at least two words with 5 and more letters
            if ($gte5 >= 2) {
                $result = true;
            }
        }
        return $result;
    }
DESC
        );
        $this->addReference('solution-3', $solution3);
        $manager->persist($solution3);

        $solution4 = (new Solution())
            ->setTask($task2)
            ->setUser($user2)
            ->setBonus(10)
            ->setCode(<<<'DESC'
    /**
     * Check first and last letters for compatibility
     *
     * @param array $words
     *
     * @return bool
     */
    public static function firstAndLastLettersAreCompatible(array $words)
    {
        $result  = true;
        $letters = '';
        foreach ($words as $word) {
            $letters .= substr($word, 0, 1);  // First letter
            $letters .= substr($word, -1, 1); // Second letter
        }
        // Get letters stats
        $lettersStats = count_chars($letters, 1);
        foreach ($lettersStats as $letterStats) {
            // Only even count of same letter is allowed
            if ($letterStats % 2 !== 0) {
                $result = false;
                break;
            }
        }
        return $result;
    }
DESC
        );
        $this->addReference('solution-4', $solution4);
        $manager->persist($solution4);

        $solution5 = (new Solution())
            ->setTask($task2)
            ->setUser($user3)
            ->setBonus(5)
            ->setCode(<<<'DESC'
    /**
     * Check first and last letters for compatibility
     *
     * @param array $words
     *
     * @return bool
     */
    public static function firstAndLastLettersAreCompatible(array $words)
    {
        $result  = true;
        $letters = '';
        foreach ($words as $word) {
            $letters .= substr($word, 0, 1);  // First letter
            $letters .= substr($word, -1, 1); // Second letter
        }
        // Get letters stats
        $lettersStats = count_chars($letters, 1);
        foreach ($lettersStats as $letterStats) {
            // Only even count of same letter is allowed
            if ($letterStats % 2 !== 0) {
                $result = false;
                break;
            }
        }
        return $result;
    }
DESC
            );
        $this->addReference('solution-5', $solution5);
        $manager->persist($solution5);

        $manager->flush();
    }
}

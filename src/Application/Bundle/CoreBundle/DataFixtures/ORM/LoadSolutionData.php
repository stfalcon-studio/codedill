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
         */
        $task1 = $this->getReference('task-1');
        $task2 = $this->getReference('task-2');

        $solution = (new Solution())->setTask($task1)
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
        $this->addReference('solution-1', $solution);
        $manager->persist($solution);

        $solution = (new Solution())->setTask($task1)
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
        $this->addReference('solution-2', $solution);
        $manager->persist($solution);

        $solution = (new Solution())->setTask($task2)
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
        $this->addReference('solution-3', $solution);
        $manager->persist($solution);

        $solution = (new Solution())->setTask($task2)
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
        $this->addReference('solution-4', $solution);
        $manager->persist($solution);

        $manager->flush();
    }
}

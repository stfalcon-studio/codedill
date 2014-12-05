<?php

namespace Application\Bundle\CoreBundle\DataFixtures\ORM;

use Application\Bundle\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Bundle\CoreBundle\Entity\Task;

/**
 * Load Task fixtures
 */
class LoadUserData extends AbstractFixture
{
    /**
     * Load fixtures
     *
     * @param ObjectManager $manager Manager
     */
    public function load(ObjectManager $manager)
    {

        $user1 = new User();
        $user1->setUsername('user_1');
        $user1->setEmail('some1@email.com');
        $user1->setPlainPassword('user_1');
        $user1->setGithubId('some_id');
        $manager->persist($user1);
        $manager->flush();

        $user2 = new User();
        $user2->setUsername('user_2');
        $user2->setPlainPassword('user_2');
        $user2->setGithubId('some_id');
        $user2->setEmail('some2@email.com');
        $manager->persist($user2);
        $manager->flush();

        $user3 = new User();
        $user3->setUsername('user_3');
        $user3->setPlainPassword('user_3');
        $user3->setGithubId('some_id');
        $user3->setEmail('some3@email.com');
        $manager->persist($user3);
        $manager->flush();

        $user4 = new User();
        $user4->setUsername('user_4');
        $user4->setEmail('some4@email.com');
        $user4->setPlainPassword('user_4');
        $user4->setGithubId('some_id');
        $manager->persist($user4);
        $manager->flush();

        $this->addReference('user_1', $user1);
        $this->addReference('user_2', $user2);
        $this->addReference('user_3', $user3);
        $this->addReference('user_4', $user4);
    }
}

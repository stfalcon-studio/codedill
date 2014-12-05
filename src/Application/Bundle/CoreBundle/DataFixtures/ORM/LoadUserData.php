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

        $user = new User();
        $user->setUsername('user_1');
        $user->setEmail('some1@email.com');
        $user->setPlainPassword('user_1');
        $user->setGithubId('some_id');
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('user_2');
        $user->setPlainPassword('user_2');
        $user->setGithubId('some_id');
        $user->setEmail('some2@email.com');
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('user_3');
        $user->setPlainPassword('user_3');
        $user->setGithubId('some_id');
        $user->setEmail('some3@email.com');
        $manager->persist($user);
        $manager->flush();

        $this->addReference('user_1', $user);
        $this->addReference('user_2', $user);
        $this->addReference('user_3', $user);
    }
}

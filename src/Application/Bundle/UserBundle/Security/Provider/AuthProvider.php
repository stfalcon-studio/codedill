<?php
namespace Application\Bundle\UserBundle\Security\Provider;

use Application\Bundle\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseProvider;

/**
 * Class AuthProvider
 */
class AuthProvider extends BaseProvider
{

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * Constructor
     *
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userManager->findUserBy(
            [
                'githubId' => $response->getUsername()
            ]
        );

        if ($user instanceof User) {
            return $user;
        }

        // Try to create user
        $user = $this->createUserFromResponse($response);

        return $user;
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return User
     */
    private function createUserFromResponse(UserResponseInterface $response)
    {
        $email = $response->getEmail() ?: $response->getUsername() . '@example.com';

        /** @var User $user */
        $user = $this->userManager->createUser();
        $user->setEmail($email);
        $user->setUsername($response->getNickname());
        $user->setEnabled(true);
        $user->setPlainPassword(uniqid());
        $user->setGithubId($response->getUsername());
        $this->userManager->updateUser($user);

        return $user;
    }
}

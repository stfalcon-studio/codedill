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
     * @var array $adminGitHubIds Admin GitHub IDs
     */
    private $adminGitHubIds = [
        424723,  // Valera
        815865,  // Artem
        1199467, // Zhenya
        1430407, // Misha
        1486415, // Timur
        2345473, // Vadim
        5329546, // Sasha
    ];

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
        $user = $this->userManager->findUserBy([
            'githubId' => $response->getUsername()
        ]);

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

        // Move to separate listener
        if (in_array($response->getUsername(), $this->adminGitHubIds)) {
            $user->addRole('ROLE_ADMIN');
        }

        $this->userManager->updateUser($user);

        return $user;
    }
}

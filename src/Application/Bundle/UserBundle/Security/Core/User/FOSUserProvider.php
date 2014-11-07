<?php
namespace Application\Bundle\UserBundle\Security\Core\User;

use Application\Bundle\UserBundle\Entity\User;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseProvider;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

/**
 * Class FOSUserProvider
 */
class FOSUserProvider extends BaseProvider
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var array
     */
    protected $properties;

    /**
     * Constructor
     *
     * @param UserManagerInterface $userManager
     * @param array                $properties
     */
    public function __construct(UserManagerInterface $userManager, array $properties)
    {
        $this->userManager = $userManager;
        $this->properties  = $properties;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $response->getUsername()));
        if (is_null($user)) {
            if (!$user) {
                /** @var User $user */
                $user = $this->userManager->createUser();
                $user->setEmail($response->getEmail()?$response->getEmail():$response->getUsername() . '@example.com');
                $user->setUsername($response->getEmail()?$response->getEmail():$response->getUsername() . '@example.com');
                $user->setEnabled(true);
                $user->setPlainPassword(uniqid());
            }

            $setter = 'set' . ucfirst($this->getProperty($response));
            $user->{$setter}($response->getUsername());
            $this->userManager->updateUser($user);
        }

        return $user;
    }
}

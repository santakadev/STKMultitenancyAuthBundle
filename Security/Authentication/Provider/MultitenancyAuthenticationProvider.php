<?php

namespace STK\MultitenancyAuthBundle\Security\Authentication\Provider;

use STK\MultitenancyAuthBundle\Security\Authentication\Token\MultitenancyUserToken;
use STK\MultitenancyAuthBundle\Security\User\MultitenancyUserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class MultitenancyAuthenticationProvider implements AuthenticationProviderInterface
{
    /**
     * @var MultitenancyUserProviderInterface
     */
    private $userProvider;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var string
     */
    private $providerKey;

    /**
     * @param MultitenancyUserProviderInterface $userProvider
     * @param EncoderFactoryInterface $encoderFactory
     * @param string $providerKey
     */
    public function __construct(MultitenancyUserProviderInterface $userProvider, EncoderFactoryInterface $encoderFactory, $providerKey)
    {
        $this->userProvider = $userProvider;
        $this->encoderFactory = $encoderFactory;
        $this->providerKey = $providerKey;
    }

    /**
     * Attempts to authenticate a TokenInterface object.
     *
     * @param TokenInterface $token The TokenInterface instance to authenticate
     *
     * @return TokenInterface An authenticated TokenInterface instance, never null
     *
     * @throws AuthenticationException if the authentication fails
     */
    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByTenantAndUsername(
            $token->getTenant(),
            $token->getUsername()
        );

        if ($this->encoderFactory->getEncoder($user)->isPasswordValid(
            $user->getPassword(),
            $token->getCredentials(),
            $user->getSalt()
        )) {
            return new MultitenancyUserToken(
                $token->getTenant(),
                $token->getUsername(),
                $token->getCredentials(),
                $this->providerKey,
                $user->getRoles()
            );
        }

        throw new AuthenticationException('The multitenancy authentication failed.');
    }

    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token A TokenInterface instance
     *
     * @return bool true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof MultitenancyUserToken;
    }
}

<?php

namespace STK\MultitenacyBundle\Security\Authentication\Provider;

use STK\MultitenacyBundle\Security\Authentication\Token\MultitenacyUserToken;
use STK\MultitenacyBundle\Security\User\MultitenacyUserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class MultitenacyAuthenticationProvider implements AuthenticationProviderInterface
{
    /**
     * @var MultitenacyUserProviderInterface
     */
    private $userProvider;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

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
            return $token;
        }

        throw new AuthenticationException('The multitenacy autentication failed.');
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
        return $token instanceof MultitenacyUserToken;
    }
}

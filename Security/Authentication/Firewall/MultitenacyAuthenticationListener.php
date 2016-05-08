<?php

namespace STK\MultitenacyBundle\Security\Authentication\Firewall;

use Psr\Log\LoggerInterface;
use STK\MultitenacyBundle\Security\Authentication\Token\MultitenacyUserToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

class MultitenacyAuthenticationListener extends AbstractAuthenticationListener
{

    protected function requiresAuthentication(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        return parent::requiresAuthentication($request);
    }

    /**
     * Performs authentication.
     *
     * @param Request $request A Request instance
     *
     * @return TokenInterface|Response|null The authenticated token, null if full authentication is not possible, or a Response
     *
     * @throws AuthenticationException if the authentication fails
     */
    protected function attemptAuthentication(Request $request)
    {
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');
        $tenant = $request->request->get('_tenant');

        $token = new MultitenacyUserToken(
            $tenant,
            $username,
            $password,
            $this->providerKey
        );

        try {
            $authToken = $this->authenticationManager->authenticate($token);
            return $authToken;
        } catch (AuthenticationException $failed) {
            return null;
        }
    }
}

<?php

namespace STK\MultitenacyBundle\Security\User;

use STK\MultitenacyBundle\Security\Exception\Security\User\TenantNotFoundException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface MultitenacyUserProviderInterface extends UserProviderInterface
{
    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return MultitenacyUserInterface
     *
     * @throws TenantNotFoundException if the tenant is not found
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByTenantAndUsername($username);
}

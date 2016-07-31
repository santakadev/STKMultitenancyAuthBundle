<?php

namespace STK\MultitenancyAuthBundle\Security\User;

use STK\MultitenancyAuthBundle\Security\Exception\Security\User\TenantNotFoundException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface MultitenancyUserProviderInterface extends UserProviderInterface
{
    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $tenant The tenant
     * @param string $username The username
     *
     * @return MultitenancyUserInterface
     *
     * @throws TenantNotFoundException if the tenant is not found
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByTenantAndUsername($tenant, $username);
}

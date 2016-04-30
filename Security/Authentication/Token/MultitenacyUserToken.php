<?php

namespace STK\MultitenacyBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class MultitenacyUserToken extends AbstractToken
{
    /**
     * @var string
     */
    private $tenant;

    /**
     * @var string
     */
    private $credentials;

    /**
     * @param string $tenant
     * @param $user
     * @param $credentials
     * @param array|\string[]|\Symfony\Component\Security\Core\Role\RoleInterface[] $roles
     */
    public function __construct($tenant, $user, $credentials, array $roles = array())
    {
        parent::__construct($roles);

        $this->tenant = $tenant;
        $this->setUser($user);
        $this->credentials = $credentials;

        // If the user has roles, consider it authenticated
        $this->setAuthenticated(count($roles) > 0);
    }

    /**
     * Returns the user credentials.
     *
     * @return mixed The user credentials
     */
    public function getCredentials()
    {
        $this->credentials;
    }

    /**
     * Returns the user tenant
     * 
     * @return string
     */
    public function getTenant()
    {
        return $this->tenant;
    }
}

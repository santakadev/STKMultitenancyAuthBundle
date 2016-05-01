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
     * @var string
     */
    private $providerKey;

    /**
     * @param string $tenant
     * @param $user
     * @param $credentials
     * @param $providerKey
     * @param array|\string[]|\Symfony\Component\Security\Core\Role\RoleInterface[] $roles
     */
    public function __construct($tenant, $user, $credentials, $providerKey, array $roles = array())
    {
        parent::__construct($roles);

        if (empty($providerKey)) {
            throw new \InvalidArgumentException('$providerKey must not be empty.');
        }

        $this->tenant = $tenant;
        $this->setUser($user);
        $this->credentials = $credentials;
        $this->providerKey = $providerKey;

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
     * @return string
     */
    public function getProviderKey()
    {
        return $this->providerKey;
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

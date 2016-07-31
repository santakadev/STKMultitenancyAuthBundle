<?php

namespace STK\MultitenancyAuthBundle\Security\Exception\Security\User;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TenantNotFoundException extends AuthenticationException
{
}

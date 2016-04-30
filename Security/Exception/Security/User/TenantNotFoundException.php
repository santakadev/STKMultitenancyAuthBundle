<?php

namespace STK\MultitenacyBundle\Security\Exception\Security\User;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TenantNotFoundException extends AuthenticationException
{
}

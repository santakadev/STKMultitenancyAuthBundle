<?php

namespace STK\MultitenancyAuthBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

interface MultitenancyUserInterface extends UserInterface
{
    /**
     * @return string
     */
    public function getTenant();
}

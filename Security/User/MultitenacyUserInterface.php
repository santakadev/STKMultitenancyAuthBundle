<?php

namespace STK\MultitenacyBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

interface MultitenacyUserInterface extends UserInterface
{
    /**
     * @return string
     */
    public function getTenant();
}

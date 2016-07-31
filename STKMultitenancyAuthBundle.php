<?php

namespace STK\MultitenancyAuthBundle;

use STK\MultitenancyAuthBundle\DependencyInjection\Security\Factory\MultitenancyFactory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class STKMultitenancyAuthBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var SecurityExtension $extension */
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new MultitenancyFactory());
    }

}

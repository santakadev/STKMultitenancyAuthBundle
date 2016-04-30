<?php

namespace STK\MultitenacyBundle;

use STK\MultitenacyBundle\DependencyInjection\Security\Factory\MultitenacyFactory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class STKMultitenacyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var SecurityExtension $extension */
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new MultitenacyFactory());
    }

}

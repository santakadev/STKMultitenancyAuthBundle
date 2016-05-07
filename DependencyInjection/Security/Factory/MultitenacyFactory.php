<?php

namespace STK\MultitenacyBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class MultitenacyFactory extends AbstractFactory
{

    public function getPosition()
    {
        return 'form';
    }

    public function getKey()
    {
        return 'multitenacy';
    }


    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $providerId = 'security.authentication.provider.multitenacy.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('multitenacy.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProviderId))
            ->replaceArgument(2, $this->getKey())
        ;

        return $providerId;
    }

    protected function getListenerId()
    {
        return 'security.authentication.listener.multitenacy';
    }

    protected function createListener($container, $id, $config, $userProvider)
    {
        $listenerId = 'security.authentication.listener.multitenacy.'.$id;
        $container
            ->setDefinition($listenerId, new DefinitionDecorator('multitenacy.security.authentication.listener'))
            ->replaceArgument(4, $id);
        return $listenerId;
    }
    
}

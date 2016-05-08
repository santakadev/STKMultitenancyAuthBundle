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
        $providerId = $this->getProviderId().'.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator($this->getProviderId()))
            ->replaceArgument(0, new Reference($userProviderId))
            ->replaceArgument(2, $this->getKey())
        ;

        return $providerId;
    }

    protected function getListenerId()
    {
        return 'security.authentication.listener.multitenacy';
    }

    protected function getProviderId()
    {
        return 'security.authentication.provider.multitenacy';
    }

    protected function createListener($container, $id, $config, $userProvider)
    {
        $listenerId = $listenerId = parent::createListener($container, $id, $config, $userProvider);
        $container->getDefinition($listenerId);
        return $listenerId;
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
    {
        $entryPointId = 'security.authentication.form_entry_point.'.$id;
        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('security.authentication.form_entry_point'))
            ->addArgument(new Reference('security.http_utils'))
            ->addArgument($config['login_path'])
            ->addArgument($config['use_forward'])
        ;

        return $entryPointId;
    }
}

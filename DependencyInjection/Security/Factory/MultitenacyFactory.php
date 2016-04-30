<?php

namespace STK\MultitenacyBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class MultitenacyFactory implements SecurityFactoryInterface
{

    /**
     * Configures the container services required to use the authentication listener.
     *
     * @param ContainerBuilder $container
     * @param string $id The unique id of the firewall
     * @param array $config The options array for the listener
     * @param string $userProvider The service id of the user provider
     * @param string $defaultEntryPoint
     *
     * @return array containing three values:
     *               - the provider id
     *               - the listener id
     *               - the entry point id
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.multitenacy.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('multitenacy.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
        ;

        $listenerId = 'security.authentication.listener.multitenacy.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('multitenacy.security.authentication.listener'));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    /**
     * Defines the position at which the provider is called.
     * Possible values: pre_auth, form, http, and remember_me.
     *
     * @return string
     */
    public function getPosition()
    {
        return 'pre_auth';
    }

    /**
     * Defines the configuration key used to reference the provider
     * in the firewall configuration.
     *
     * @return string
     */
    public function getKey()
    {
        return 'multitenacy';
    }

    public function addConfiguration(NodeDefinition $builder)
    {
    }
}

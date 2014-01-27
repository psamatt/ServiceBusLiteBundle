<?php

namespace Psamatt\ServiceBusLiteBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ServiceBusCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('servicebus.handler')) {
            return;
        }
        
        $definition = $container->getDefinition('servicebus.handler');

        $taggedServices = $container->findTaggedServiceIds('servicebus.command_handler');
        
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addCommandHandler',
                array(new Reference($id))
            );
        }
        
        $taggedServices = $container->findTaggedServiceIds('servicebus.query_handler');
        
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addQueryHandler',
                array(new Reference($id))
            );
        }
    }
}
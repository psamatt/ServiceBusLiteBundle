<?php

namespace Psamatt\ServiceBusLiteBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PsamattServiceBusLiteBundle extends Bundle
{
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DependencyInjection\Compiler\ServiceBusCompilerPass());
    }

}

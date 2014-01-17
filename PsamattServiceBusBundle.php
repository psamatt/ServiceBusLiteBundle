<?php

namespace Psamatt\ServiceBusBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PsamattServiceBusBundle extends Bundle
{
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DependencyInjection\Compiler\ServiceBusCompilerPass());
    }

}

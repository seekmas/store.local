<?php

namespace Store\Bundle\BackendBundle;

use Store\Bundle\BackendBundle\DependencyInjection\Compiler\MenuRenderPass;
use Store\Bundle\BackendBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class StoreBackendBundle extends Bundle
{

    public function build( ContainerBuilder $container)
    {

        $container->addCompilerPass( new TwigFormPass() );
        $container->addCompilerPass( new MenuRenderPass());

    }
}

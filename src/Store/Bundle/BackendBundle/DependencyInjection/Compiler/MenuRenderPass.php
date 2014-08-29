<?php

namespace Store\Bundle\BackendBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MenuRenderPass implements  CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $knp_menu = $container->getParameter('knp_menu.renderer.twig.template');

        if( isset( $knp_menu ) )
        {
            $container->setParameter('knp_menu.renderer.twig.template' , 'StoreBackendBundle:menu:knp_menu.html.twig');
        }

    }
}
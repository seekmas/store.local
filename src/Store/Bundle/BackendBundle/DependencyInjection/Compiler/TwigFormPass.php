<?php

namespace Store\Bundle\BackendBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigFormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');
        $resources[] = 'StoreBackendBundle::form/form_div_layouts.html.twig';

        $container->setParameter( 'twig.form.resources' , $resources );
    }
}
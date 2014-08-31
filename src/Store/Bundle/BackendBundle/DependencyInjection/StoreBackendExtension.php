<?php

namespace Store\Bundle\BackendBundle\DependencyInjection;

use Sensio\Bundle\FrameworkExtraBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class StoreBackendExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

//        $processedConfig = $this->processConfiguration(
//            new Configuration() ,
//            $config
//        );
//
//        $container->setParameter(
//            'store_backend.enable_comment' ,
//            $processedConfig['enabled']
//        );
    }

    public function getAlias()
    {
        return 'store_backend';
    }
}

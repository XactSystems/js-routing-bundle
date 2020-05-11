<?php

namespace Xact\JSRoutingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Filesystem\Filesystem;

class XactJSRoutingExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $fileSystem = new Filesystem();
        $projectDir = $container->getParameter('kernel.project_dir');
        $templateDir = $fileSystem->makePathRelative(__DIR__ . '/../Resources/templates/', $projectDir);

        $twigConfig = [];
        $twigConfig['paths'][$templateDir] = "XactJSRouting";
        $container->prependExtensionConfig('twig', $twigConfig);
    }
}


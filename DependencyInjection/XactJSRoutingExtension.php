<?php

namespace Xact\JSRoutingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Filesystem\Filesystem;

/**
 * DI extension class for the JS router
 */
class XactJSRoutingExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Load the DI configuration
     *
     * @param mixed[] $configs
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    /**
     * Prepend the twig configuration with @XactJSRouting for accessing the template
     */
    public function prepend(ContainerBuilder $container): void
    {
        $fileSystem = new Filesystem();
        $projectDir = $container->getParameter('kernel.project_dir');
        $templateDir = $fileSystem->makePathRelative(__DIR__ . '/../Resources/templates/', $projectDir);

        $twigConfig = [];
        $twigConfig['paths'][$templateDir] = "XactJSRouting";
        $container->prependExtensionConfig('twig', $twigConfig);
    }
}

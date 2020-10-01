<?php

namespace Xact\JSRoutingBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/**
 * Test kernel class
 */
class TestKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * @inheritDoc
     */
    public function registerBundles()
    {
        $bundles = [
            \Symfony\Bundle\FrameworkBundle\FrameworkBundle::class,
        ];

        foreach ($bundles as $class) {
            yield new $class();
        }
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../Resources/config/tests/framework.yaml');
    }
}

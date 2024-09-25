<?php

declare(strict_types=1);

namespace Xact\JSRouting\Tests;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Test kernel class
 */
class TestKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * @inheritDoc
     */
    public function registerBundles(): iterable
    {
        $bundles = [
            \Symfony\Bundle\FrameworkBundle\FrameworkBundle::class,
        ];

        foreach ($bundles as $class) {
            yield new $class();
        }
    }
}

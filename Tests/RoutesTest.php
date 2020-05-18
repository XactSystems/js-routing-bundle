<?php

namespace Xact\JSRoutingBundle\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Router;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Xact\JSRoutingBundle\Controller\RoutingController;
use Xact\JSRoutingBundle\Extractor\ExtractedRoute;
use Xact\JSRoutingBundle\Extractor\RoutingExtractor;

class RoutesTest extends WebTestCase
{
    protected const JSON_FORMAT = 'json';

    public function testExtractedRoutes()
    {
        self::bootKernel();

        $client = static::createClient();
        $cacheDir = $client->getContainer()->getParameter('kernel.cache_dir');
        $appEnv = 'test';
        $expectedRoutes = new RouteCollection();
        $expectedRoutes->add('literal', new Route('/literal', [], [], ['expose' => true]));
        $expectedRoutes->add('test_param_1', new Route('/test-param-1/{paramValue}', ['paramValue' => 'XYZZY'], [], ['expose' => true]));
        $expectedRoutes->add('test_param_2', new Route('/test-param-2/{paramValue}', [], [], ['expose' => true]));
        $expectedRoutes->add('not_exposed', new Route('/not-exposed'));

        $serializer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()], [new JsonEncoder()]);
        $router = $this->getRouter($expectedRoutes);

        $extractor = new RoutingExtractor($router, $cacheDir, $appEnv);
        $controller = new RoutingController($extractor, $serializer);

        $response = $controller->routingData($serializer);

        $this->assertEquals(200, $response->getStatusCode());
        
        $content = $response->getContent();
        /** @var ExtractedRoute[] $decodedRoutes */
        $decodedRoutes = $serializer->deserialize($content, ExtractedRoute::class . '[]', self::JSON_FORMAT);

        $this->assertEquals(3, count($decodedRoutes));
        $this->assertArrayHasKey('literal', $decodedRoutes);
        $this->assertArrayHasKey('test_param_1', $decodedRoutes);
        $this->assertArrayHasKey('test_param_2', $decodedRoutes);
        $this->assertArrayNotHasKey('not_exposed', $decodedRoutes);

        $p1 = $decodedRoutes['test_param_1'];
        $p1Tokens = $p1->getTokens();
        $p1Defaults = $p1->getDefaults();
        $this->assertGreaterThan(1, count($p1Tokens));
        $this->assertEquals('variable', $p1Tokens[0][0]);
        $this->assertEquals('paramValue', $p1Tokens[0][3]);
        $this->assertArrayHasKey('paramValue', $p1Defaults);
        $this->assertEquals('XYZZY', $p1Defaults['paramValue']);

        $p2 = $decodedRoutes['test_param_2'];
        $p2Tokens = $p2->getTokens();
        $p2Defaults = $p2->getDefaults();
        $this->assertEquals('variable', $p2Tokens[0][0]);
        $this->assertEquals('paramValue', $p2Tokens[0][3]);
        $this->assertArrayNotHasKey('paramValue', $p2Defaults);
    }

    /**
     * Get a mock object which represents a Router
     *
     * @return \Symfony\Component\Routing\Router
     */
    private function getRouter(RouteCollection $routes) : MockObject
    {
        $router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router
            ->expects($this->atLeastOnce())
            ->method('getRouteCollection')
            ->will($this->returnValue($routes));

        return $router;
    }
}


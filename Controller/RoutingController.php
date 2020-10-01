<?php

namespace Xact\JSRoutingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Xact\JSRoutingBundle\Extractor\RoutingExtractor;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Routing controller class
 */
class RoutingController extends AbstractController
{
    protected const JSON_FORMAT = 'json';

    /**
     * @var \Xact\JSRoutingBundle\Extractor\RoutingExtractor
     */
    protected $extractor;

    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    protected $serializer;

    /**
     * Class constructor.
     */
    public function __construct(RoutingExtractor $extractor, SerializerInterface $serializer)
    {
        $this->extractor = $extractor;
        $this->serializer = $serializer;
    }

    /**
     * Return the exposed routes as JSON
     * This method does not have a route and is called directly from the twig template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function routingData(): JsonResponse
    {
        $routes = $this->extractor->getRoutes();
        return JsonResponse::fromJsonString($this->serializer->serialize($routes, self::JSON_FORMAT));
    }
}

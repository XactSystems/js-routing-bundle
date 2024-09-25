<?php

declare(strict_types=1);

namespace Xact\JSRouting\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Xact\JSRouting\Extractor\RoutingExtractor;

class RoutingController extends AbstractController
{
    protected const JSON_FORMAT = 'json';

    public function __construct(
        protected RoutingExtractor $extractor,
        protected SerializerInterface $serializer
    ) {
    }

    /**
     * Return the exposed routes as JSON
     * This method does not have a route and is called directly from the twig template
     */
    public function routingData(): JsonResponse
    {
        $routes = $this->extractor->getRoutes();
        return JsonResponse::fromJsonString($this->serializer->serialize($routes, self::JSON_FORMAT));
    }
}

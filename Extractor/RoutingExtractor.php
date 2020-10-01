<?php

namespace Xact\JSRoutingBundle\Extractor;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author      Ian Foulds<ianfoulds@x-act.co.uk>
 * Dreived from the FOS routing bundle by William DURAND <william.durand1@gmail.com>
 */
class RoutingExtractor
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * Base cache directory
     *
     * @var string
     */
    protected $cacheDir;

    /**
     * APP_ENV setting
     *
     * @var string
     */
    protected $appEnv;

    /**
     * Default constructor.
     *
     * @param object[] $routesToExpose
     */
    public function __construct(RouterInterface $router, string $cacheDir, string $appEnv, array $routesToExpose = [])
    {
        $this->router = $router;
        $this->routesToExpose = $routesToExpose;
        $this->cacheDir = $cacheDir;
        $this->appEnv = $appEnv;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes()
    {
        $exposedRoutes = [];

        /** @var Route $route */
        foreach ($this->getExposedRoutes() as $name => $route) {
            // Maybe there is a better way to do that...
            $compiledRoute = $route->compile();
            $defaults = array_intersect_key(
                $route->getDefaults(),
                array_fill_keys($compiledRoute->getVariables(), null)
            );
            $requirements = $route->getRequirements();
            $hostTokens = method_exists($compiledRoute, 'getHostTokens') ? $compiledRoute->getHostTokens() : [];
            $exposedRoutes[$name] = new ExtractedRoute(
                $compiledRoute->getTokens(),
                $defaults,
                $requirements,
                $hostTokens,
                $route->getMethods(),
                $route->getSchemes()
            );
        }

        return $exposedRoutes;
    }

    /**
     * {@inheritDoc}
     */
    public function getExposedRoutes()
    {
        $routes = [];
        $collection = $this->router->getRouteCollection();
        $pattern = $this->buildPattern();

        foreach ($collection->all() as $name => $route) {
            if (false === $route->getOption('expose')) {
                continue;
            }

            if (
                ($route->getOption('expose') && (true === $route->getOption('expose') || 'true' === $route->getOption('expose')))
                || ('' !== $pattern && preg_match('#' . $pattern . '#', $name))
            ) {
                $routes[$name] = $route;
            }
        }

        return $routes;
    }

    /**
     * {@inheritDoc}
     */
    public function getBaseUrl()
    {
        return $this->router->getContext()->getBaseUrl() ?: '';
    }

    /**
     * {@inheritDoc}
     */
    public function getHost()
    {
        $requestContext = $this->router->getContext();

        $host = $requestContext->getHost();

        if ($this->usesNonStandardPort()) {
            $method = sprintf('get%sPort', ucfirst($requestContext->getScheme()));
            $host .= ':' . $requestContext->$method();
        }

        return $host;
    }

    /**
     * Check whether server is serving this request from a non-standard port.
     */
    protected function usesNonStandardPort(): bool
    {
        return $this->usesNonStandardHttpPort() || $this->usesNonStandardHttpsPort();
    }

    /**
     * {@inheritDoc}
     */
    public function getScheme()
    {
        return $this->router->getContext()->getScheme();
    }

    /**
     * {@inheritDoc}
     */
    public function getCachePath()
    {
        $cachePath = $this->cacheDir . DIRECTORY_SEPARATOR . 'AppJsRouting';
        if (!file_exists($cachePath)) {
            mkdir($cachePath);
        }

        $cachePath = $cachePath . DIRECTORY_SEPARATOR . 'data.json';

        return $cachePath;
    }

    /**
     * {@inheritDoc}
     */
    public function getResources()
    {
        return $this->router->getRouteCollection()->getResources();
    }

    /**
     * Convert the routesToExpose array in a regular expression pattern.
     */
    protected function buildPattern(): string
    {
        $patterns = [];
        foreach ($this->routesToExpose as $toExpose) {
            $patterns[] = '(' . $toExpose . ')';
        }

        return implode('|', $patterns);
    }

    /**
     * Checks whether server is serving HTTP over a non-standard port.
     */
    private function usesNonStandardHttpPort(): bool
    {
        return 'http' === $this->getScheme() && '80' != $this->router->getContext()->getHttpPort();
    }

    /**
     * Checks whether server is serving HTTPS over a non-standard port.
     */
    private function usesNonStandardHttpsPort(): bool
    {
        return 'https' === $this->getScheme() && '443' != $this->router->getContext()->getHttpsPort();
    }
}

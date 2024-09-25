<?php

declare(strict_types=1);

namespace Xact\JSRouting\Extractor;

use Symfony\Component\Config\Resource\ResourceInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author      Ian Foulds<ianfoulds@x-act.co.uk>
 * Derived from the FOS routing bundle by William DURAND <william.durand1@gmail.com>
 */
class RoutingExtractor
{
    /**
     * @param string[] $routesToExpose Array of routes names to expose
     */
    public function __construct(
        protected RouterInterface $router,
        protected string $cacheDir,
        protected string $appEnv,
        protected array $routesToExpose = []
    ) {
    }

    /**
     * @return array<string, \Xact\JSRouting\Extractor\ExtractedRoute>
     */
    public function getRoutes(): array
    {
        $exposedRoutes = [];

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
     * @return array<string, \Symfony\Component\Routing\Route>
     */
    public function getExposedRoutes(): array
    {
        $routes = [];
        $collection = $this->router->getRouteCollection();
        $pattern = $this->buildPattern();

        foreach ($collection->all() as $name => $route) {
            if (false === $route->getOption('expose')) {
                continue;
            }

            if (
                (true === $route->getOption('expose') || 'true' === $route->getOption('expose'))
                || ('' !== $pattern && preg_match('#' . $pattern . '#', $name))
            ) {
                $routes[$name] = $route;
            }
        }

        return $routes;
    }

    public function getBaseUrl(): string
    {
        return $this->router->getContext()->getBaseUrl() ?: '';
    }

    public function getHost(): string
    {
        $requestContext = $this->router->getContext();

        $host = $requestContext->getHost();

        if ($this->usesNonStandardPort()) {
            $method = sprintf('get%sPort', ucfirst($requestContext->getScheme()));
            $host .= ':' . $requestContext->$method();
        }

        return $host;
    }

    public function getScheme(): string
    {
        return $this->router->getContext()->getScheme();
    }

    /**
     * {@inheritDoc}
     */
    public function getCachePath(): string
    {
        $cachePath = $this->cacheDir . DIRECTORY_SEPARATOR . 'AppJsRouting';
        if (!file_exists($cachePath)) {
            mkdir($cachePath);
        }

        $cachePath = $cachePath . DIRECTORY_SEPARATOR . 'data.json';

        return $cachePath;
    }

    /**
     * @return ResourceInterface[]
     */
    public function getResources(): array
    {
        return $this->router->getRouteCollection()->getResources();
    }

    /**
     * Check whether server is serving this request from a non-standard port.
     */
    protected function usesNonStandardPort(): bool
    {
        return $this->usesNonStandardHttpPort() || $this->usesNonStandardHttpsPort();
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

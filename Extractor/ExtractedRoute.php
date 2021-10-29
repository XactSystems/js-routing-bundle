<?php

namespace Xact\JSRoutingBundle\Extractor;

/**
 * Copied from the Friends of Symfony routing bundle
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ExtractedRoute
{
    /**
     * @var string[]
     */
    private $tokens;
    /**
     * @var string[]
     */
    private $defaults;
    /**
     * @var string[]
     */
    private $requirements;
    /**
     * @var string[]
     */
    private $hostTokens;
    /**
     * @var string[]
     */
    private $methods;
    /**
     * @var string[]
     */
    private $schemes;

    /**
     * Constructor
     *
     * @param string[] $tokens
     * @param string[] $defaults
     * @param string[] $requirements
     * @param string[] $hostTokens
     * @param string[] $methods
     * @param string[] $schemes
     */
    public function __construct(array $tokens, array $defaults, array $requirements, array $hostTokens = [], array $methods = [], array $schemes = [])
    {
        $this->tokens = $tokens;
        $this->defaults = $defaults;
        $this->requirements = $requirements;
        $this->hostTokens = $hostTokens;
        $this->methods = $methods;
        $this->schemes = $schemes;
    }

    /**
     * Return the route tokens
     *
     * @return string[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * Return the route defaults
     *
     * @return string[]
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }

    /**
     * Return the route requirements
     *
     * @return string[]
     */
    public function getRequirements(): array
    {
        return $this->requirements;
    }

    /**
     * Return the route host tokens
     *
     * @return string[]
     */
    public function getHostTokens(): array
    {
        return $this->hostTokens;
    }

    /**
     * Return the route methods
     *
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Return the route schemes
     *
     * @return string[]
     */
    public function getSchemes(): array
    {
        return $this->schemes;
    }
}

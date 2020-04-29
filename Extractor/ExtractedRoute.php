<?php

namespace Xact\JSRoutingBundle\Extractor;

/**
 * Copied from the Freinds of Symfony routing bundle
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ExtractedRoute
{
    /**
     * @var array
     */
    private $tokens;
    /**
     * @var array
     */
    private $defaults;
    /**
     * @var array
     */
    private $requirements;
    /**
     * @var array
     */
    private $hosttokens;
    /**
     * @var array
     */
    private $methods;
    /**
     * @var array
     */
    private $schemes;

    /**
     * Constructor
     *
     * @param array $tokens
     * @param array $defaults
     * @param array $requirements
     * @param array $hosttokens
     * @param array $methods
     * @param array $schemes
     */
    public function __construct(array $tokens, array $defaults, array $requirements, array $hosttokens = [], array $methods = [], array $schemes = [])
    {
        $this->tokens = $tokens;
        $this->defaults = $defaults;
        $this->requirements = $requirements;
        $this->hosttokens = $hosttokens;
        $this->methods = $methods;
        $this->schemes = $schemes;
    }

    /**
     * Return the route tokens
     *
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Return the route defaults
     *
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Return the route requirements
     *
     * @return array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Return the route host tokens
     *
     * @return array
     */
    public function getHosttokens()
    {
        return $this->hosttokens;
    }

    /**
     * Return the route methods
     *
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Return the route schemes
     *
     * @return array
     */
    public function getSchemes()
    {
        return $this->schemes;
    }
}

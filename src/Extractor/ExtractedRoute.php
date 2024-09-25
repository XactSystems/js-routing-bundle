<?php

declare(strict_types=1);

namespace Xact\JSRouting\Extractor;

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
     * Constructor
     *
     * @param string[] $tokens
     * @param string[] $defaults
     * @param string[] $requirements
     * @param string[] $hostTokens
     * @param string[] $methods
     * @param string[] $schemes
     */
    public function __construct(
        private array $tokens,
        private array $defaults,
        private array $requirements,
        private array $hostTokens = [],
        private array $methods = [],
        private array $schemes = []
    ) {
    }

    /**
     * @return string[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @return string[]
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }

    /**
     * @return string[]
     */
    public function getRequirements(): array
    {
        return $this->requirements;
    }

    /**
     * @return string[]
     */
    public function getHostTokens(): array
    {
        return $this->hostTokens;
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @return string[]
     */
    public function getSchemes(): array
    {
        return $this->schemes;
    }
}

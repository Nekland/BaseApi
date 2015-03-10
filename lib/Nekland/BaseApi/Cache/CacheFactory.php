<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Cache;


use Nekland\BaseApi\Cache\Provider\CacheProviderInterface;
use Nekland\BaseApi\Cache\Provider\FileProvider;

class CacheFactory
{
    /**
     * @var array
     */
    private $namespaces;

    public function __construct($namespaces = null)
    {
        $this->namespaces = $namespaces ?: [];
    }

    /**
     * @param string[CacheStrategyInterface $cacheStrategy
     * @param string[CacheProviderInterface $cacheProvider
     * @param array                         $options
     * @return CacheStrategyInterface
     * @throws \RuntimeException
     */
    public function createCacheStrategy($cacheStrategy, $cacheProvider = null, array $options = [])
    {
        $provider = $this->createProvider($cacheProvider, $options);

        foreach ($this->namespaces as $namespace) {
            $class = $namespace . '\\' . $cacheStrategy;
            if (class_exists($class)) {
                $class = new $class();
                $class->setProvider($provider);

                return $class;
            }
        }

        throw new \RuntimeException(sprintf('Impossible to find a cache strategy named %s', $cacheStrategy));
    }

    /**
     * @param string|CacheProviderInterface $provider
     * @param array $options
     * @return CacheProviderInterface
     * @throws \RuntimeException
     */
    public function createProvider($provider, array $options = null)
    {
        if ($provider === null) {
            return (new FileProvider())->setOptions($options);
        }

        if (is_object($provider)) {
            if (!($provider instanceof CacheProviderInterface)) {
                throw new \RuntimeException(
                    'The cache provider must implements Nekland\BaseApi\Cache\Provider\CacheProviderInterface'
                );
            }
            $provider->setOptions($options);

            return $provider;
        }

        foreach ($this->namespaces as $namespace) {
            if (
                class_exists($class = $namespace . '\\' . $provider) ||
                class_exists($class = $namespace . '\\Provider\\' . $provider)
            ) {
                $provider = new $class;

                return $provider;
            }
        }

        throw new \RuntimeException(sprintf('Impossible to find the provider %s', $provider));
    }
}

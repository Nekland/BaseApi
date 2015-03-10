<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Cache\Provider;


interface CacheProviderInterface
{
    /**
     * Loads the cache
     */
    public function load();

    /**
     * Saves the cache
     */
    public function save();

    /**
     * @param string $key
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * @param array $options
     */
    public function setOptions(array $options);
}

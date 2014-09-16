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


class FileProvider implements CacheProviderInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $cache;

    public function setOptions(array $options)
    {
        $this->options = array_merge($this->getOptions(), $options);
        return $this;
    }

    public function load()
    {
        $path = $this->getPath();
        if (!is_file($path)) {
            @file_put_contents($path, serialize([]));
        }

        $this->cache = unserialize(file_get_contents($this->getPath()));
    }

    public function save()
    {
        file_put_contents($this->getPath(), serialize($this->cache));
    }

    public function get($key)
    {
        return $this->cache[$key];
    }

    public function set($key, $value)
    {
        $this->cache[$key] = $value;
        return $this;
    }

    protected function getPath()
    {
        return $this->options['path'];
    }

    protected function getOptions()
    {
        return $this->options ?: [
            'path' => sys_get_temp_dir() . '/nekland_api_cache_file'
        ];
    }
}

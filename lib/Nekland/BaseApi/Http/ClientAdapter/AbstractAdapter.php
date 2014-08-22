<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */
namespace Nekland\BaseApi\Http\ClientAdapter;


use Nekland\BaseApi\Http\ClientInterface;

abstract class AbstractAdapter implements ClientInterface
{
    /**
     * @var mixed[]
     */
    private $options = [
        'base_url'   => '',
        'user_agent' => 'php-base-api (https://github.com/Nekland/BaseApi)'
    ];

    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Complete headers using options
     *
     * @param  array $headers
     * @return array
     */
    protected function getHeaders(array $headers = [])
    {
        return array_merge(['User-Agent' => $this->options['user_agent']], $headers);
    }

    /**
     * Generate a complete URL using the option "base_url"
     *
     * @param  string $path The api uri
     * @return string
     */
    protected function getPath($path)
    {
        return $this->options['base_url'] . $path;
    }
}

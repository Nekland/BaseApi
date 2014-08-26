<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Http;


class Request
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $body;

    /**
     * @var array
     */
    private $headers;

    /**
     * @param string $method
     * @param string $path
     * @param array  $body
     * @param array  $headers
     */
    public function __construct($method, $path, array $body = [], array $headers = [])
    {
        $this->method  = $method;
        $this->path    = $path;
        $this->body    = $body;
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return strtolower($this->method);
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}

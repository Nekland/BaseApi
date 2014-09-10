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
     * Body parameters
     * used in PUT, POST and DELETE methods
     *
     * @var array
     */
    private $body;

    /**
     * @var array
     */
    private $headers;

    /**
     * URI parameters
     * basically for GET requests
     *
     * @var array
     */
    private $parameters;

    /**
     * @param string $method
     * @param string $path
     * @param array  $body if the method is GET it's taken as parameters
     * @param array  $headers
     */
    public function __construct($method, $path, array $body = [], array $headers = [])
    {
        $this->method  = $method;
        $this->path    = $path;
        $this->headers = $headers;

        if ($method === 'GET') {
            $this->parameters = $body;
        } else {
            $this->body = $body;
        }
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param  string $name
     * @return bool
     */
    public function hasHeader($name)
    {
        return isset($this->headers[$name]);
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

    /**
     * @return string
     */
    public function getUrl()
    {
        $parameters = '';

        if (!empty($this->parameters)) {
            $parameters = false === strpos($this->path, '?') ? '?' : '&';

            foreach ($this->parameters as $name => $value) {
                $parameters .= $name . '=' . $value;
            }
        }

        return $this->path . $parameters;
    }

    /**
     * @param  array $body
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param  array $headers
     * @return self
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param  string $method
     * @return self
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param  string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param mixed[] $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $name
     * @param mixed  $parameter
     * @return self
     */
    public function setParameter($name, $parameter)
    {
        $this->parameters[$name] = $parameter;
        return $this;
    }

    /**
     * @param  string $name
     * @return mixed
     */
    public function getParameter($name)
    {
        return $this->parameters[$name];
    }
}

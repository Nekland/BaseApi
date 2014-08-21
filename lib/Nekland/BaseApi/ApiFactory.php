<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi;

use Nekland\BaseApi\Exception\MissingApiException;

use Nekland\BaseApi\Http\ClientInterface;

abstract class ApiFactory implements ApiInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $httpClient)
    {
        $this->client = $httpClient;
    }

    /***
     * @param string $method
     * @param array  $options
     */
    public function authenticate($method, array $options)
    {
        $this->client->authenticate($method, $options);
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    public function __call($name)
    {
        $apiName = str_replace(['get', 'Api'], '', str_replace('Api', '', $name));

        foreach ($this->getApiNamespaces() as $namespace) {
            $class = $namespace . '\\' . $apiName;
            if (class_exists($class)) {
                return new $class($this->client);
            }
        }

        throw new MissingApiException($apiName);
    }

    /**
     * Return array of namespaces where AbstractApi instance are localized
     *
     *
     * @return string[] Example: ['Nekland\BaseApi\Api']
     */
    abstract protected function getApiNamespaces();
}

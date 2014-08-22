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

use Nekland\BaseApi\Api\AbstractApi;
use Nekland\BaseApi\Exception\MissingApiException;

use Nekland\BaseApi\Http\ClientInterface;
use Nekland\BaseApi\Http\HttpClientFactory;

abstract class ApiFactory implements ApiInterface
{
    /**
     * @var HttpClientFactory
     */
    private $clientFactory;

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(HttpClientFactory $httpClientFactory)
    {
        $this->clientFactory = $httpClientFactory;
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

    /**
     * @param  string $name
     * @return AbstractApi
     * @throws \RuntimeException|MissingApiException
     */
    public function __call($name)
    {
        $apiName = str_replace(['get', 'Api'], '', str_replace('Api', '', $name));

        foreach ($this->getApiNamespaces() as $namespace) {
            $class = $namespace . '\\' . $apiName;
            if (class_exists($class)) {
                $api = new $class($this->getClient());

                if ($api instanceof AbstractApi) {
                    return $api;
                }

                throw new \RuntimeException(
                    sprintf('The API %s is found but does not implements AbstractApi.', $apiName)
                );
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

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

    /**
     * @param string $name
     * @return \Nekland\BaseApi\Api\AbstractApi
     */
    abstract public function api($name);

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
}

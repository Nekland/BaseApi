<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Api;

use Nekland\BaseApi\Api;
use Nekland\BaseApi\Http\AbstractHttpClient;
use Nekland\BaseApi\Transformer\JsonTransformer;
use Nekland\BaseApi\Transformer\TransformerInterface;

abstract class AbstractApi
{
    /**
     * @var AbstractHttpClient
     */
    private $client;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    public function __construct(AbstractHttpClient $client, TransformerInterface $transformer = null) {
        $this->client      = $client;
        $this->transformer = $transformer ?: new JsonTransformer();
    }

    /**
     * Set the transformer that will be used to return data
     *
     * @param  TransformerInterface $transformer
     * @return self
     */
    public function setTransformer(TransformerInterface $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Execute a http get query
     *
     * @param  string $path
     * @param  array  $body
     * @param  array  $headers
     * @return array|mixed
     */
    protected function get($path, array $body = [], array $headers = [])
    {
        $client  = $this->getClient();
        $request = AbstractHttpClient::createRequest('GET', $path, $body, $headers);

        return $this->transformer->transform($client->send($request));
    }

    /**
     * Execute a http put query
     *
     * @param  string        $path
     * @param  array|string  $body
     * @param  array         $headers
     * @return array|mixed
     */
    protected function put($path, $body = [], array $headers = [])
    {
        $client  = $this->getClient();
        $request = AbstractHttpClient::createRequest('PUT', $path, $body, $headers);

        return $this->transformer->transform($client->send($request));
    }

    /**
     * Execute a http post query
     *
     * @param  string        $path
     * @param  array|string  $body
     * @param  array         $headers
     * @return array|mixed
     */
    protected function post($path, $body = [], array $headers = [])
    {
        $client  = $this->getClient();
        $request = AbstractHttpClient::createRequest('POST', $path, $body, $headers);

        return $this->transformer->transform($client->send($request));
    }

    /**
     * Execute a http delete query
     *
     * @param  string        $path
     * @param  array|string  $body
     * @param  array         $headers
     * @return array|mixed
     */
    protected function delete($path, $body = [], array $headers = [])
    {
        $client  = $this->getClient();
        $request = AbstractHttpClient::createRequest('DELETE', $path, $body, $headers);

        return $this->transformer->transform($client->send($request));
    }

    /**
     * @return AbstractHttpClient
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @return TransformerInterface
     */
    protected function getTransformer()
    {
        return $this->transformer;
    }
}

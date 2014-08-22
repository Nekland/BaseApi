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
use Nekland\BaseApi\Cache\CacheStrategyInterface;
use Nekland\BaseApi\Http\ClientInterface;
use Nekland\BaseApi\Transformer\JsonTransformer;
use Nekland\BaseApi\Transformer\TransformerInterface;

abstract class AbstractApi
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    /**
     * @var \Nekland\BaseApi\Cache\CacheStrategyInterface
     */
    private $cache;

    public function __construct(
        ClientInterface $client,
        TransformerInterface $transformer = null,
        CacheStrategyInterface $cache = null
    ) {
        $this->client    = $client;
        $this->transformer = $transformer ?: new JsonTransformer();
        $this->cache       = $cache;
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

    protected function get($path, array $parameters = [], array $headers = [])
    {
        $client = $this->getClient();

        $closure = function ($path, array $parameters = [], array $headers = []) use ($client) {
            return $client->get($path, $parameters, $headers);
        };

        return $this->transformer->transform($this->execute(
            $closure,
            ['path' => $path, 'parameters' => $parameters, 'headers' => $headers]
        ));
    }

    private function execute($closure, $parameters)
    {
        if ($this->cache !== null) {
            return $this->cache->prepare($closure, $parameters);
        }

        return $closure($parameters['path'], $parameters['parameters'], $parameters['headers']);
    }

    protected function getClient()
    {
        return $this->client;
    }

    protected function getTransformer()
    {
        return $this->transformer;
    }
}

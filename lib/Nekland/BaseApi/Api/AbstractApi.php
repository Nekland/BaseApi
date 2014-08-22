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

    public function __construct(ClientInterface $client, TransformerInterface $transformer = null)
    {
        $this->client    = $client;
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

    protected function get($path, array $parameters = [], array $requestHeaders = [])
    {
        return $this->transformer->transform($this->getClient()->get($path, $parameters, $requestHeaders));
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

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
use Nekland\BaseApi\Cache\CacheStrategyInterface;
use Nekland\BaseApi\Exception\MissingApiException;

use Nekland\BaseApi\Http\Auth\AuthFactory;
use Nekland\BaseApi\Http\Auth\AuthStrategyInterface;
use Nekland\BaseApi\Http\Event\Events;
use Nekland\BaseApi\Http\HttpClientFactory;
use Nekland\BaseApi\Transformer\JsonTransformer;
use Nekland\BaseApi\Transformer\TransformerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class ApiFactory
{
    /**
     * @var HttpClientFactory
     */
    private $clientFactory;

    /**
     * @var Http\Auth\AuthFactory
     */
    private $authFactory;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    public function __construct(
        EventDispatcher $dispatcher = null,
        TransformerInterface $transformer = null,
        AuthFactory $authFactory = null,
        HttpClientFactory $httpClientFactory = null
    ) {
        $this->dispatcher    = $dispatcher ?: new EventDispatcher();
        $this->clientFactory = $httpClientFactory ?: new HttpClientFactory($this->dispatcher);
        $this->authFactory   = $authFactory;
        $this->transformer   = $transformer;
    }


    /**
     * Allow the user to add an authentication to the request
     *
     * @param string|AuthStrategyInterface $auth
     * @param array                        $options
     */
    public function useAuthentication($auth, array $options = [])
    {
        if (!($auth instanceof AuthStrategyInterface)) {
            $auth = $this->getAuthFactory()->get($auth);
            $auth->setOptions($options);
        }

        $this->dispatcher->addListener(Events::ON_REQUEST_EVENT, [
            $auth,
            'auth'
        ]);
    }

    /**
     * @param CacheStrategyInterface  $cacheStrategy
     */
    public function useCache(CacheStrategyInterface $cacheStrategy)
    {
        $this->dispatcher->addListener(
            Events::ON_REQUEST_EVENT,
            [ $cacheStrategy, 'execute' ]
        );
    }

    /**
     * @return \Nekland\BaseApi\Http\AbstractHttpClient
     */
    public function getClient()
    {
        return $this->clientFactory->createHttpClient();
    }

    /**
     * @return HttpClientFactory
     */
    public function getHttpClientFactory()
    {
        return $this->clientFactory;
    }

    /**
     * @param HttpClientFactory $clientFactory
     * @return self
     */
    public function setHttpClientFactory(HttpClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;

        return $this;
    }

    /**
     * @param TransformerInterface $transformer
     */
    public function setTransformer(TransformerInterface $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param  string $name
     * @param   array  $parameters
     * @return AbstractApi
     * @throws \RuntimeException|MissingApiException
     */
    public function __call($name, $parameters)
    {
        $apiName = str_replace(['get', 'Api'], '', str_replace('Api', '', $name));

        foreach ($this->getApiNamespaces() as $namespace) {
            $class = $namespace . '\\' . $apiName;
            if (class_exists($class)) {
                $api = new $class($this->getClient(), $this->getTransformer());

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
     * @return AuthFactory
     */
    protected function getAuthFactory()
    {
        return $this->authFactory ?: new AuthFactory($this->getClient());
    }

    /**
     * @return TransformerInterface
     */
    protected function getTransformer()
    {
        return $this->transformer ?: new JsonTransformer();
    }

    /**
     * Return array of namespaces where AbstractApi instance are localized
     *
     *
     * @return string[] Example: ['Nekland\BaseApi\Api']
     */
    abstract protected function getApiNamespaces();
}

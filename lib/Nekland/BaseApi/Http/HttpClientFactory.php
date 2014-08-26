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

use Nekland\BaseApi\Cache\CacheStrategyInterface;
use Nekland\BaseApi\Http\Auth\AuthFactory;
use Nekland\BaseApi\Http\Auth\AuthListener;
use Nekland\BaseApi\Http\Auth\AuthStrategyInterface;
use Nekland\BaseApi\Http\ClientAdapter\GuzzleAdapter;
use Nekland\BaseApi\Http\Event\Events;
use Symfony\Component\EventDispatcher\EventDispatcher;

class HttpClientFactory
{
    /**
     * @var AuthFactory
     */
    private $authFactory;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $dispatcher;

    /**
     * @var string
     */
    private $classes = [
        'guzzle4' => 'Nekland\BaseApi\Api\Http\ClientAdapter\GuzzleAdapter'
    ];

    private $options = [];

    public function __construct(array $options = [], EventDispatcher $eventDispatcher = null)
    {
        $this->options     = array_merge_recursive($this->options, $options);
        $this->dispatcher  = $eventDispatcher ?: new EventDispatcher();
        $this->authFactory = new AuthFactory();
    }

    /**
     * Generate an HttpClient object
     *
     * @param  string  $name
     * @param  null    $client
     * @return GuzzleAdapter|null
     * @throws \InvalidArgumentException
     */
    public function createHttpClient($name = '', $client = null)
    {
        if (empty($name)) {
            return new GuzzleAdapter($this->options, $client);
        }

        if (!isset($this->classes[$name])) {
            throw new \InvalidArgumentException(sprintf('The client "%s" is not registered.', $name));
        }

        $class = $this->classes[$name];
        $client = new $class($this->options, $client);

        if ($client instanceof ClientInterface) {
            return $client;
        }

        throw new \InvalidArgumentException('The client must be an implementation of ClientInterface.');
    }

    /**
     * @param  string $name
     * @param  string $class
     * @throws \InvalidArgumentException
     */
    public function register($name, $class)
    {
        if (class_exists($class)) {
            $this->classes[$name] = $class;
        }

        throw new \InvalidArgumentException(sprintf('%s is not a valid class name.', $name));
    }

    /**
     * Allow the user to add an authentication to the request
     *
     * @param string|AuthStrategyInterface $auth
     * @param array                        $options
     */
    public function authenticate($auth, array $options = [])
    {
        if (!($auth instanceof AuthStrategyInterface)) {
            $auth = $this->authFactory->get($auth);
            $auth->setOptions($options);
        }

        $this->dispatcher->addListener(Events::ON_REQUEST_EVENT, array(
            new AuthListener($auth),
            'onRequestBeforeSend'
        ));
    }

    /**
     * @param CacheStrategyInterface $cacheStrategy
     */
    public function useCache(CacheStrategyInterface $cacheStrategy)
    {
        $this->dispatcher->addListener(
            Events::ON_REQUEST_EVENT,
            [ $cacheStrategy, 'execute' ]
        );
    }

    /**
     * @return AuthFactory
     */
    public function getAuthFactory()
    {
        return $this->authFactory;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return HttpClient
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }
}

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

use Nekland\BaseApi\Http\Auth\AuthFactory;
use Nekland\BaseApi\Http\Auth\AuthListener;
use Nekland\BaseApi\Http\ClientAdapter\GuzzleAdapter;
use Symfony\Component\EventDispatcher\EventDispatcher;

class HttpClientFactory
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $dispatcher;

    /**
     * @var array
     */
    private $classes = [
        'guzzle4' => [
            'class'       => 'Nekland\BaseApi\Http\ClientAdapter\GuzzleAdapter',
            'requirement' => 'GuzzleHttp\Client'
        ]
    ];

    /**
     * @var array
     */
    private $options = [];

    public function __construct(array $options = [], EventDispatcher $eventDispatcher = null)
    {
        $this->options     = array_merge($this->options, $options);
        $this->dispatcher  = $eventDispatcher ?: new EventDispatcher();
    }

    /**
     * Generate the best http client according to the detected configuration
     *
     * @param  string  $name
     * @param  null    $client
     * @return GuzzleAdapter|AbstractHttpClient
     * @throws \InvalidArgumentException
     */
    public function createHttpClient($name = '', $client = null)
    {
        if (empty($name)) {
            return $this->createBestClient();
        }

        if (!isset($this->classes[$name])) {
            throw new \InvalidArgumentException(sprintf('The client "%s" is not registered.', $name));
        }

        $class = $this->classes[$name]['class'];
        $client = new $class($this->dispatcher, $this->options, $client);

        if ($client instanceof AbstractHttpClient) {
            return $client;
        }

        throw new \InvalidArgumentException('The client must be an implementation of ClientInterface.');
    }

    /**
     * @return AbstractHttpClient
     * @throws \RuntimeException
     */
    public function createBestClient()
    {
        foreach ($this->classes as $name => $definition) {

            if (is_callable($definition['requirement'])) {
                if (!call_user_func($definition['requirement'])) {
                    continue;
                }
            }
            if (!empty($definition['requirement'])) {
                if (!class_exists($definition['requirement'])) {
                    continue;
                }
            }
            $className = $definition['class'];

            return new $className($this->dispatcher, $this->options);
        }

        throw new \RuntimeException('Impossible to find a Client class.');
    }

    /**
     * Register a new client that will be able to be use by the ApiFactory
     *
     * @param  string          $name
     * @param  string          $class
     * @param  string|callable $requirement
     * @param  bool            $priority
     * @throws \InvalidArgumentException
     */
    public function register($name, $class, $requirement = '', $priority = false)
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid class name.', $class));
        }

        $definition = [
            'class'       => $class,
            'requirement' => $requirement
        ];

        if ($priority) {
            $this->classes = array_merge_recursive([$name => $definition], $this->classes);
        } else {
            $this->classes[$name] = $definition;
        }
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

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

use Guzzle\Http\Exception\ServerErrorResponseException;
use Nekland\BaseApi\Http\Auth\AuthFactory;
use Nekland\BaseApi\Http\Auth\AuthListener;

abstract class HttpClientFactory implements ClientInterface
{
    /**
     * @var array
     */
    private $options = [
        'base_url'   => '',
        'user_agent' => 'php-base-api (https://github.com/Nekland/BaseApi)'
    ];

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var AuthFactory
     */
    private $authFactory;

    public function __construct(array $options = [], $client)
    {
        $this->options = array_merge_recursive($this->options, $options);
        $this->client = $this->createGuzzleClient();
        $this->authFactory = new AuthFactory();

        $this->clearHeaders();
    }

    protected function clearHeaders()
    {
        $this->headers = [
            'User-Agent' => $this->options['user_agent']
        ];
    }

    /**
     * @param $path
     * @param array $parameters
     * @param array $headers
     * @return \Guzzle\Http\Message\Response
     */
    public function get($path, array $parameters = [], array $headers = [])
    {
        return $this->request($path, null, 'GET', $headers, array('query' => $parameters))->getBody();
    }

    public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array())
    {
        $request = $this->createRequest($httpMethod, $path, $body, $headers, $options);

        $response = $this->client->send($request);

        $this->lastRequest  = $request;
        $this->lastResponse = $response;


        return $response;
    }

    /***
     * @param string $method
     * @param array  $options
     */
    public function authenticate($method, array $options)
    {
        $auth = $this->authFactory->get($method);
        $auth->setOptions($options);

        $this->addListener('request.before_send', array(
            new AuthListener($auth),
            'onRequestBeforeSend'
        ));
    }

    /**
     * Add an event on the http client
     *
     * @param $eventName
     * @param $listener
     */
    public function addListener($eventName, $listener)
    {
        $this->client->getEventDispatcher()->addListener($eventName, $listener);
    }


    protected function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array())
    {
        return $this->client->createRequest(
            $httpMethod,
            $path,
            array_merge($this->headers, $headers),
            $body,
            $options
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

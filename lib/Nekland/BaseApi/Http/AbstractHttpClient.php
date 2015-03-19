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


use Nekland\BaseApi\Http\Event\Events;
use Nekland\BaseApi\Http\Event\RequestEvent;
use Nekland\BaseApi\Http\Request;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class AbstractHttpClient
{
    /**
     * @var mixed[]
     */
    private $options = [
        'base_url'   => '',
        'user_agent' => 'php-base-api (https://github.com/Nekland/BaseApi)'
    ];

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(EventDispatcher $eventDispatcher, array $options = [])
    {
        $this->dispatcher = $eventDispatcher;
        $this->options    = array_merge($this->options, $options);
    }

    /**
     * @param Request $request
     * @param bool    $withEvent if an event send a request, in order to avoid infinite while
     * @return string
     * @throws \BadMethodCallException
     */
    public function send(Request $request, $withEvent = true)
    {
        $method = $request->getMethod();

        if (!in_array($method, ['get', 'put', 'post', 'delete'])) {
            throw new \BadMethodCallException(sprintf(
                'The http method "%s" does not exists or is not supported.',
                $method
            ));
        }

        $event = new RequestEvent($request, $this);
        if ($withEvent) {
            $event = $this->getEventDispatcher()->dispatch(Events::ON_REQUEST_EVENT, $event);
        }

        if (!$event->requestCompleted()) {
            $res = $this->execute($request);
            $event->setResponse($res);
        }

        if ($withEvent) {
            $this->getEventDispatcher()->dispatch(Events::AFTER_REQUEST_EVENT, $event);
        }

        return (string) $event->getResponse();
    }

    /**
     * Execute a request
     *
     * @param Request $request
     * @return Response
     */
    abstract protected function execute(Request $request);

    /**
     * Complete headers using options
     *
     * @param  array $headers
     * @return array
     */
    protected function getHeaders(array $headers = [])
    {
        return array_merge(['User-Agent' => $this->options['user_agent']], $headers);
    }

    /**
     * Generate a complete URL using the option "base_url"
     *
     * @param  string $path The api uri
     * @return string
     */
    protected function getPath($path)
    {
        $hasHttp = strpos($path, 'http');
        if (false === $hasHttp || $hasHttp !== 0) {
            return $this->options['base_url'] . $path;
        }

        return $path;
    }

    /**
     * Generate a request object
     *
     * @param  string        $method
     * @param  string        $path
     * @param  array|string  $body
     * @param  array         $headers
     * @return Request
     */
    public static function createRequest($method, $path, $body = [], array $headers = [])
    {
        return new Request($method, $path, $body, $headers);
    }

    /**
     * @param string $body
     * @param array  $headers
     * @return Response
     */
    public static function createResponse($body, array $headers)
    {
        return new Response($body, $headers);
    }

    /**
     * @return EventDispatcher
     */
    protected function getEventDispatcher()
    {
        return $this->dispatcher;
    }
}

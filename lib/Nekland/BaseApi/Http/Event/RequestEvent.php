<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Http\Event;


use Nekland\BaseApi\Http\AbstractHttpClient;
use Nekland\BaseApi\Http\Request;
use Nekland\BaseApi\Http\Response;
use Symfony\Component\EventDispatcher\Event;

class RequestEvent extends Event
{
    /**
     * @var \Nekland\BaseApi\Http\Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var \Nekland\BaseApi\Http\AbstractHttpClient
     */
    private $client;

    public function __construct(Request $request, AbstractHttpClient $client)
    {
        $this->request = $request;
        $this->client  = $client;
    }

    /**
     * @return \Nekland\BaseApi\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param  Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return bool
     */
    public function requestCompleted()
    {
        return isset($this->response);
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return AbstractHttpClient
     */
    public function getClient()
    {
        return $this->client;
    }
}

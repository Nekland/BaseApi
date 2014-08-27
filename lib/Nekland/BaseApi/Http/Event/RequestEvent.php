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


use Nekland\BaseApi\Http\Request;
use Symfony\Component\EventDispatcher\Event;

class RequestEvent extends Event
{
    /**
     * @var \Nekland\BaseApi\Http\Request
     */
    private $request;

    /**
     * @var string
     */
    private $response;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Nekland\BaseApi\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param  mixed $response
     * @throws \InvalidArgumentException
     */
    public function setResponse($response)
    {
        if (!is_string($response)) {
            throw new \InvalidArgumentException('The response should be send as string');
        }

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
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }
}

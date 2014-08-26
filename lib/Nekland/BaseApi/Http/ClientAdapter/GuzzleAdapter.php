<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Http\ClientAdapter;


use GuzzleHttp\Client;
use Nekland\BaseApi\Http\Event\Events;
use Nekland\BaseApi\Http\Event\RequestEvent;
use Nekland\BaseApi\Http\Request;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GuzzleAdapter extends AbstractAdapter
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzle;

    public function __construct(array $options = [], EventDispatcher $dispatcher = null, Client $client = null)
    {
        parent::__construct($dispatcher, $options);
        $this->guzzle = $client ?: new Client();
    }

    public function send(Request $request)
    {
        $method = $request->getMethod();

        if (!in_array($method, ['get', 'put', 'post', 'delete'])) {
            throw new \BadMethodCallException(sprintf(
                'The http method "%s" does not exists or is not supported.',
                $method
            ));
        }

        $event = new RequestEvent($request);

        $this->getEventDispatcher()->dispatch(Events::ON_REQUEST_EVENT, $event);

        if ($event->requestCompleted()) {
            return $event->getResponse();
        }


        return $this->guzzle->$method($this->getPath($request->getPath()), [
            'headers' => $this->getHeaders($request->getHeaders()),
            'body'    => $request->getBody()
        ])->getBody();
    }
}

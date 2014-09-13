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
use Nekland\BaseApi\Http\AbstractHttpClient;
use Nekland\BaseApi\Http\Request;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GuzzleAdapter extends AbstractHttpClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzle;

    public function __construct(EventDispatcher $dispatcher, array $options = [], Client $client = null)
    {
        parent::__construct($dispatcher, $options);
        $this->guzzle = $client ?: new Client();
    }

    protected function execute(Request $request)
    {
        $method = $request->getMethod();

        var_dump($request->getUrl());

        return $this->guzzle->$method($this->getPath($request->getUrl()), [
            'headers' => $this->getHeaders($request->getHeaders()),
            'body'    => $request->getBody()
        ])->getBody();
    }
}

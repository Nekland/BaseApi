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

class GuzzleAdapter extends AbstractAdapter
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzle;

    public function __construct(Client $client = null)
    {
        $this->guzzle = $client ?: new Client();
    }

    public function get($path, array $parameters = [], array $headers = [])
    {
        // TODO: Implement get() method.
    }

    public function post($path, array $parameters = [], array $headers = [])
    {
        // TODO: Implement post() method.
    }

    public function put($path, array $parameters = [], array $headers = [])
    {
        // TODO: Implement put() method.
    }

    public function delete($path, array $parameters = [], array $headers = [])
    {
        // TODO: Implement delete() method.
    }

    public function authenticate($method, array $options)
    {
        // TODO: Implement authenticate() method.
    }
}

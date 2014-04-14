<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Api;


use Nekland\BaseApi\Api;

abstract class AbstractApi
{
    protected $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    protected function get($path, array $parameters = [], array $requestHeaders = [])
    {
        return json_decode((string) $this->api->getClient()->get($path, $parameters, $requestHeaders), true);
    }
}

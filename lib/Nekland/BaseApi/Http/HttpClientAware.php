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

abstract class HttpClientAware
{
    /**
     * @var AbstractHttpClient
     */
    protected $httpClient;

    /**
     * @param AbstractHttpClient $client
     */
    public function setClient(AbstractHttpClient $client)
    {
        $this->httpClient = $client;
    }
}

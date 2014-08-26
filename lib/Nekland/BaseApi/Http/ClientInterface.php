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


interface ClientInterface
{
    /**
     * Generate a request object
     *
     * @param  string $method
     * @param  string $path
     * @param  array  $parameters
     * @param  array  $headers
     * @return Request
     */
    public static function createRequest($method, $path, array $parameters = [], array $headers = []);

    /**
     * @param  Request $request
     * @return string
     */
    public function send(Request $request);
}

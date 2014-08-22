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
     * Execute a GET request on the given path
     *
     * @param string $path       The path of the URL to get
     * @param array  $parameters The parameters of the request
     * @param array  $headers    The headers of the request
     * @return string
     */
    public function get($path, array $parameters = [], array $headers = []);

    /**
     * Execute a POST request on the given path
     *
     * @param string $path       The path of the URL to get
     * @param array  $parameters The parameters of the request
     * @param array  $headers    The headers of the request
     * @return string
     */
    public function post($path, array $parameters = [], array $headers = []);

    /**
     * Execute a PUT request on the given path
     *
     * @param string $path       The path of the URL to get
     * @param array  $parameters The parameters of the request
     * @param array  $headers    The headers of the request
     * @return string
     */
    public function put($path, array $parameters = [], array $headers = []);

    /**
     * Execute a DELETE request on the given path
     *
     * @param string $path       The path of the URL to get
     * @param array  $parameters The parameters of the request
     * @param array  $headers    The headers of the request
     * @return string
     */
    public function delete($path, array $parameters = [], array $headers = []);

    public function authenticate($method, array $options);
}

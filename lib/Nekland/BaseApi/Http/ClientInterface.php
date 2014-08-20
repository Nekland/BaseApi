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
    public function get($path, array $parameters = [], array $headers = []);

    public function post($path, array $parameters = [], array $headers = []);

    public function put($path, array $parameters = [], array $headers = []);

    public function delete($path, array $parameters = [], array $headers = []);

    public function setFormatter();

    public function authenticate($method, array $options);
}

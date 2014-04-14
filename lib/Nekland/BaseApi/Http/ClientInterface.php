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

    public function authenticate($method, array $options);
}

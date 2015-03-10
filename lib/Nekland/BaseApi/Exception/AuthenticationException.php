<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Exception;


class AuthenticationException extends \Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message ?: 'The authentication to the API fails.');
    }
}

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

class MissingApiException extends \Exception
{
    public function __construct($name, $message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            sprintf('The api "%s" does not exists, please check the docs.%s', $name, $message, $code, $previous)
        );
    }
}

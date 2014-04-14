<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Http\Auth;

use Guzzle\Common\Event;

class AuthListener
{
    /**
     * @var AuthInterface
     */
    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function onRequestBeforeSend(Event $event)
    {
        if (null === $this->auth) {
            return;
        }

        $this->auth->auth($event['request']);
    }
}

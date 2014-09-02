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

use Nekland\BaseApi\Http\Event\RequestEvent;

class AuthListener
{
    /**
     * @var AuthStrategyInterface
     */
    private $auth;

    public function __construct(AuthStrategyInterface $auth)
    {
        $this->auth = $auth;
    }

    public function onRequestBeforeSend(RequestEvent $event)
    {
        if (null === $this->auth) {
            return;
        }

        $this->auth->auth($event);
    }
}

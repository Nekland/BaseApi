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

interface AuthStrategyInterface
{
    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options);

    /**
     * @param RequestEvent $request
     */
    public function auth(RequestEvent $request);
}

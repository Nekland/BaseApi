<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Cache;


use Nekland\BaseApi\Cache\Provider\CacheProviderInterface;
use Nekland\BaseApi\Http\Event\RequestEvent;

interface CacheStrategyInterface
{
    /**
     * @param  RequestEvent $event
     */
    public function execute(RequestEvent $event);

    /**
     * @param CacheProviderInterface $provider
     */
    public function setProvider(CacheProviderInterface $provider);
}

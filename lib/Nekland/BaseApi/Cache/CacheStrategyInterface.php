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


interface CacheStrategyInterface
{
    /**
     * @param  callable $closure
     * @param  array    $parameters
     * @return mixed
     */
    public function prepare($closure, $parameters);
}
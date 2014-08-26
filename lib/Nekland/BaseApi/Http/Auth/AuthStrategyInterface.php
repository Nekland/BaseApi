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


interface AuthStrategyInterface
{
    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options);

    /**
     * @param \Guzzle\Http\Message\Request $request
     */
    public function auth(\Guzzle\Http\Message\Request $request);
}

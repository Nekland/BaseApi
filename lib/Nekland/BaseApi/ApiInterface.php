<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi;


interface ApiInterface
{
    /**
     * Return an api object
     *
     * @param string $name
     * @return mixed
     */
    public function api($name);
} 
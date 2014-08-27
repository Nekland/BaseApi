<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Http\Event;


class Events
{
    const ON_REQUEST_EVENT = 'nekland_api.on_http_request';
    const AFTER_REQUEST_EVENT = 'nekland_api.after_http_request';
}

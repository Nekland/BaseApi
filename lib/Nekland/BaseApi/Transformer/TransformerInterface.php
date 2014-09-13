<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Transformer;

interface TransformerInterface
{
    const UNKNOWN = 'unknown';

    /**
     * Depending on what formatter will be used, the data will be transform.
     *
     * @param  string $data
     * @param  string $type Type of data that is sent
     * @return mixed
     */
    public function transform($data, $type = self::UNKNOWN);
}

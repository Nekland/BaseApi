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


class QuotaLimitException extends \Exception
{
    /**
     * @var integer
     */
    private $quota;

    public function __construct($message = null)
    {
        parent::__construct($message ?: 'Your quota of queries is over.');
    }

    /**
     * @param integer $quota
     */
    public function setQuota($quota)
    {
        $this->quota = $quota;
    }

    /**
     * @return integer int
     */
    public function getQuota()
    {
        return $this->quota;
    }
}

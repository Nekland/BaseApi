<?php

namespace spec\fixture;

use Nekland\BaseApi\Http\Auth\AuthStrategyInterface;
use Nekland\BaseApi\Http\Event\RequestEvent;

class MyAuthStrategy implements AuthStrategyInterface
{
    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options)
    {
        return $this;
    }

    /**
     * @param RequestEvent $request
     */
    public function auth(RequestEvent $request)
    {

    }
}

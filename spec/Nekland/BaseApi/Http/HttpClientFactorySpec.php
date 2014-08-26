<?php

namespace spec\Nekland\BaseApi\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpClientFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Nekland\BaseApi\Http\HttpClientFactory');
    }
}

<?php

namespace spec\Nekland\BaseApi\Http\Auth;

use Nekland\BaseApi\Http\AbstractHttpClient;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

require __DIR__ . '/../../../../fixture/MyAuthStrategy.php';

class AuthFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Nekland\BaseApi\Http\Auth\AuthFactory');
    }

    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_should_return_an_auth_strategy_after_registered_namespace()
    {
        $this->addNamespace('spec\fixture');
        $this->get('MyAuthStrategy')->shouldHaveType('spec\fixture\MyAuthStrategy');
    }

    public function it_should_return_an_auth_strategy_after_added_it_to_classes()
    {
        $this->addAuth('my_auth', 'spec\fixture\MyAuthStrategy');
        $this->get('my_auth')->shouldHaveType('spec\fixture\MyAuthStrategy');
    }
}

<?php

namespace spec\Nekland\BaseApi\Http;

require __DIR__ . '/../../../fixture/MyHttpClient.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpClientFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Nekland\BaseApi\Http\HttpClientFactory');
    }

    public function it_should_return_a_guzzle_http_client_by_default()
    {
        $this->createHttpClient()->shouldHaveType('Nekland\BaseApi\Http\ClientAdapter\GuzzleAdapter');
    }

    public function it_should_be_able_to_create_user_http_client()
    {
        $this->register('MyHttpClient', 'spec\fixture\MyHttpClient');
        $this->createHttpClient('MyHttpClient')->shouldHaveType('spec\fixture\MyHttpClient');
    }

    public function it_should_not_register_class_that_does_not_exists()
    {

        $this
            ->shouldThrow('\InvalidArgumentException')
            ->duringRegister('ClassThatDoesNotExists', 'this\namespace\does\not\Exists')
        ;
    }
}

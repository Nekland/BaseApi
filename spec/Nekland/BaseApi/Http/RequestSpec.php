<?php

namespace spec\Nekland\BaseApi\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    private $path    = 'http://site.com/api/v1/test';
    private $body    = ['param1' => 'hello'];
    private $headers = ['User-Agent' => 'phpspec'];

    public function it_is_initializable()
    {
        $this->shouldHaveType('Nekland\BaseApi\Http\Request');
    }

    public function let()
    {
        $this->beConstructedWith('GET', $this->path, $this->body, $this->headers);
    }

    public function it_should_return_values_setted_in_constructor()
    {
        $this->getHeaders()->shouldReturn($this->headers);
        $this->getBody()->shouldReturn($this->body);
        $this->getPath()->shouldReturn($this->path);
        $this->getMethod()->shouldReturn('get');
    }
}

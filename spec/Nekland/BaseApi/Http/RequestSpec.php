<?php

namespace spec\Nekland\BaseApi\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    private $url        = 'http://site.com/api/v1/test';
    private $body       = ['foo' => 'bar'];
    private $headers    = ['User-Agent' => 'phpspec'];

    public function it_is_initializable()
    {
        $this->shouldHaveType('Nekland\BaseApi\Http\Request');
    }

    public function let()
    {
        $this->beConstructedWith('GET', $this->url, $this->body, $this->headers);
    }

    public function it_should_return_values_setted_in_constructor()
    {
        $this->getHeaders()->shouldReturn($this->headers);
        $this->getParameters()->shouldReturn($this->body);
        $this->getPath()->shouldReturn($this->url);
        $this->getUrl()->shouldReturn($this->url . '?foo=bar');
        $this->getMethod()->shouldReturn('get');
    }

    public function headers_should_be_editable()
    {
        $this->hasHeader('User-Agent')->shouldReturn(true);
        $this->hasHeader('Something-Else')->shouldReturn(false);
        $this->addHeader('Hello', 'Content');
        $this->hasHeader('Hello')->shouldReturn('true');
    }

    public function parameters_should_be_editable()
    {
        $this->hasParameter('foo')->shouldReturn(true);
        $this->hasParameter('key')->shouldReturn(false);
        $this->setParameter('key', 'some_key');
        $this->getParameter('key')->shouldReturn('some_key');
    }
}

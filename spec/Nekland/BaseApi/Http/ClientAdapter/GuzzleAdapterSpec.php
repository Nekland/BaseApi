<?php

namespace spec\Nekland\BaseApi\Http\ClientAdapter;

use GuzzleHttp\Client;
use GuzzleHttp\Message\MessageInterface;
use Nekland\BaseApi\Http\Event\RequestEvent;
use Nekland\BaseApi\Http\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GuzzleAdapterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Nekland\BaseApi\Http\ClientAdapter\GuzzleAdapter');
        $this->shouldHaveType('Nekland\BaseApi\Http\AbstractHttpClient');
    }

    public function let(EventDispatcher $dispatcher, Client $guzzle)
    {
        $this->beConstructedWith($dispatcher, [], $guzzle);
    }

    public function it_should_not_send_real_request_if_the_event_completed_request(
        Request         $request,
        EventDispatcher $dispatcher,
        RequestEvent    $requestEvent,
        Client          $guzzle
    ) {
        $requestEvent->requestCompleted()->willReturn(true);
        $requestEvent->getResponse()->willReturn('the response');
        $request->getMethod()->willReturn('get');
        $guzzle->get()->shouldNotBeCalled();

        $dispatcher
            ->dispatch(Argument::any(), Argument::type('Nekland\BaseApi\Http\Event\RequestEvent'))
            ->willReturn($requestEvent)
        ;

        $this->send($request);
    }

    public function it_should_send_real_request_when_event_request_not_completed(
        Client           $guzzle,
        EventDispatcher  $dispatcher,
        Request          $request,
        RequestEvent     $requestEvent,
        MessageInterface $result
    ) {
        $guzzle->get('api.com', Argument::any())->shouldBeCalled();
        $guzzle->get('api.com', Argument::any())->willReturn($result);

        $requestEvent->requestCompleted()->willReturn(false);
        $dispatcher
            ->dispatch(Argument::any(), Argument::type('Nekland\BaseApi\Http\Event\RequestEvent'))
            ->willReturn($requestEvent)
        ;

        $request->getMethod()->willReturn('get');
        $request->getUrl()->willReturn('api.com');
        $request->getHeaders()->willReturn([]);
        $request->getBody()->willReturn([]);

        $requestEvent->setResponse(Argument::any())->shouldBeCalled();
        $requestEvent->getResponse()->shouldBeCalled();

        $this->send($request);
    }
}

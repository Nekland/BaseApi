<?php

namespace spec\Nekland\BaseApi\Http\ClientAdapter;

use GuzzleHttp\Client;
use Prophecy\Exception\Doubler\ClassNotFoundException;
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
        $result
    ) {
        /**
         * As Guzzle introduces PSR-7 implementation of messages in Guzzle 6.x,
         * and as this adapter should handle Guzzle 4+,
         * the stub is created depending on this implementation of messages.
         * Don't worry, this interface is just useful for tests
         * but it's not directly used in the class.
         * @link https://github.com/guzzle/guzzle/blob/6.0.0/UPGRADING.md#50-to-60
         */
        if (interface_exists('Psr\Http\Message\ResponseInterface')) {
            // For the official PSR-7 implementation of messages (Guzzle 6+)
            $result->beADoubleOf('Psr\Http\Message\ResponseInterface');
        } elseif (interface_exists('GuzzleHttp\Message\MessageInterface')) {
            // For the Guzzle implementation of messages (Guzzle 4<x<6)
            $result->beADoubleOf('GuzzleHttp\Message\MessageInterface');
        } else {
            // Did you really installed Guzzle 4+ ?
            throw new ClassNotFoundException('No MessageInterface found', 'MessageInterface');
        }

        $guzzle->get('api.com', Argument::any())->shouldBeCalled();
        $guzzle->get('api.com', Argument::any())->willReturn($result);
        $result->getHeaders()->willReturn([]);
        $result->getBody()->willReturn('');

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

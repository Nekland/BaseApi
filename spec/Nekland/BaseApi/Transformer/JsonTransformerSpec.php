<?php

namespace spec\Nekland\BaseApi\Transformer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Nekland\BaseApi\Transformer\JsonTransformer');
        $this->shouldHaveType('Nekland\BaseApi\Transformer\TransformerInterface');
    }

    public function it_should_transform_json_string_to_array()
    {
        $a = ['hello' => 'world'];
        $this->transform('{"hello":"world"}')->shouldReturn($a);
    }
}

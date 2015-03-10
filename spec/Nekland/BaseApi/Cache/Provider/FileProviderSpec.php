<?php
/**
 * This file is a part of a nekland library
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace spec\Nekland\BaseApi\Cache\Provider;

use PhpSpec\ObjectBehavior;

class FileProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Nekland\BaseApi\Cache\Provider\FileProvider');
        $this->shouldHaveType('Nekland\BaseApi\Cache\Provider\CacheProviderInterface');
    }

    public function it_should_return_an_array_stored_in_a_file()
    {
        $this->setOptions(['path' => __DIR__ . '/../../../../fixture/cache_file']);
        $this->load();
        $this->get('something')->shouldReturn(['foz', 'baz']);
    }

    public function it_should_save_the_cache()
    {
        $final = sys_get_temp_dir() . '/nekland_test_cache_file';
        $this->setOptions(['path' => __DIR__ . '/../../../../fixture/cache_file']);
        $this->load();
        $this->set('element', ['foo' => 'bar']);
        $this->setOptions(['path' => $final]);
        $this->save();

        if (
            trim(file_get_contents($final)) !==
            trim(file_get_contents(__DIR__ . '/../../../../fixture/cache_file_comp'))
        ) {
            throw new \Exception('The cache file is not as expected');
        }
    }
}

<?php

namespace spec\fixture;

class MyHttpClient extends \Nekland\BaseApi\Http\AbstractHttpClient
{
    /**
     * @param  \Nekland\BaseApi\Http\Request $request
     * @return string
     */
    public function execute(\Nekland\BaseApi\Http\Request $request)
    {
        return '';
    }
}

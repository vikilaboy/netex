<?php

namespace Netex\Api\Controllers;


class IndexController extends ControllerBase
{
    public function indexAction()
    {
        return [
            'error'    => true,
            'code'     => 200,
            'messages' => [
                'Welcome to Netex Tires Shop Webservice.'
            ],
            'results'  => []
        ];
    }
}


<?php

namespace Netex\Backend\Controllers;

class IndexController  extends ControllerBase
{
    public function indexAction()
    {
        $client= new \GearmanClient();
        $client->addServer();
    }
}


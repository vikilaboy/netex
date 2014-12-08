<?php

namespace Netex\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    /**
     * Executes after instance
     */
    public function initialize()
    {
        $this->loadDefaultAssets();
    }

    /**
     * loadDefaultAssets method.
     *
     * @access private
     * @return void
     */
    private function loadDefaultAssets()
    {
        $this->assets
            ->addCss('//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css', false)
            ->addCss('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', false)
            ->addCss('css/style.css');

        $this->assets
            ->addJs('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', false)
            ->addJs('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js', false)
            ->addJs('//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', false)
            ->addJs('js/jquery.lazyload.min.js');
    }

    public function show404Action()
    {
        return $this->view->pick('partials/show404');
    }
}

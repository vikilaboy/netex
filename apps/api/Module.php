<?php

namespace Netex\Api;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Events\Manager as EventsManager;

use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class Module implements ModuleDefinitionInterface
{

    /**
     * Registers the module auto-loader
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces([
            'Netex\Api\Controllers' => __DIR__ . '/controllers/',
            'Netex\Models'               => __DIR__ . '/../../common/models/',
        ]);

        $loader->register();
    }

    public function registerServices($di)
    {
        /**
         * Setting up the view component
         */
        $di->set(
            'view',
            function () {
                $view = new View();
                $view->disableLevel(array(
                    View::LEVEL_ACTION_VIEW => true,
                    View::LEVEL_LAYOUT => true,
                    View::LEVEL_MAIN_LAYOUT => true,
                    View::LEVEL_AFTER_TEMPLATE => true,
                    View::LEVEL_BEFORE_TEMPLATE => true
                ));

                return $view;
            }
        );

        $di->set('dispatcher', function() {

            //Create an EventsManager
            $eventsManager = new EventsManager();

            //Attach a listener
            $eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {

                //Handle 404 exceptions
                if ($exception instanceof DispatchException) {
                    $dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'show404'
                    ));
                    return false;
                }

                //Alternative way, controller or action doesn't exist
                if ($event->getType() == 'beforeException') {
                    switch ($exception->getCode()) {
                        case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward(array(
                                'controller' => 'index',
                                'action' => 'show404'
                            ));
                            return false;
                    }
                }
            });

            $dispatcher = new \Phalcon\Mvc\Dispatcher();

            //Bind the EventsManager to the dispatcher
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;

        }, true);
    }
}

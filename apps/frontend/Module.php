<?php

namespace Netex\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Events\Manager as EventsManager;


class Module implements ModuleDefinitionInterface
{

    /**
     * Registers the module auto-loader
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces([
            'Netex\Frontend\Controllers' => __DIR__ . '/controllers/',
            'Netex\Models'               => __DIR__ . '/../../common/models/',
        ]);

        $loader->register();
    }

    /**
     * Registers the module-only services
     *
     * @param Phalcon\DI $di
     */
    public function registerServices($di)
    {
        /**
         * Read configuration
         */
        $config = include __DIR__ . "/config/config.php";

        /**
         * Setting up the view component
         */
        $di->set(
            'view',
            function () use ($config) {
                $view = new View();
                $view->setViewsDir($config->application->view->viewsDir);
                $view->disableLevel([View::LEVEL_MAIN_LAYOUT => true, View::LEVEL_LAYOUT => true]);
                $view->registerEngines(
                    [
                        '.volt' => function () use ($view, $config) {
                            $volt = new Volt($view);
                            $volt->setOptions(
                                [
                                    'compiledPath'      => $config->application->view->compiledPath,
                                    'compiledSeparator' => $config->application->view->compiledSeparator,
                                    'compiledExtension' => $config->application->view->compiledExtension,
                                    'compileAlways'     => true,
                                ]
                            );
                            return $volt;
                        }
                    ]
                );

                // Create an event manager
                $eventsManager = new EventsManager();

                // Attach a listener for type 'view'
                $eventsManager->attach(
                    'view',
                    function ($event, $view) {
                        if ($event->getType() == 'notFoundView') {
                            throw new \Exception('View not found!!! (' . $view->getActiveRenderPath() . ')');
                        }
                    }
                );

                // Bind the eventsManager to the view component
                $view->setEventsManager($eventsManager);

                return $view;
            }
        );

    }

}

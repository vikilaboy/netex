<?php

use Phalcon\Mvc\Router;

$router = new Router();

//Remove trailing slashes automatically
$router->removeExtraSlashes(true);

$router->setDefaultModule("frontend");
$router->setDefaultNamespace("Netex\Frontend\Controllers");
//$router->setDefaultController('index');
//$router->setDefaultAction('index');

require 'routes/frontend.php';
require 'routes/backend.php';
require 'routes/api.php';

return $router;
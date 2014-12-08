<?php

//Backend routes
$router->add('/admin', array(
    'module' => 'backend',
    'namespace' => 'Netex\Backend\Controllers\\',
    'controller' => 'index',
    'action' => 'index'
));

$router->add('/admin/product', array(
    'module' => 'backend',
    'namespace' => 'Netex\Backend\Controllers\\',
    'controller' => 'product',
    'action' => 'index'
));

$router->add('/admin/product/:action', array(
    'module' => 'backend',
    'namespace' => 'Netex\Backend\Controllers\\',
    'controller' => 'product',
    'action' => 1
));


$router->add('/admin/product/:action/:int', array(
    'module' => 'backend',
    'namespace' => 'Netex\Backend\Controllers\\',
    'controller' => 'product',
    'action' => 1,
    'id' => 2
));

$router->add('/admin/product/:action/:int/:params', array(
    'module' => 'backend',
    'namespace' => 'Netex\Backend\Controllers\\',
    'controller' => 'product',
    'action' => 1,
    'id' => 2,
    'id2' => 3
));

$router->add('/admin/product/:action/:params', array(
    'module' => 'backend',
    'namespace' => 'Netex\Backend\Controllers\\',
    'controller' => 'product',
    'action' => 1,
    'params' => 2
));
<?php

$router->add('/{name}/:int', array(
    'module' => 'frontend',
    'namespace' => 'Netex\Frontend\Controllers\\',
    'controller' => 'Product',
    'action' => 'item',
    'id' => 2
));

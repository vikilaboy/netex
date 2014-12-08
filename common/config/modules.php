<?php

return array(
    'frontend' => array(
        'className' => 'Netex\Frontend\Module',
        'path' => __DIR__ . '/../../apps/frontend/Module.php'
    ),
    'backend' => array(
        'className' => 'Netex\Backend\Module',
        'path' => __DIR__ . '/../../apps/backend/Module.php'
    ),
    'api' => array(
        'className' => 'Netex\Api\Module',
        'path' => __DIR__ . '/../../apps/api/Module.php'
    )
);

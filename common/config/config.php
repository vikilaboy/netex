<?php

return new \Phalcon\Config([
    'database'    => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'netex',
        'dbname'   => 'netex',
        'password' => '849ro4iru34uf',
        'name'     => 'netex',
        'schema'   => 'netex',
        'charset'  => 'UTF8'
    ],
    'application' => [
        'modelsDir'    => __DIR__ . '/../../common/models/',
        'cacheDir'     => __DIR__ . '/../../frontend/cache/',
        'baseUri'      => '/',
        'baseAdminUri' => '/admin/',
        'cryptSalt'    => 'eEweteR|_&G&f,+tU]:jDe!!A&+w1Ms9~8_4I!<@[N@DdaIP_2M|:+.u>/6m,$D',
        'view'         => [
            'compiledPath'      => __DIR__ . '/../../cache/volt/',
            'compiledSeparator' => '_',
            'compiledExtension' => '.php',
            'paginator'         => [
                'limit' => 10,
            ],
        ],
    ],
    'models'      => [
        'metadata' => [
            'adapter' => 'Memory'
        ]
    ]
]);

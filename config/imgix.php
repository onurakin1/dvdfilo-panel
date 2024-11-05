<?php

return [
    'default' => 'default',

    'sources' => [
        'default' => [
            'domain' => env('IMGIX_DOMAIN','example.imgix.net'), // domain only - without http(s)
            // 'useHttps' => true, // default is true - you shouldn't change this
            // 'signKey' => null, // your signing key for this domain
            // 'includeLibraryParam' => true, // if you want to remove the `ixlib` param
        ],
        'astrotomic' => [
            'domain' => env('IMGIX_DOMAIN','example.imgix.net'),
            'useHttps' => env('IMGIX_HTTPS',false),
            'signKey' => env('IMGIX_KEY',''),
            'includeLibraryParam' => false,
        ],
    ],
];

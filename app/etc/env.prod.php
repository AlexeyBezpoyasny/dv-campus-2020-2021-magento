<?php
return [
    'backend' => [
        'frontName' => 'admin'
    ],
    'queue' => [
        'consumers_wait_for_messages' => 1
    ],
    'crypt' => [
        'key' => 'bc31e8c7295d9c28d1a1d06f9023eca5'
    ],
    'db' => [
        'table_prefix' => 'm2_',
        'connection' => [
            'default' => [
                'host' => 'mysql',
                'dbname' => 'oleksii_bezpoiasnyi_local',
                'username' => 'oleksii_bezpoiasnyi_local',
                'password' => 'oleksii_bezpoiasnyi_local',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1',
                'driver_options' => [
                    1014 => false
                ]
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'developer',
    'session' => [
        'save' => 'files'
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '69d_'
            ],
            'page_cache' => [
                'id_prefix' => '69d_'
            ]
        ],
        'allow_parallel_generation' => false
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => null
        ]
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'vertex' => 1
    ],
    'downloadable_domains' => [
        'oleksii-bezpoiasnyi.local'
    ],
    'install' => [
        'date' => 'Tue, 06 Oct 2020 20:55:55 +0000'
    ],
    'system' => [
        'default' => [
            'web' => [
                'unsecure' => [
                    'base_url' => 'https://oleksii-bezpoiasnyi.local/',
                    'base_link_url' => '{{unsecure_base_url}}',
                    'base_static_url' => 'https://oleksii-bezpoiasnyi.local/static/',
                    'base_media_url' => 'https://oleksii-bezpoiasnyi.local/media/'
                ],
                'secure' => [
                    'base_url' => 'https://oleksii-bezpoiasnyi.local/',
                    'base_link_url' => '{{secure_base_url}}',
                    'base_static_url' => 'https://oleksii-bezpoiasnyi.local/static/',
                    'base_media_url' => 'https://oleksii-bezpoiasnyi.local/media/'
                ],
            ],
        ],
        'websites' => [
            'second_website' => [
                'web' => [
                    'unsecure' => [
                        'base_url' => 'https://oleksii-bezpoiasnyi-second.local/',
                        'base_link_url' => 'https://oleksii-bezpoiasnyi-second.local/',
                        'base_static_url' => 'https://oleksii-bezpoiasnyi-second.local/static/',
                        'base_media_url' => 'https://oleksii-bezpoiasnyi-second.local/media/'
                    ],
                    'secure' => [
                        'base_url' => 'https://oleksii-bezpoiasnyi-second.local/',
                        'base_link_url' => 'https://oleksii-bezpoiasnyi-second.local/',
                        'base_static_url' => 'https://oleksii-bezpoiasnyi-second.local/static/',
                        'base_media_url' => 'https://oleksii-bezpoiasnyi-second.local/media/'
                    ]
                ]
            ]
        ]
    ]
];
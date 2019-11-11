<?php

use Codemen\Installer\Controllers\EnvironmentSetupController;
use Codemen\Installer\Controllers\FinalController;
use Codemen\Installer\Controllers\MigrationsController;
use Codemen\Installer\Controllers\PermissionsController;
use Codemen\Installer\Controllers\RequirementsController;
use Codemen\Installer\Controllers\SeedingController;
use Codemen\Installer\Validators\DatabaseValidator;

return [

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'core' => [
        'minPhpVersion' => '7.0.0',
    ],
    'final' => [
        'key' => true,
        'publish' => false,
    ],
    'requirements' => [
        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'storage/' => '775',
        'bootstrap/cache/' => '775',
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Form Wizard Validation Rules & Messages
    |--------------------------------------------------------------------------
    |
    | This are the default form field validation rules. Available Rules:
    | https://laravel.com/docs/6.x/validation#available-validation-rules
    |
    */
    'routes' => [
        'server-requirements' => [
            'icon' => 'fa fa-server',
            'controller' => RequirementsController::class,
            'next_route' => [
                'name' => 'installer.types',
                'parameters' => 'directory-permissions'
            ]
        ],
        'directory-permissions' => [
            'icon' => 'fa fa-folder',
            'controller' => PermissionsController::class,
            'next_route' => [
                'name' => 'installer.types',
                'parameters' => 'configure-environments'
            ]
        ],
        'configure-environments' => [
            'icon' => 'fa fa-cog',
            'controller' => EnvironmentSetupController::class,
            'fields' => [
                'app_name' => [
                    'field_type' => 'text',
                    'field_label' => 'App Name',
                    'validation' => 'required|string|max:50',
                ],
                'app_env' => [
                    'field_type' => 'select',
                    'field_value' => [
                        'local' => "Local",
                        'staging' => 'Staging',
                        'production' => 'Production',
                    ],
                    'field_label' => 'App Environment',
                    'validation' => 'required|in:local,staging,production'
                ],
                'app_debug' => [
                    'field_type' => 'switch',
                    'field_value' => [
                        'true' => "Enable",
                        'false' => 'Disable',
                    ],
                    'field_label' => 'Debugging',
                    'validation' => 'required|in:true,false'
                ],
                'app_url' => [
                    'field_type' => 'text',
                    'field_label' => 'App URL',
                    'validation' => 'required|string|max:50'
                ],
                'log_channel' => [
                    'field_type' => 'select',
                    'field_value' => [
                        'single' => "Single",
                        'daily' => 'Daily',
                        'slack' => 'Slack',
                        'syslog' => 'Syslog',
                        'errorlog' => 'Error Log',
                        'monolog' => 'Monolog',
                        'stack' => 'Stack',
                    ],
                    'field_label' => 'Log Channel',
                    'validation' => 'required|in:single,daily,slack,syslog,errorlog,monolog,stack'
                ],
            ],
            'next_route' => [
                'name' => 'installer.types',
                'parameters' => 'database'
            ]
        ],
        'database' => [
            'icon' => 'fa fa-database',
            'controller' => EnvironmentSetupController::class,
            'fields' => [
                'db_connection' => [
                    'field_type' => 'text',
                    'field_label' => 'Connection',
                    'validation' => 'required|string|max:50'
                ],
                'db_host' => [
                    'field_type' => 'text',
                    'field_label' => 'Host',
                    'validation' => 'required|string|max:50'
                ],
                'db_port' => [
                    'field_type' => 'text',
                    'field_label' => 'Port',
                    'validation' => 'required|string|max:50'
                ],
                'db_database' => [
                    'field_type' => 'text',
                    'field_label' => 'Name',
                    'validation' => 'required|string|max:50'
                ],
                'db_username' => [
                    'field_type' => 'text',
                    'field_label' => 'Username',
                    'validation' => 'required|string|max:50'
                ],
                'db_password' => [
                    'field_type' => 'text',
                    'field_label' => 'Password',
                    'validation' => 'required|string|max:50'
                ]
            ],
            'validator' => DatabaseValidator::class,
            'next_route' => [
                'name' => 'installer.types',
                'parameters' => 'mail'
            ]
        ],
        'mail' => [
            'icon' => 'fa fa-envelope',
            'controller' => EnvironmentSetupController::class,
            'fields' => [
                'mail_driver' => [
                    'field_type' => 'text',
                    'field_label' => 'Driver',
                    'validation' => 'required|string|max:50'
                ],
                'mail_host' => [
                    'field_type' => 'text',
                    'field_label' => 'Host',
                    'validation' => 'required|string|max:50'
                ],
                'mail_port' => [
                    'field_type' => 'text',
                    'field_label' => 'Port',
                    'validation' => 'required|string|max:50'
                ],
                'mail_username' => [
                    'field_type' => 'text',
                    'field_label' => 'Username',
                    'validation' => 'required|string|max:50'
                ],
                'mail_password' => [
                    'field_type' => 'text',
                    'field_label' => 'Password',
                    'validation' => 'required|string|max:50'
                ],
                'mail_encryption' => [
                    'field_type' => 'select',
                    'field_value' => [
                        'tls' => 'TLS',
                        'ssl' => 'SSL',
                        'starttls' => 'STARTTLS',
                    ],
                    'field_label' => 'Encryption',
                    'validation' => 'required|string|max:50'
                ],
                'mail_from_address' => [
                    'field_type' => 'text',
                    'field_label' => 'From Address',
                    'validation' => 'present|string|max:50'
                ],
                'mail_from_name' => [
                    'field_type' => 'text',
                    'field_label' => 'From Name',
                    'validation' => 'present|string|max:50'
                ]
            ],
            'validator' => null,
            'next_route' => [
                'name' => 'installer.types',
                'parameters' => 'others'
            ]
        ],
        'others' => [
            'icon' => 'fa fa-cubes',
            'controller' => EnvironmentSetupController::class,
            'fields' => [
                'broadcast_driver' => [
                    'field_type' => 'select',
                    'field_value' => [
                        'log' => 'Log',
                        'pusher' => 'pusher',
                        'redis' => 'redis',
                        'null' => 'Null'
                    ],
                    'field_label' => 'Broadcast Driver',
                    'validation' => 'required|string|max:50'
                ],
                'cache_driver' => [
                    'field_type' => 'select',
                    'field_value' => [
                        "apc" => "APC",
                        "array" => "Array",
                        "database" => "Database",
                        "file" => "File",
                        "memcached" => "Memcached",
                        "redis" => "Redis",
                    ],
                    'field_label' => 'Cache Driver',
                    'validation' => 'required|string|max:50'
                ],
                'queue_connection' => [
                    'field_type' => 'select',
                    'field_value' => [
                        "sync" => "Sync",
                        'log' => 'log',
                        'pusher' => 'pusher',
                        'redis' => 'redis',
                        "database" => "Database",
                        'null' => 'Null',
                    ],
                    'field_label' => 'Queue Driver',
                    'validation' => 'required|string|max:50'
                ],
                'session_driver' => [
                    'field_type' => 'select',
                    'field_value' => [
                        "file" => "File",
                        "cookie" => "Cookie",
                        "database" => "Database",
                        "apc" => "APC",
                        "memcached" => "Memcached",
                        "redis" => "Redis",
                    ],
                    'field_label' => 'Session Driver',
                    'validation' => 'required|string|max:50'
                ],
                'session_lifetime' => [
                    'field_type' => 'text',
                    'field_label' => 'Session Lifetime',
                    'validation' => 'required|integer'
                ],

                'redis_host' => [
                    'field_type' => 'text',
                    'field_label' => 'Redis Host',
                    'validation' => 'required|string|max:50'
                ],
                'redis_port' => [
                    'field_type' => 'text',
                    'field_label' => 'Redis Port',
                    'validation' => 'required|string|max:50'
                ],
                'redis_password' => [
                    'field_type' => 'text',
                    'field_label' => 'Redis Password',
                    'validation' => 'nullable|string|max:50'
                ]
            ],
            'validator' => null,
            'next_route' => [
                'name' => 'installer.types',
                'parameters' => 'migrations'
            ]
        ],
        'migrations' => [
            'icon' => 'fa fa-database',
            'controller' => MigrationsController::class,
            'next_route' => [
                'name' => 'installer.types',
                'parameters' => 'seeding'
            ]
        ],
        'seeding' => [
            'icon' => 'fa fa-database',
            'controller' => SeedingController::class,
            'next_route' => [
                'name' => 'installer.types',
                'parameters' => 'final'
            ]
        ],
        'final' => [
            'icon' => 'fa fa-stop-circle-o',
            'controller' => FinalController::class,
            'next_route' => 'home'
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Installed Middleware Options
    |--------------------------------------------------------------------------
    | Different available status switch configuration for the
    | canInstall middleware located in `CanInstall.php`.
    |
    */
    'installed' => [
        'redirectOptions' => [
            'route' => [
                'name' => 'welcome',
                'parameters' => [],
            ],
            'abort' => [
                'type' => '404',
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Selected Installed Middleware Option
    |--------------------------------------------------------------------------
    | The selected option fo what happens when an installer instance has been
    | Default output is to `/resources/views/error/404.blade.php` if none.
    | The available middleware options include:
    | route, abort, dump, 404, default, ''
    |
    */
    'installedAlreadyAction' => 'abort',

];

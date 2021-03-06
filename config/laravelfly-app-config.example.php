<?php


return [
    'config_need_backup' => [
        /** depends
         *
         * 'debugbar.enabled',
         */
    ],

    /** Providers to reg and boot after each request
     * Providers not found in config('app.providers') would be ignored
     */
    'providers_in_request' => [
        /*todo need test */
        Illuminate\Pagination\PaginationServiceProvider::class,
    ],

    /* Which properties of base services need to backup and restore.
     * See: Illuminate\Foundation\Application::registerBaseServiceProviders
     */
    'BaseServices' => [

        /* Illuminate\Events\EventServiceProvider::class : */
        'events' => [
            'listeners', 'wildcards', 'queueResolver',
        ],

        /* Illuminate\Routing\RoutingServiceProvider::class : */
        'router' => [
            /** not necessary to backup,
             *
             * it will be changed during next request
             * // 'current',
             *
             * the ref to app('request') will be released during next request
             * //'currentRequest',
             */

            /** depends
             * Uncomment them if it's not same on each requests. They may be changed by Route::middleware
             */
            // 'middleware','middlewareGroups','middlewarePriority',

            'obj.routes' => [
                /** depends
                 *
                 * Uncomment them if some of your routes are created during any request.
                 * Besides, because values of these four properties are associate arrays,
                 * if names of routes created during request are sometime different , please uncomment them ,
                 */
                // 'routes' , 'allRoutes' , 'nameList' , 'actionList' ,
            ],
        ], /* end 'router' */

        'url' => [
            /** not necessary to backup,
             *
             * the ref to app('request') will be released during next request;
             * and no need set request for `url' on every request , because there is a $app->rebinding for request:
             *      $app->rebinding( 'request', $this->requestRebinder() )
             * //'request'
             */

            /* depends */
            // 'forcedRoot', 'forceSchema',
            // 'cachedRoot', 'cachedSchema',
        ],


        /** nothing need to backup
         *
         * // 'redirect' => false,
         * // 'routes' => false,
         * // 'log' => false,
         */
    ],

    /** providers to boot in worker, before any request
     *
     * only for Greedy mode
     *
     * format:
     *      proverder_name => [],
     * providers not found in config('app.providers') would be ignored
     *
     * you can also supply singleton services to made on worker and which properties need to backup  and restore.
     * only singleton services are useful and valid here.
     * a singeton service is like this:
     *     *   $this->app->singleton('cache', function ($app) { ... });
     * four format:
     * 1. 'singleton_service_name' => false/null   service will not be made before request
     * 2. 'singleton_service_name' => []   service is made before request, no property need to backup
     * 3. 'singleton_service_name' => ['property1','property2'] service is made before request , two properties to backup
     * 4. 'singleton_service_name' => [
     *                      'obj.file'=>['p1','p2']
     *              ]
     *              service is made before request ,and
     *              it has an attribute `file` which is an obj whoes attributes p1,p2 need to backup
     */
    'providers_in_worker' => [
        Illuminate\Auth\AuthServiceProvider::class => [
            //todo

            'Illuminate\Contracts\Auth\Access\Gate' => [
                /* depends */
                //'policies','abilities',
            ],

        ],
        //todo need test
        Illuminate\Broadcasting\BroadcastServiceProvider::class => [],
        Illuminate\Bus\BusServiceProvider::class => [
            /* todo need test */
            // 'Illuminate\Bus\Dispatcher' => [], // uses Illuminate\Contracts\Queue\Queue
        ],
        Illuminate\Cache\CacheServiceProvider::class => [
            'cache' => [],
            'cache.store' => [],
            /* depends */
            // 'memcached.connector' => [],

        ],
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class => [
            /** depends
             * It's rare that there console services  are used for your user. */
            // 'command.auth.resets.clear' => [],'migrator' => [],...
        ],
        Illuminate\Cookie\CookieServiceProvider::class => [
            'cookie' => [
                /** depends
                 * uncomment them if they are changed during request
                 */
                // 'path', 'domain',

                //todo necessary?
                'queued',
            ],
        ],
        Illuminate\Database\DatabaseServiceProvider::class => [],
        Illuminate\Encryption\EncryptionServiceProvider::class => [
            'encrypter' => [],
        ],
        Illuminate\Filesystem\FilesystemServiceProvider::class => [
            /** depends
             * if you use filesystem.disk or filesystem.cloud, uncomment
             */
            //'filesystem.disk' => [],
            //'filesystem.cloud' => [],
        ],
        /* This reg FormRequestServiceProvider, whose boot is related to request */
        // Illuminate\Foundation\Providers\FoundationServiceProvider::class=>[] : providers_across ,
        Illuminate\Hashing\HashServiceProvider::class => [
            'hash' => [
                /** depends
                 */
                //'rounds',
            ],
        ],
        Illuminate\Mail\MailServiceProvider::class => [
            /* depends */
            /* comment 'mailer' if your app do not use mail */
            'mailer' => [
                'failedRecipients',

                /** depends
                 */
                //'from' ,
                //'to' ,
                //'pretending' ,

            ],
        ],
        // Illuminate\Pagination\PaginationServiceProvider::class=>[] : providers_in_request,
        Illuminate\Pipeline\PipelineServiceProvider::class => [
            'Illuminate\\Contracts\\Pipeline\\Hub' => [],
        ],
        Illuminate\Queue\QueueServiceProvider::class => [
            /** depends
             */
            //'queue' => [],
            //'queue.connection' => [],
        ],
        Illuminate\Redis\RedisServiceProvider::class => [
            /** depends
             * comment it if redis is not used
             */
            'redis' => [],
        ],
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class => [],
        Illuminate\Session\SessionServiceProvider::class => [
            'session' => [],
            'session.store' => [
                'id', 'name', 'attributes',
            ],
            'Illuminate\Session\Middleware\StartSession' => [
                'sessionHandled',
            ],
        ],
        Illuminate\Translation\TranslationServiceProvider::class => [
            'translator' => [],
        ],
        Illuminate\Validation\ValidationServiceProvider::class => [
            /* todo
              todo it's related to db, when db reconnet, how it ? */
            /* Illuminate\Validation\ValidationServiceProvider::class :*/
            // 'validator' => [],
            // 'validation.presence' => [],
        ],
        Illuminate\View\ViewServiceProvider::class => [
            /** depends
             * comment it if you do not use blade
             */
            'blade.compiler' => [],

            'view' => [
                /** depends
                 * uncomment them if you use same alias for dif views during many requests
                 */
                // 'aliases', 'names',

                /** depends
                 * uncomment it if you use dif extensions from  ['blade.php' => 'blade', 'php' => 'php']
                 */
                // 'extensions',

                'shared',
                'composers',
                'sections', 'sectionStack', 'renderCount',
                'obj.finder' => [

                    /* depends
                     * If 'ViewFinderInterface::addLocation' is executed during a request, uncomment ti
                     * otherwise this attribute's value will increase infinitely until a swoole worker reach max_request
                    */
                    //'paths',

                    /* depends */
                    /* no need to make backup for 'view' WHEN views keep same on every request.
                     * But when different locations added during request, same view names may point to different view files.
                     * for example:
                     * view 'home' may points to 'location-1/home.blade.php' or to 'location-2/home.blade.php'
                    */
                    //'views',

                    /* depends */
                    //'hints',

                    /* depends */
                    //'extensions',

                ], /* end finder */
            ], /* end view */

        ],
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class => [],
        App\Providers\AuthServiceProvider::class => [],
        App\Providers\EventServiceProvider::class => [],
        App\Providers\RouteServiceProvider::class => [],

    ],

    /** load views as early as possible
     *
     * Before any request , these view files will be found.
     * They must keep same on every quest.
     * If one of these view names is not found,
     * it and its subsequent names would be ignored and print to console or log file. .
     *
     * Only for Greedy mode
     */
    'views_to_find_in_worker' => [
        // 'home','posts.create','layout.master',
    ]

];

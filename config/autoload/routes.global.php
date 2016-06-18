<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
            App\Action\PingAction::class => App\Action\PingAction::class,
            App\Middleware\Format\Json::class => App\Middleware\Format\Json::class,
        ],
        'factories' => [
            App\Action\HomePageAction::class => App\Action\HomePageFactory::class,
            App\Action\Beer\Index::class => App\Factory\Beer\Index::class,
            App\Action\Beer\Update::class => App\Factory\Beer\Update::class,
            App\Action\Beer\Create::class => App\Factory\Beer\Create::class,
            App\Action\Beer\Delete::class => App\Factory\Beer\Delete::class,
            App\Middleware\Format\Html::class => App\Factory\Middleware\Format\Html::class
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => App\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'api.ping',
            'path' => '/api/ping',
            'middleware' => App\Action\PingAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'beer.index',
            'path' => '/beer',
            'middleware' => [
                App\Action\Beer\Index::class,
                App\Middleware\Format\Json::class,
                App\Middleware\Format\Html::class
            ],
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'beer.create',
            'path' => '/beer',
            'middleware' => [
                App\Action\Beer\Create::class,
                App\Middleware\Format\Json::class,
            ],
            'allowed_methods' => ['POST'],
        ],
        [
            'name' => 'beer.update',
            'path' => '/beer/{id}',
            'middleware' => [
                App\Action\Beer\Update::class,
                App\Middleware\Format\Json::class,
            ],
            'allowed_methods' => ['PUT'],
        ],
        [
            'name' => 'beer.delete',
            'path' => '/beer/{id}',
            'middleware' => [
                App\Action\Beer\Delete::class,
                App\Middleware\Format\Json::class,
            ],
            'allowed_methods' => ['DELETE'],
        ],

    ],
];

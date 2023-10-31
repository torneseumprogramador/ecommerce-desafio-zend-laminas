<?php

declare(strict_types=1);

namespace Api;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/api',
                    'defaults' => [
                        'controller' => Controller\HomeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'clientes' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/api/clientes',
                    'defaults' => [
                        'controller' => Controller\ClientesController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true, // permitir que esta rota seja terminável
                'child_routes'  => [ // rotas filhas
                    'criar' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/criar',
                            'defaults' => [
                                'action' => 'criar',
                            ],
                        ],
                    ],
                    'alterar' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:id]',
                            'constraints' => [
                                'id' => '[0-9]+', // restringir o ID para conter apenas números
                            ],
                            'defaults' => [
                                'action' => 'alterar',
                            ],
                        ],
                    ],
                    'excluir' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:id]/excluir',
                            'constraints' => [
                                'id' => '[0-9]+', // restringir o ID para conter apenas números
                            ],
                            'defaults' => [
                                'action' => 'excluir',
                            ],
                        ],
                    ],
                ],
            ],
            'api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api[/:action]',
                    'defaults' => [
                        'controller' => Controller\HomeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\HomeController::class => InvokableFactory::class,
            Controller\ClientesController::class => Controller\Factory\GenericControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy', // Adicione isso ao seu view_manager
        ],
    ],
];

<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'clientes' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/clientes',
                    'defaults' => [
                        'controller' => Controller\ClientesController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true, // permitir que esta rota seja terminável
                'child_routes'  => [ // rotas filhas
                    'novo' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/novo',
                            'defaults' => [
                                'action' => 'novo',
                            ],
                        ],
                    ],
                    'criar' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/criar',
                            'defaults' => [
                                'action' => 'criar',
                            ],
                        ],
                    ],
                    'editar' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:id]/editar',
                            'constraints' => [
                                'id' => '[0-9]+', // restringir o ID para conter apenas números
                            ],
                            'defaults' => [
                                'action' => 'editar',
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
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ClientesController::class => Controller\Factory\GenericControllerFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            \Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
        ],
        'aliases' => [
            'flashMessenger' => \Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            'application' => __DIR__ . '/../view',
        ],
        'template_map' => [
            'pagination-control' => __DIR__ . '/../view/layout/paginator.phtml',
        ],
    ],
];

<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'user_list' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/users',
                    'defaults' => [
                        'controller'    => \Application\Controller\UserViewController::class,
                        'action'        => 'list',
                    ],
                ],
            ],
            'user_register' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/users/register',
                    'defaults' => [
                        'controller'    => \Application\Controller\UserRegistrationController::class,
                        'action'        => 'register',
                    ],
                ],
            ],
            'user_show' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/users/show/:user_id',
                    'defaults' => [
                        'controller'    => \Application\Controller\UserViewController::class,
                        'action'        => 'show',
                    ],
                    'constraints' => [
                        'user_id' => '[A-Za-z0-9-]{36,36}'
                    ]
                ],
            ],
            'user_todo_post' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/todos/post/:user_id',
                    'defaults' => [
                        'controller'    => \Application\Controller\TodoController::class,
                        'action'        => 'post',
                    ],
                    'constraints' => [
                        'user_id' => '[A-Za-z0-9-]{36,36}'
                    ]
                ],
            ],
        ],
    ],
    'prooph' => [
        'service_bus' => [
            'command_bus' => [
                'router' => [
                    'routes' => [
                        \Application\Model\Command\RegisterUser::class => \Application\Model\User\RegisterUserHandler::class,
                        \Application\Model\Command\PostTodo::class => \Application\Model\Todo\PostTodoHandler::class,
                    ]
                ]
            ],
            'event_bus' => [
                'router' => [
                    'routes' => [
                        \Application\Model\User\UserWasRegistered::class => [
                            \Application\Projection\User\UserProjector::class,
                        ],
                        \Application\Model\Todo\TodoWasPosted::class => [
                            \Application\Projection\Todo\TodoProjector::class,
                            \Application\Projection\User\UserProjector::class,
                        ]
                    ]
                ]
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            \Application\Model\User\RegisterUserHandler::class => \Application\Infrastructure\HandlerFactory\RegisterUserHandlerFactory::class,
            \Application\Model\Todo\PostTodoHandler::class => \Application\Infrastructure\HandlerFactory\PostTodoHandlerFactory::class,
            \Application\Projection\User\UserProjector::class => \Application\Projection\User\UserProjectorFactory::class,
            \Application\Projection\User\UserFinder::class => \Application\Projection\User\UserFinderFactory::class,
            \Application\Projection\Todo\TodoProjector::class => \Application\Projection\Todo\TodoProjectorFactory::class,
            \Application\Projection\Todo\TodoFinder::class => \Application\Projection\Todo\TodoFinderFactory::class,
            \Application\Model\Todo\TodoList::class => \Application\Infrastructure\Repository\Factory\EventStoreTodoListFactory::class,
            \Application\Model\User\UserCollection::class => \Application\Infrastructure\Repository\Factory\EventStoreUserCollectionFactory::class,
        ],
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ],
        'factories' => [
            \Application\Controller\UserViewController::class => \Application\Controller\Factory\UserViewControllerFactory::class,
            \Application\Controller\UserRegistrationController::class => \Application\Controller\Factory\UserRegistrationControllerFactory::class,
            \Application\Controller\TodoController::class => \Application\Controller\Factory\TodoControllerFactory::class,
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],
];

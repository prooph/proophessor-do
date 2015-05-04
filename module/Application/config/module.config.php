<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
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
        ),
    ),
    'proophessor' => [
        'event_store' => [
            'repository_map' => [
                'application.model.todo_list' => [
                    'repository_class' => \Application\Infrastructure\Repository\EventStoreTodoList::class,
                    'aggregate_type' => \Application\Model\Todo\Todo::class,
                ],
                'application.model.user_collection' => [
                    'repository_class' => \Application\Infrastructure\Repository\EventStoreUserCollection::class,
                    'aggregate_type' => \Application\Model\User\User::class,
                ]
            ]
        ],
        'command_router_map' => [
            \Application\Model\Command\RegisterUser::class => \Application\Model\User\RegisterUserHandler::class,
            \Application\Model\Command\PostTodo::class => \Application\Model\Todo\PostTodoHandler::class,
        ],
        'event_router_map' => [
            \Application\Model\User\UserWasRegistered::class => [
                \Application\Projection\User\UserProjector::class,
            ],
            \Application\Model\Todo\TodoWasPosted::class => [
                \Application\Projection\Todo\TodoProjector::class,
                \Application\Projection\User\UserProjector::class
            ]
        ]
    ],
    'service_manager' => array(
        'factories' => [
            \Application\Model\User\RegisterUserHandler::class => \Application\Infrastructure\HandlerFactory\RegisterUserHandlerFactory::class,
            \Application\Model\Todo\PostTodoHandler::class => \Application\Infrastructure\HandlerFactory\PostTodoHandlerFactory::class,
            \Application\Projection\User\UserProjector::class => \Application\Projection\User\UserProjectorFactory::class,
            \Application\Projection\User\UserFinder::class => \Application\Projection\User\UserFinderFactory::class,
            \Application\Projection\Todo\TodoProjector::class => \Application\Projection\Todo\TodoProjectorFactory::class,
            \Application\Projection\Todo\TodoFinder::class => \Application\Projection\Todo\TodoFinderFactory::class,
        ],
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
        'factories' => [
            \Application\Controller\UserViewController::class => \Application\Controller\Factory\UserViewControllerFactory::class,
            \Application\Controller\UserRegistrationController::class => \Application\Controller\Factory\UserRegistrationControllerFactory::class,
            \Application\Controller\TodoController::class => \Application\Controller\Factory\TodoControllerFactory::class,
            \Application\Controller\TodoViewController::class => \Application\Controller\Factory\TodoViewControllerFactory::class,
        ]
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);

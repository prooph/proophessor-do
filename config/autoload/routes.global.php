<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 11:40 AM
 */
return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class
        ],
        'factories' => [
            \Prooph\ProophessorDo\Middleware\JsonPayload::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ]
    ],
    'routes' => [
        [
            'name' => 'page::home',
            'path' => '/',
            'middleware' => \Prooph\ProophessorDo\App\Action\Home::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'page::user-list',
            'path' => '/user-list',
            'middleware' => \Prooph\ProophessorDo\App\Action\UserList::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'page::user-registration-form',
            'path' => '/user-registration',
            'middleware' => \Prooph\ProophessorDo\App\Action\UserRegistration::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'page::user-todo-list',
            'path' => '/user-todo-list/{user_id}',
            'middleware' => \Prooph\ProophessorDo\App\Action\UserTodoList::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'tokens' => [
                    'user_id' => '[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}'
                ],
            ],
        ],
        [
            'name' => 'page::user-todo-form',
            'path' => '/user-todo-list/{user_id}/new-todo',
            'middleware' => \Prooph\ProophessorDo\App\Action\UserTodoForm::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'tokens' => [
                    'user_id' => '[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}'
                ],
            ],
        ],
        //Commanding API
        [
            'name' => 'command::register-user',
            'path' => '/api/commands/register-user',
            'middleware' => [
                \Prooph\ProophessorDo\Middleware\JsonPayload::class,
                \Prooph\Psr7Middleware\CommandMiddleware::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    \Prooph\Psr7Middleware\CommandMiddleware::NAME_ATTRIBUTE => \Prooph\ProophessorDo\Model\User\Command\RegisterUser::class,
                ],
            ],
        ],
        [
            'name' => 'command::post-todo',
            'path' => '/api/commands/post-todo',
            'middleware' => [
                \Prooph\ProophessorDo\Middleware\JsonPayload::class,
                \Prooph\Psr7Middleware\CommandMiddleware::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    \Prooph\Psr7Middleware\CommandMiddleware::NAME_ATTRIBUTE => \Prooph\ProophessorDo\Model\Todo\Command\PostTodo::class,
                ],
            ],
        ],
        [
            'name' => 'command::mark-todo-as-done',
            'path' => '/api/commands/mark-todo-as-done',
            'middleware' => [
                \Prooph\ProophessorDo\Middleware\JsonPayload::class,
                \Prooph\Psr7Middleware\CommandMiddleware::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    \Prooph\Psr7Middleware\CommandMiddleware::NAME_ATTRIBUTE => \Prooph\ProophessorDo\Model\Todo\Command\MarkTodoAsDone::class,
                ],
            ],
        ],
        [
            'name' => 'command::reopen-todo',
            'path' => '/api/commands/reopen-todo',
            'middleware' => [
                \Prooph\ProophessorDo\Middleware\JsonPayload::class,
                \Prooph\Psr7Middleware\CommandMiddleware::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    \Prooph\Psr7Middleware\CommandMiddleware::NAME_ATTRIBUTE => \Prooph\ProophessorDo\Model\Todo\Command\ReopenTodo::class,
                ],
            ],
        ],
        [
            'name' => 'command::add-deadline-to-todo',
            'path' => '/api/commands/add-deadline-to-todo',
            'middleware' => [
                \Prooph\ProophessorDo\Middleware\JsonPayload::class,
                \Prooph\Psr7Middleware\CommandMiddleware::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    \Prooph\Psr7Middleware\CommandMiddleware::NAME_ATTRIBUTE => \Prooph\ProophessorDo\Model\Todo\Command\AddDeadlineToTodo::class,
                ],
            ],
        ],
        [
            'name' => 'command::add-reminder-to-todo',
            'path' => '/api/commands/add-reminder-to-todo',
            'middleware' => [
                \Prooph\ProophessorDo\Middleware\JsonPayload::class,
                \Prooph\Psr7Middleware\CommandMiddleware::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    \Prooph\Psr7Middleware\CommandMiddleware::NAME_ATTRIBUTE => \Prooph\ProophessorDo\Model\Todo\Command\AddReminderToTodo::class,
                ],
            ],
        ],
        [
            'name' => 'command::mark-todo-as-expired',
            'path' => '/api/commands/mark-todo-as-expired',
            'middleware' => [
                \Prooph\ProophessorDo\Middleware\JsonPayload::class,
                \Prooph\Psr7Middleware\CommandMiddleware::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    \Prooph\Psr7Middleware\CommandMiddleware::NAME_ATTRIBUTE => \Prooph\ProophessorDo\Model\Todo\Command\MarkTodoAsExpired::class,
                ],
            ],
        ],
    ],
];

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
                    'user_id' => '[\w+-]{36,36}'
                ]
            ]
        ],
        [
            'name' => 'page::user-todo-form',
            'path' => '/user-todo-list/{user_id}/new-todo',
            'middleware' => \Prooph\ProophessorDo\App\Action\UserTodoForm::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'tokens' => [
                    'user_id' => '[\w+-]{36,36}'
                ]
            ]
        ],
        //Commanding API
        [
            'name' => 'command::register-user',
            'path' => '/api/commands/register-user',
            'middleware' => \Prooph\ProophessorDo\App\Commanding\API::class,
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    'command' => \Prooph\ProophessorDo\Model\User\Command\RegisterUser::class,
                ]
            ]
        ],
        [
            'name' => 'command::post-todo',
            'path' => '/api/commands/post-todo',
            'middleware' => \Prooph\ProophessorDo\App\Commanding\API::class,
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    'command' => \Prooph\ProophessorDo\Model\Todo\Command\PostTodo::class,
                ]
            ]
        ],
        [
            'name' => 'command::mark-todo-as-done',
            'path' => '/api/commands/mark-todo-as-done',
            'middleware' => \Prooph\ProophessorDo\App\Commanding\API::class,
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    'command' => \Prooph\ProophessorDo\Model\Todo\Command\MarkTodoAsDone::class,
                ]
            ]
        ],
        [
            'name' => 'command::add-deadline-to-todo',
            'path' => '/api/commands/add-deadline-to-todo',
            'middleware' => \Prooph\Proophessor\App\Commanding\API::class,
            'allowed_methods' => ['POST'],
            'options' => [
                'values' => [
                    'command' => \Prooph\Proophessor\Model\Todo\Command\AddDeadlineToTodo::class,
                ]
            ]
        ],
    ]
];

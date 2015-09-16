<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 5:07 PM
 */
return [
    'prooph' => [
        'event_store' => [
            'plugins' => [
                \Prooph\EventStoreBusBridge\EventPublisher::class,
            ],
        ],
        'service_bus' => [
            'command_bus' => [
                'plugins' => [
                    \Prooph\EventStoreBusBridge\TransactionManager::class,
                ],
                'router' => [
                    'routes' => [
                        \Prooph\Proophessor\Model\User\Command\RegisterUser::class => \Prooph\Proophessor\Model\User\Handler\RegisterUserHandler::class,
                        \Prooph\Proophessor\Model\Todo\Command\PostTodo::class     => \Prooph\Proophessor\Model\Todo\Handler\PostTodoHandler::class,
                        \Prooph\Proophessor\Model\Todo\Command\MarkTodoAsDone::class     => \Prooph\Proophessor\Model\Todo\Handler\MarkTodoAsDoneHandler::class,
                    ]
                ]
            ],
            'event_bus' => [
                'plugins' => [
                    \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class
                ],
                'router' => [
                    'routes' => [
                        \Prooph\Proophessor\Model\User\Event\UserWasRegistered::class => [
                            \Prooph\Proophessor\Projection\User\UserProjector::class,
                        ],
                        \Prooph\Proophessor\Model\Todo\Event\TodoWasPosted::class => [
                            \Prooph\Proophessor\Projection\Todo\TodoProjector::class,
                            \Prooph\Proophessor\Projection\User\UserProjector::class,
                        ],
                        \Prooph\Proophessor\Model\Todo\Event\TodoWasMarkedAsDone::class => [
                            \Prooph\Proophessor\Projection\Todo\TodoProjector::class,
                        ],
                    ]
                ]
            ]
        ]
    ],
];

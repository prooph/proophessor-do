<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Mark all open todos past their deadline as expired
 */

namespace Prooph\ProophessorDo\Script;

use Prooph\ProophessorDo\Model\Todo\Command\MarkTodoAsExpired;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use Prooph\ServiceBus\CommandBus;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

markExpiredTodos();

function markExpiredTodos()
{
    $container = require 'config/container.php';

    $todoFinder = $container->get(TodoFinder::class);

    $todos = $todoFinder->findOpenWithPastTheirDeadline();

    if (empty($todos)) {
        echo "\033[1;32mNo open todo with past its deadline found!\033[42m\n";
        exit(1);
    }

    $commandBus = $container->get(CommandBus::class);

    foreach ($todos as $todo) {
        $command = new MarkTodoAsExpired([
            'todo_id' => $todo->id,
        ]);

        $commandBus->dispatch($command);
    }

    echo "\033[1;32mAll todos past their deadline are now marked as expired!\033[42m\n";
}

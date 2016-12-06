<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This script looks for todos with open reminders and reminds the assignees
 */
namespace {

    use Prooph\ProophessorDo\Model\Todo\Command\RemindTodoAssignee;
    use Prooph\ProophessorDo\Model\Todo\TodoId;
    use Prooph\ProophessorDo\Model\Todo\TodoReminder;
    use Prooph\ProophessorDo\Projection\Todo\TodoReminderFinder;
    use Prooph\ServiceBus\CommandBus;

    chdir(dirname(__DIR__));

    // Setup autoloading
    require 'vendor/autoload.php';

    $container = require 'config/container.php';

    $commandBus = $container->get(CommandBus::class);
    $todoReminderFinder = $container->get(TodoReminderFinder::class);

    $todoReminder = $todoReminderFinder->findOpen();

    if (!$todoReminder) {
        echo "Nothing to do. Exiting.\n";
        exit;
    }

    foreach ($todoReminder as $reminder) {
        echo "Send reminder for Todo with id {$reminder->todo_id}.\n";
        $commandBus->dispatch(
            RemindTodoAssignee::forTodo(
                TodoId::fromString($reminder->todo_id), TodoReminder::from($reminder->reminder, $reminder->status)
            ));
    }

    echo "Done!\n";
}

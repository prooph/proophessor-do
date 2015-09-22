<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 5:58 PM
 */
namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\User\UserCollection;
use Prooph\ProophessorDo\Model\User\Exception\UserNotFound;
use Prooph\ProophessorDo\Model\Todo\Command\PostTodo;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class PostTodoHandler
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class PostTodoHandler
{
    /**
     * @var TodoList
     */
    private $todoList;

    /**
     * @var UserCollection
     */
    private $userCollection;

    /**
     * @param UserCollection $userCollection
     * @param TodoList $todoList
     */
    public function __construct(UserCollection $userCollection, TodoList $todoList)
    {
        $this->userCollection = $userCollection;
        $this->todoList = $todoList;
    }

    /**
     * @param PostTodo $command
     * @throws \Prooph\ProophessorDo\Model\User\Exception\UserNotFound
     */
    public function __invoke(PostTodo $command)
    {
        $user = $this->userCollection->get($command->assigneeId());

        if (! $user) {
            throw UserNotFound::withUserId($command->assigneeId());
        }

        $todo = $user->postTodo($command->text(), $command->todoId());

        $this->todoList->add($todo);
    }
}

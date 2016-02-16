<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 2/16/16
 */
namespace Prooph\ProophessorDo\Model\Todo\Exception;

use Prooph\ProophessorDo\Model\Todo\TodoId;

/**
 * Class TodoNotFound
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Bas Kamer <bas@bushbaby.nl>
 */
final class TodoNotFound extends \InvalidArgumentException
{
    /**
     * @param TodoId $todoId
     * @return TodoNotFound
     */
    public static function withTodoId(TodoId $todoId)
    {
        return new self(sprintf('Todo with id %s cannot be found.', $todoId->toString()));
    }
}

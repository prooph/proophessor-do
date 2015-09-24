<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 5:19 PM
 */

namespace Prooph\ProophessorDo\Model\Todo;

/**
 * Interface TodoList
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface TodoList
{
    /**
     * @param Todo $todo
     * @return void
     */
    public function add(Todo $todo);

    /**
     * @param TodoId $todoId
     * @return Todo
     */
    public function get(TodoId $todoId);
}

<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Projection;

/**
 * Class Table
 *
 * @package Prooph\ProophessorDo\Projection
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class Table
{
    const USER = 'read_user';
    const TODO = "read_todo";
    const TODO_REMINDER = "read_todo_reminder";
}

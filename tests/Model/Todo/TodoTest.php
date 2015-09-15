<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/15/15 - 8:48 PM
 */
namespace ProophTest\Proophessor\Model\Todo;

use Prooph\Proophessor\Model\Todo\Event\TodoWasPosted;
use Prooph\Proophessor\Model\Todo\Todo;
use Prooph\Proophessor\Model\Todo\TodoId;
use Prooph\Proophessor\Model\User\UserId;
use ProophTest\Proophessor\TestCase;

/**
 * Class TodoTest
 *
 * @package ProophTest\Proophessor\Model\Todo
 */
final class TodoTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_new_todo_when_posting_a_text()
    {
        $assigneeId = UserId::generate();
        $todoId = TodoId::generate();

        $todo = Todo::post('This is test todo', $assigneeId, $todoId);

        $this->assertInstanceOf(Todo::class, $todo);

        $events = $this->popRecordedEvent($todo);

        $this->assertEquals(1, count($events));

        $this->assertInstanceOf(TodoWasPosted::class, $events[0]);

        $expectedPayload = [
            'text' => 'This is test todo',
            'assignee_id' => $assigneeId->toString(),
            'status' => 'open'
        ];

        $this->assertEquals($expectedPayload, $events[0]->payload());
    }
}

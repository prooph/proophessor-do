<?php

namespace ProophTest\ProophessorDo\Model\Todo;

use ProophTest\ProophessorDo\TestCase;
use Prooph\ProophessorDo\Model\Todo\TodoDeadline;

/**
 * Class TodoDeadlineTest
 * @package ProophTest\ProophessorDo\Model\Todo
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
final class TodoDeadlineTest extends TestCase
{
    /**
     * @test
     * @dataProvider getDeadlines
     */
    public function it_correctly_validates_the_deadline($deadline, $inThePast)
    {
        $deadline = TodoDeadline::fromString($deadline);
        $deadlineInThePast = $deadline->isInThePast();

        if ($inThePast) {
            $this->assertTrue($deadlineInThePast);
        } else {
            $this->assertFalse($deadlineInThePast);
        }
    }

    public function getDeadlines()
    {
        return [
            [
                '2047-02-01 10:00:00',
                false
            ],
            [
                '1947-01-01 10:00:00',
                true
            ],
        ];
    }
}

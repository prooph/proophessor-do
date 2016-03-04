<?php

namespace ProophTest\ProophessorDo\Model\Todo;

use Prooph\ProophessorDo\Model\Todo\TodoReminder;
use ProophTest\ProophessorDo\TestCase;

/**
 * Class TodoReminderTest
 * @package ProophTest\ProophessorDo\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class TodoReminderTest extends TestCase
{
    /**
     * @test
     * @dataProvider getReminders
     *
     * @param $reminder
     * @param $inThePast
     */
    public function it_correctly_validates_the_reminder($reminder, $inThePast)
    {
        $reminder = TodoReminder::fromString($reminder);
        $reminderInThePast = $reminder->isInThePast();

        if ($inThePast) {
            $this->assertTrue($reminderInThePast);
        } else {
            $this->assertFalse($reminderInThePast);
        }
    }

    public function getReminders()
    {
        return [
            ['2047-02-01 10:00:00', false],
            ['1947-01-01 10:00:00', true],
        ];
    }
}

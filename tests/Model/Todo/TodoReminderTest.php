<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ProophTest\ProophessorDo\Model\Todo;

use Prooph\ProophessorDo\Model\Todo\TodoReminder;
use Prooph\ProophessorDo\Model\Todo\TodoReminderStatus;
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
        $reminder = TodoReminder::from($reminder, TodoReminderStatus::OPEN()->getName());

        if ($inThePast) {
            $this->assertTrue($reminder->isInThePast());
            $this->assertFalse($reminder->isInTheFuture());
        } else {
            $this->assertFalse($reminder->isInThePast());
            $this->assertTrue($reminder->isInTheFuture());
        }
    }

    public function getReminders()
    {
        return [
            ['2047-02-01 10:00:00', false],
            ['1947-01-01 10:00:00', true],
        ];
    }

    /**
     * @test
     */
    public function it_knows_about_its_status()
    {
        $reminder = TodoReminder::from('2047-02-01 10:00:00', TodoReminderStatus::OPEN()->getName());
        $this->assertTrue($reminder->isOpen());

        $reminder = TodoReminder::from('2047-02-01 10:00:00', TodoReminderStatus::CLOSED()->getName());
        $this->assertFalse($reminder->isOpen());
    }

    public function it_returns_a_new_reminder_with_status_closed_when_closed()
    {
        $reminder = TodoReminder::from('2047-02-01 10:00:00', TodoReminderStatus::OPEN()->getName());
        $reminderClosed = $reminder->close();

        $this->assertNotEquals($reminder, $reminderClosed);
        $this->assertFalse($reminderClosed->isOpen());
    }
}

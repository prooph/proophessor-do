<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Model\Todo;

use Assert\Assertion;

/**
 * Class TodoReminderStatus
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class TodoReminderStatus
{
    const OPEN = "open";
    const CLOSED = "closed";

    /**
     * @var string
     */
    private $status;

    /**
     * @return TodoReminderStatus
     */
    public static function open()
    {
        return new self(self::OPEN);
    }

    /**
     * @return TodoReminderStatus
     */
    public static function closed()
    {
        return new self(self::CLOSED);
    }

    /**
     * @param string $status
     * @return TodoReminderStatus
     */
    public static function fromString($status)
    {
        return new self($status);
    }

    /**
     * @param string $status
     */
    private function __construct($status)
    {
        Assertion::inArray($status, [self::OPEN, self::CLOSED]);
        $this->status = $status;
    }

    /**
     * @return TodoReminderStatus
     */
    public function close()
    {
        return new self(self::CLOSED);
    }

    /**
     * @return bool
     */
    public function isOpen()
    {
        return $this->status !== self::CLOSED;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->status === self::CLOSED;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->status;
    }
}

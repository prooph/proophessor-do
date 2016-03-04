<?php

namespace Prooph\ProophessorDo\Model\Todo;

/**
 * Class TodoReminder
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class TodoReminder
{
    /**
     * @var \DateTimeImmutable
     */
    private $reminder;

    /**
     * @var \DateTimeImmutable
     */
    private $createdOn;

    /**
     * @param string $reminder
     * @return TodoReminder
     */
    public static function fromString($reminder)
    {
        return new self($reminder);
    }

    /**
     * @param string $reminder
     */
    private function __construct($reminder)
    {
        $this->reminder = new \DateTimeImmutable($reminder);
        $this->createdOn = new \DateTimeImmutable;
    }

    /**
     * @return bool
     */
    public function isInThePast()
    {
        return $this->reminder < $this->createdOn;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->reminder->format(\DateTime::ATOM);
    }

    /**
     * @return string
     */
    public function createdOn()
    {
        return $this->createdOn->format(\DateTime::ATOM);
    }
}

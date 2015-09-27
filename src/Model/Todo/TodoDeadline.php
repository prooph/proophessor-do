<?php

namespace Prooph\ProophessorDo\Model\Todo;

/**
 * Class TodoDeadline
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
final class TodoDeadline
{
    const DATE_FORMAT = 'c';

    /**
     * @var \DateTimeImmutable
     */
    private $deadline;

    /**
     * @var \DateTimeImmutable
     */
    private $createdOn;

    /**
     * @param string $deadline
     * @param string $createdOn
     * @return TodoDeadline
     */
    public static function fromString($deadline, $createdOn)
    {
        return new self($deadline, $createdOn);
    }

    /**
     * @param string $deadline
     * @param string $createdOn
     */
    private function __construct($deadline, $createdOn)
    {
        $this->deadline = new \DateTimeImmutable($deadline);
        $this->createdOn = new \DateTimeImmutable($createdOn);
    }

    /**
     * @return bool
     */
    public function isInThePast()
    {
        return $this->deadline < $this->createdOn;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->deadline->format(self::DATE_FORMAT);
    }

    /**
     * @return string
     */
    public function createdOn()
    {
        return $this->createdOn->format(self::DATE_FORMAT);
    }
}

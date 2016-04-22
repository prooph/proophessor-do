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
     * @return TodoDeadline
     */
    public static function fromString($deadline)
    {
        return new self($deadline);
    }

    /**
     * @param string $deadline
     */
    private function __construct($deadline)
    {
        $this->deadline = new \DateTimeImmutable($deadline);
        $this->createdOn = new \DateTimeImmutable;
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
        return $this->deadline->format(\DateTime::ATOM);
    }

    /**
     * @return string
     */
    public function createdOn()
    {
        return $this->createdOn->format(\DateTime::ATOM);
    }

    /**
     * @return bool
     */
    public function isMet()
    {
        return $this->deadline > new \DateTimeImmutable;
    }
}

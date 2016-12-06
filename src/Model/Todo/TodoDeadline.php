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

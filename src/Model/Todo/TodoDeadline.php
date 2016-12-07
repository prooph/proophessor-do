<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Model\Todo;

use Prooph\ProophessorDo\Model\ValueObject;

/**
 * Class TodoDeadline
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
final class TodoDeadline implements ValueObject
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
        $this->deadline = new \DateTimeImmutable($deadline, new \DateTimeZone('UTC'));
        $this->createdOn = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
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

    /**
     * @param ValueObject $object
     *
     * @return bool
     */
    public function sameValueAs(ValueObject $object)
    {
        return get_class($this) === get_class($object)
            && $this->deadline->format('U.u') === $object->deadline->format('U.u')
            && $this->createdOn->format('U.u') === $object->createdOn->format('U.u');
    }
}

<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 5:16 PM
 */
namespace Prooph\ProophessorDo\Model\Todo;

use Assert\Assertion;

/**
 * Class TodoStatus
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoStatus
{
    const OPEN = "open";
    const DONE = "done";
    const EXPIRED = "expired";

    /**
     * @var string
     */
    private $status;

    /**
     * @return TodoStatus
     */
    public static function open()
    {
        return new self(self::OPEN);
    }

    /**
     * @param string $status
     * @return TodoStatus
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
        Assertion::inArray($status, [self::OPEN, self::DONE, self::EXPIRED]);
        $this->status = $status;
    }

    /**
     * @return TodoStatus
     */
    public function close()
    {
        return new self(self::DONE);
    }

    public function expire()
    {
        return new self(self::EXPIRED);
    }

    /**
     * @return bool
     */
    public function isOpen()
    {
        return $this->status !== self::DONE;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->status === self::DONE;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->status === self::EXPIRED;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->status;
    }
}

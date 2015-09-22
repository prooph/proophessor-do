<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 5:23 PM
 */
namespace Prooph\ProophessorDo\Model\Todo;

use Rhumsaa\Uuid\Uuid;

/**
 * Class TodoId
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoId
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @return TodoId
     */
    public static function generate()
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @param $todoId
     * @return TodoId
     */
    public static function fromString($todoId)
    {
        return new self(Uuid::fromString($todoId));
    }

    /**
     * @param Uuid $uuid
     */
    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->uuid->toString();
    }

    /**
     * @param TodoId $other
     * @return bool
     */
    public function sameValueAs(TodoId $other)
    {
        return $this->toString() === $other->toString();
    }
}

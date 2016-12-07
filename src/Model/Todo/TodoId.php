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

use Prooph\ProophessorDo\Model\ValueObject;
use Rhumsaa\Uuid\Uuid;

/**
 * Class TodoId
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoId implements ValueObject
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
     * @param ValueObject $other
     * @return bool
     */
    public function sameValueAs(ValueObject $other)
    {
        return get_class($this) === get_class($other) && $this->uuid->equals($other->uuid);
    }
}

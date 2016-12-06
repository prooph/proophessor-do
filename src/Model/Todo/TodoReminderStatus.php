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

use MabeEnum\Enum;
use MabeEnum\EnumSerializableTrait;
use Prooph\ProophessorDo\Model\ValueObject;

/**
 * Class TodoReminderStatus
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 *
 * @method static TodoReminderStatus OPEN()
 * @method static TodoReminderStatus CLOSED()
 */
final class TodoReminderStatus extends Enum implements ValueObject
{
    use EnumSerializableTrait;

    const OPEN = "open";
    const CLOSED = "closed";

    /**
     * @param ValueObject $object
     *
     * @return bool
     */
    public function sameValueAs(ValueObject $object)
    {
        return $this->is($object);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }
}

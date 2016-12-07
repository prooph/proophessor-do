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

namespace Prooph\ProophessorDo\Model;

use MabeEnum\Enum as MabeEnum;
use MabeEnum\EnumSerializableTrait;

abstract class Enum extends MabeEnum implements ValueObject
{
    use EnumSerializableTrait;

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

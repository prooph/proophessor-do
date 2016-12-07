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

namespace Prooph\ProophessorDo\Model\User;

use Prooph\ProophessorDo\Model\ValueObject;
use Rhumsaa\Uuid\Uuid;

/**
 * Class UserId
 *
 * The UserId identifies a User.
 *
 * @package Prooph\ProophessorDo\Model\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserId implements ValueObject
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @return UserId
     */
    public static function generate()
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @param $userId
     * @return UserId
     */
    public static function fromString($userId)
    {
        return new self(Uuid::fromString($userId));
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

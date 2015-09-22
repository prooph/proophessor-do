<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 12:24 AM
 */
namespace Prooph\ProophessorDo\Model\User;

use Rhumsaa\Uuid\Uuid;

/**
 * Class UserId
 *
 * The UserId identifies a User.
 *
 * @package Prooph\ProophessorDo\Model\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserId
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
     * @param UserId $other
     * @return bool
     */
    public function sameValueAs(UserId $other)
    {
        return $this->toString() === $other->toString();
    }
}

<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 12:27 AM
 */
namespace Prooph\ProophessorDo\Model\User;

use ValueObjects\Web\EmailAddress as VOEMailAddress;

/**
 * Class EmailAddress
 *
 * Email address of a User.
 *
 * @package Prooph\ProophessorDo\Model\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class EmailAddress
{
    /**
     * @var VOEMailAddress
     */
    private $email;

    /**
     * @param string $email
     * @return EmailAddress
     */
    public static function fromString($email)
    {
        return new self(VOEMailAddress::fromNative($email));
    }

    /**
     * @param VOEMailAddress $emailAddress
     */
    private function __construct(VOEMailAddress $emailAddress)
    {
        $this->email = $emailAddress;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->email->toNative();
    }

    /**
     * @param EmailAddress $other
     * @return bool
     */
    public function sameValueAs(EmailAddress $other)
    {
        return $this->toString() === $other->toString();
    }
}

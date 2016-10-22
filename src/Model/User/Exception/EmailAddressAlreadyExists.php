<?php

namespace Prooph\ProophessorDo\Model\User\Exception;

use Prooph\ProophessorDo\Model\User\EmailAddress;

/**
 * Class EmailAddressAlreadyExists
 *
 * @package Prooph\ProophessorDo\Model\User\Exception
 * @author Lucas Courot <lucas@courot.com>
 */
final class EmailAddressAlreadyExists extends \InvalidArgumentException
{
    /**
     * @param EmailAddress $emailAddress
     * @return EmailAddressAlreadyExists
     */
    public static function withEmailAddress(EmailAddress $emailAddress)
    {
        return new self(sprintf('Email address %s already exists.', $emailAddress->toString()));
    }
}

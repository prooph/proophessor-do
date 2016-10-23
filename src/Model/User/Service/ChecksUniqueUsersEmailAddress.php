<?php

namespace Prooph\ProophessorDo\Model\User\Service;

use Prooph\ProophessorDo\Model\User\EmailAddress;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Interface ChecksUniqueUsersEmailAddress
 *
 * @package Prooph\ProophessorDo\Model\User\Service
 * @author Lucas Courot <lucas@courot.com>
 */
interface ChecksUniqueUsersEmailAddress
{
    /**
     * Checks if the user's email address already exists. If the user exists, it returns its user id.
     *
     * @param EmailAddress $emailAddress
     * @return null|UserId
     */
    public function __invoke(EmailAddress $emailAddress);
}

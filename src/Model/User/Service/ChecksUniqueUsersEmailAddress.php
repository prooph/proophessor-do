<?php

namespace Prooph\ProophessorDo\Model\User\Service;

use Prooph\ProophessorDo\Model\User\EmailAddress;

/**
 * Interface ChecksUniqueUsersEmailAddress
 *
 * @package Prooph\ProophessorDo\Model\User\Service
 * @author Lucas Courot <lucas@courot.com>
 */
interface ChecksUniqueUsersEmailAddress
{
    /**
     * Checks if the user's email address already exists
     *
     * @param EmailAddress $emailAddress
     *
     * @return bool
     */
    public function alreadyExists(EmailAddress $emailAddress);
}

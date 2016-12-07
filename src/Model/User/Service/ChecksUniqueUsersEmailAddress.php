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

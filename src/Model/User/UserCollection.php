<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 6:38 PM
 */

namespace Prooph\ProophessorDo\Model\User;

/**
 * Interface UserCollection
 *
 * @package Prooph\ProophessorDo\Model\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface UserCollection
{
    /**
     * @param User $user
     * @return void
     */
    public function add(User $user);

    /**
     * @param UserId $userId
     * @return User
     */
    public function get(UserId $userId);
}

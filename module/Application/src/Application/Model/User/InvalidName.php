<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 6:56 PM
 */
namespace Application\Model\User;

/**
 * Class InvalidName
 *
 * @package Application\Model\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class InvalidName extends \InvalidArgumentException
{
    /**
     * @param string $msg
     * @return InvalidName
     */
    public static function reason($msg)
    {
        return new self('Invalid user name because ' . (string)$msg);
    }
}

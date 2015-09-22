<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 5:06 PM
 */
namespace Prooph\ProophessorDo\Model\Todo\Exception;

/**
 * Class InvalidText
 *
 * @package Prooph\ProophessorDo\Model\Todo\Exception
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class InvalidText extends \InvalidArgumentException
{
    /**
     * @param string $msg
     * @return InvalidText
     */
    public static function reason($msg)
    {
        return new self('The todo text is invalid: ' . $msg);
    }
}

<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

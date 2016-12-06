<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prooph\ProophessorDo\Container\Console;

use Interop\Container\ContainerInterface;
use Prooph\Cli\Console\Helper\Psr4Info;

class Psr4ClassInfoFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $docblock = <<<'PROOPH'
This file is part of prooph/proophessor.
(c) 2014-2016 prooph software GmbH <contact@prooph.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
PROOPH;

        return new Psr4Info(
            'src',
            'Prooph\\ProophessorDo\\',
            $docblock
        );
    }
}

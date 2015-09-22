<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 8:53 PM
 */
namespace Prooph\ProophessorDo\Container\Projection\Todo;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;

/**
 * Class TodoFinderFactory
 *
 * @package Prooph\ProophessorDo\Projection\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoFinderFactory
{
    /**
     * @param ContainerInterface $container
     * @return TodoFinder
     */
    public function __invoke(ContainerInterface $container)
    {
        return new TodoFinder($container->get('doctrine.connection.default'));
    }
}

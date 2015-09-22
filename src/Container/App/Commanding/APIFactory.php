<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 7/5/15 - 8:23 PM
 */
namespace Prooph\ProophessorDo\Container\App\Commanding;

use Interop\Container\ContainerInterface;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\ProophessorDo\App\Commanding\API;
use Prooph\ServiceBus\CommandBus;

/**
 * Class APIFactory
 *
 * @package Prooph\ProophessorDo\App\Container\Commanding
 */
final class APIFactory
{
    /**
     * @param ContainerInterface $container
     * @return API
     */
    public function __invoke(ContainerInterface $container)
    {
        return new API($container->get(CommandBus::class), new FQCNMessageFactory());
    }
}

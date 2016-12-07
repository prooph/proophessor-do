<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Container\App\Action;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\App\Action\UserList;
use Prooph\ServiceBus\QueryBus;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class UserListFactory
 *
 * @package Prooph\ProophessorDo\Container\App\Action
 */
final class UserListFactory
{
    /**
     * @param ContainerInterface $container
     * @return UserList
     */
    public function __invoke(ContainerInterface $container)
    {
        return new UserList($container->get(TemplateRendererInterface::class), $container->get(QueryBus::class));
    }
}

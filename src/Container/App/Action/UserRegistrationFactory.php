<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 3:02 PM
 */
namespace Prooph\ProophessorDo\Container\App\Action;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\App\Action\UserRegistration;
use Zend\Expressive\Template\TemplateInterface;

/**
 * Class UserRegistrationFactory
 *
 * @package Prooph\ProophessorDo\Container\App\Action
 */
final class UserRegistrationFactory
{
    /**
     * @param ContainerInterface $container
     * @return UserRegistration
     */
    public function __invoke(ContainerInterface $container)
    {
        return new UserRegistration($container->get(TemplateInterface::class));
    }
}

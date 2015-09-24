<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/5/15 - 9:48 PM
 */
namespace Prooph\ProophessorDo\Container\Infrastructure;

use Doctrine\DBAL\DriverManager;
use Interop\Config\ConfigurationTrait;
use Interop\Config\HasContainerId;
use Interop\Config\HasMandatoryOptions;
use Interop\Container\ContainerInterface;

/**
 * Class DoctrineDbalConnectionFactory
 *
 * @package src\Infrastructure\Container
 */
final class DoctrineDbalConnectionFactory implements HasMandatoryOptions, HasContainerId
{
    use ConfigurationTrait;

    /**
     * @param ContainerInterface $container
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function __invoke(ContainerInterface $container)
    {
        $options = $this->options($container->get('config'));

        return DriverManager::getConnection($options);
    }

    /**
     * Returns the vendor name
     *
     * @return string
     */
    public function vendorName()
    {
        return 'doctrine';
    }

    /**
     * Returns the package name
     *
     * @return string
     */
    public function packageName()
    {
        return 'connection';
    }

    /**
     * Returns the container identifier
     *
     * @return string
     */
    public function containerId()
    {
        return 'default';
    }

    /**
     * Returns a list of mandatory options which must be available
     *
     * @return string[] List with mandatory options
     */
    public function mandatoryOptions()
    {
        return ['driverClass'];
    }
}

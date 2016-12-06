<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'vendor/autoload.php';

$container = require 'config/container.php';

$cli = new \Symfony\Component\Console\Application('Doctrine Command Line Interface', \Doctrine\DBAL\Migrations\MigrationsVersion::VERSION());

$helperSet = new \Symfony\Component\Console\Helper\HelperSet();

$helperSet->set(new \Symfony\Component\Console\Helper\DialogHelper(), 'dialog');

$helperSet->set(
    new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper(
        $container->get('doctrine.connection.default')
    ),
    'connection'
);

$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);

$cli->addCommands(array(
    // Migrations Commands
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand()
));

$cli->run();






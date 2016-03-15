<?php
namespace Prooph\ProophessorDo\Container\Projection\Todo;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Projection\Todo\TodoReminderProjector;

/**
 * Class TodoProjectorFactory
 *
 * @package Prooph\ProophessorDo\Projection\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class TodoReminderProjectorFactory
{
    /**
     * @param ContainerInterface $container
     * @return TodoReminderProjector
     */
    public function __invoke(ContainerInterface $container)
    {
        return new TodoReminderProjector($container->get('doctrine.connection.default'));
    }
}

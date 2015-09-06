<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 12:41 PM
 */
namespace Prooph\Proophessor\App\View;

use Interop\Container\ContainerInterface;
use Zend\View\HelperPluginManager;

/**
 * Class ViewHelperPluginManager
 *
 * @package Prooph\Proophessor\App\View
 */
final class ViewHelperPluginManager extends HelperPluginManager
{
    const HELPER_NAMESPACE = 'Prooph\Proophessor\App\View\Helper';
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public function has($name, $checkAbstractFactories = true, $usePeeringServiceManagers = true)
    {
        if ($this->container->has($this->normalizeHelperName($name))) {
            return true;
        }

        return parent::has($name, $checkAbstractFactories, $usePeeringServiceManagers);
    }

    /**
     * @inheritdoc
     */
    public function get($name, $options = [], $usePeeringServiceManagers = true)
    {
        if ($this->container->has($this->normalizeHelperName($name))) {
            return $this->container->get($this->normalizeHelperName($name));
        }

        return parent::get($name, $options, $usePeeringServiceManagers);
    }

    private function normalizeHelperName($helperName)
    {
        return self::HELPER_NAMESPACE . '\\' . ucfirst($helperName);
    }
}

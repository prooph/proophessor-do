<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\App\View\Helper;

use Zend\Expressive\Router\RouterInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Class Url
 *
 * @package Prooph\ProophessorDo\App\View\Helper
 */
final class Url extends AbstractHelper
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $routeName
     * @param array $options
     * @return string
     */
    public function __invoke($routeName, $options = [])
    {
        return $this->router->generateUri($routeName, $options);
    }
}

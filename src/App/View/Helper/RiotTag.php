<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 12:59 PM
 */

namespace Prooph\Proophessor\App\View\Helper;

use Zend\View\Renderer\PhpRenderer;

/**
 * Class RiotTag
 *
 * @package Application\View\Helper
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class RiotTag
{
    /**
     * @var PhpRenderer
     */
    private $view;

    private $search = ['"', "\n"];

    private $replace = ['\"', ""];

    /**
     * @param PhpRenderer $view
     */
    public function __construct(PhpRenderer $view)
    {
        $this->view = $view;
    }

    public function __invoke($tagName, $template = null, $jsFunction = null)
    {
        if (is_null($template)) {
            $template = $tagName;
            $tagName  = $this->getTagNameFromTemplate($template);
        }

        $this->assertTagName($tagName);
        $this->assertTemplate($template);

        $template = $this->view->partial($template);

        if (is_null($jsFunction)) {
            $jsFunction = $this->extractJsFunction($template, $tagName);
            $template = $this->removeJsFromTemplate($template, $tagName);
        }

        return 'riot.tag("'.$tagName.'", "' . str_replace($this->search, $this->replace, $template) . '", '.$jsFunction.');';
    }

    private function getTagNameFromTemplate($template)
    {
        $this->assertTemplate($template);

        $parts = explode("::", $template);

        return array_pop($parts);
    }

    private function assertTagName($tagName)
    {
        if (!is_string($tagName)) {
            throw new \InvalidArgumentException("Riot tag name should be a string. got " . gettype($tagName));
        }
    }

    private function assertTemplate($template)
    {
        if (!is_string($template)) {
            throw new \InvalidArgumentException("Riot template should be a string. got " . gettype($template));
        }
    }

    private function extractJsFunction($template, $tagName)
    {
        preg_match('/<script .*type="text\/javascript"[^>]*>[\s]*(?<func>function.+\});?[\s]*<\/script>/is', $template, $matches);

        if (! $matches['func']) {
            throw new \RuntimeException("Riot tag javascript function could not be found for tag name: " . $tagName);
        }

        return $matches['func'];
    }

    private function removeJsFromTemplate($template, $tagName)
    {
        $template = preg_replace('/<script .*type="text\/javascript"[^>]*>.*<\/script>/is', "", $template);

        if (! $template) {
            throw new \RuntimeException("Riot tag template compilation failed for tag: " . $tagName . " with error code: " . preg_last_error());
        }

        return $template;
    }
}

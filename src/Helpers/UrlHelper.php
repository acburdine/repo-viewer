<?php
/**
 * Github Stylish Repository Viewer
 * An easy way to show your Github profile on your site - in style!
 *
 * @author      Austin Burdine <austin@acburdine.me>
 * @copyright   2015 Austin Burdine
 * @link        https://github.com/acburdine/repo-viewer/
 * @license     (MIT) - https://github.com/acburdine/repo-viewer/blob/master/LICENSE
 * @version     1.0.0
 */

namespace Acburdine\RepoViewer\Helpers;

use Handlebars\Helper;
use Handlebars\Template;
use Handlebars\Context;
use Acburdine\RepoViewer\Utils\Url;

class UrlHelper implements Helper {

    public function execute(Template $template, Context $context, $args, $source) {
        $parsed = $template->parseArguments($args);
        if(count($parsed) < 1) {
            throw new \InvalidArgumentException('url helper expects one argument');
        }
        $urlFor = $context->get(array_shift($parsed));
        return Url::getUrl($urlFor);
    }
    
}
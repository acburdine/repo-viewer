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
use Acburdine\RepoViewer\Model\Settings;

class AssetHelper implements Helper {

    protected $hasHtaccess;

    public function __construct() {
        $settings = Settings::getSettings();
        $this->hasHtaccess = ($settings->get('htaccess') == 'true');
    }

    protected function getAssetLink($file, $isAdmin = false) {
        $info = pathinfo($file);
        $base = ($isAdmin == 'true') ? '/admin/assets/' : '/assets/';
        $path = ($this->hasHtaccess) ? $base : '/index.php'.$base;
        $path .= ltrim($file, '/');
        if($info['extension'] == 'css') {
            return $this->linkTag($path);
        } else if($info['extension'] == 'js') {
            return $this->scriptTag($path);
        } // TODO: Add support for less and scss
    }

    protected function scriptTag($src) {
        return '<script src="'.$src.'" type="text/javascript"></script>';
    }

    protected function linkTag($href) {
        return '<link rel="stylesheet" type="text/css" href="'.$href.'">';
    }

    public function execute(Template $template, Context $context, $args, $source) {
        $parsed = $template->parseArguments($args);
        if(count($parsed) < 1) {
            throw new \InvalidArgumentException('asset helper expects one argument');
        }
        $file = $context->get(array_shift($parsed));
        $isAdmin = $context->get(array_shift($parsed));
        return new \Handlebars\SafeString($this->getAssetLink($file, $isAdmin));
    }
    
}


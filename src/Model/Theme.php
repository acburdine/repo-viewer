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

namespace Acburdine\RepoViewer\Model;

class Theme {

    protected static $themesDir = './content/themes/';

    protected $name;
    protected $dir;

    public function __construct($name, $dir) {
        $this->name = $name;
        $this->dir = $dir;
    }

    public function getPath($pathToAdd = '') {
        return self::$themesDir . $this->dir . $pathToAdd;
    }

    public static function getActiveTheme() {
        $settings = Settings::getSettings();
        return new Theme($settings->get('activeTheme'), $settings->get('themeDir'));
    }

}
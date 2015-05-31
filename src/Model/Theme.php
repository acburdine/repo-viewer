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
    protected static $requiredFiles = array(
        'index.hbs',
        'project.hbs',
        'package.json'
    );

    protected $dir;
    protected $name;
    protected $version;

    public function __construct($dir) {
        $this->dir = $dir;
        $this->setThemeInfo();
    }

    public function getPath($pathToAdd = '') {
        return self::$themesDir . $this->dir . $pathToAdd;
    }

    public function getArray() {
        return array(
            'name' => $this->name,
            'version' => $this->version
        );
    }

    protected function setThemeInfo() {
        $package = json_decode(file_get_contents($this->dir.DIRECTORY_SEPARATOR.'package.json'), true);
        $this->name = $package['name'];
        $this->version = $package['version'];
    }

    public static function getActiveTheme() {
        $settings = Settings::getSettings();
        return new Theme($settings->get('activeTheme'));
    }

    public static function getAllThemes() {
        $foldersInDir = scandir(self::$themesDir);
        $themes = array();
        foreach($foldersInDir as $folder) {
            $path = self::$themesDir.$folder;
            if(self::checkIsValidTheme($path)) {
                $theme = new Theme($path);
                $themes[] = $theme->getArray();
            }
        }
        return $themes;
    }

    protected static function checkIsValidTheme($themeDir) {
        if(array_diff(self::$requiredFiles, scandir($themeDir))) {
            return false;
        }
        $package = json_decode(file_get_contents($themeDir.DIRECTORY_SEPARATOR.'package.json'), true);
        return array_key_exists('name', $package) && array_key_exists('version', $package);
    }

}
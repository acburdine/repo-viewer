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

namespace Acburdine\RepoViewer\Utils;

use Acburdine\RepoViewer\Model\Settings;

class Url {

    static protected $hasHtaccess;

    static protected $urls = array(
        'home' => '/',
        'admin' => '/admin',
        'signin' => '/admin/signin/',
        'signout' => '/admin/signout/'
    );

    static public function getUrl($for) {
        self::init();
        $url = (self::$hasHtaccess) ? '' : '/index.php';
        if(array_key_exists($for, self::$urls)) {
            $url .= self::$urls[$for];
        } else {
            $url .= $for;
        }
        return $url;
    }

    static protected function init() {
        if(is_null(self::$hasHtaccess)) {
            $settings = Settings::getSettings();
            self::$hasHtaccess = ($settings->get('htaccess') == 'true');
        }
    }
}
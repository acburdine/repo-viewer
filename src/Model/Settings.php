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

use Acburdine\RepoViewer\Utils\Db;

class Settings {

    protected static $settings;

    protected $data;

    private function __construct() {
        $this->data = array();
        $result = Db::getDefault()->query("SELECT * FROM settings");
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $this->data[$row["settingName"]] = $row["settingValue"];
        }
    }

    public function get($key) {
        if($this->has($key))
            return $this->data[$key];
        return null;
    }

    public function set($key, $value) {
        if($this->has($key)) {
            $this->data[$key] = $value;
            Db::getDefault()
                ->query("UPDATE settings SET settingValue = :value WHERE settingName = :key", 
                        array("key" => $key, "value" => $value));
        }
        // TODO: Add possibility of creating new rows?
    }

    public function has($key) {
        return array_key_exists($key, $this->data);
    }

    public static function getSettings() {
        if(is_null(self::$settings))
            self::$settings = new Settings();
        return self::$settings;
    }

}
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

/**
 * Class for generating the database structure
 */
class Schema {

    protected static $dbFile = "./data/repoviewer.db";

    public static function check() {
        if(!file_exists(self::$dbFile)) {
            self::create();
        }
    }

    protected static function create() {
        $db = Db::getDefault();

        // Create users table
        $db->query(
        "CREATE TABLE users (
            username VARCHAR(30) NOT NULL,
            password CHAR(60) NOT NULL
        )");
        $db->query(
        "CREATE TABLE settings (
            settingName VARCHAR(30) NOT NULL,
            settingValue VARCHAR(60) NOT NULL
        )");

        $defaults = json_decode(file_get_contents("./data/defaults.json"), true);
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        foreach($defaults["users"] as $user) {
            $db->bindValues($stmt, $user)->execute();
        }
        $stmt = $db->prepare("INSERT INTO settings (settingName, settingValue) VALUES (:key, :value)");
        foreach($defaults["settings"] as $setting) {
            $db->bindValues($stmt, $setting)->execute();
        }
    }

}
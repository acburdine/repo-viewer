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
 * Database management class
 */
class Db {

    private static $dbFile = "./data/repoviewer.db";
    private static $instance;

    protected $handle;

    public function __construct() {
        $this->handle = new \SQLite3(self::$dbFile);
    }

    public function close() {
        $this->handle->close();
    }

    public function get() {
        return $this->handle;
    }

    public function query($sql, $values = null) {
        if(is_null($values))
            return $this->handle->query($sql);
        return $this->bindValues($this->prepare($sql), $values)->execute();
    }

    public function prepare($sql) {
        return $this->handle->prepare($sql);
    }

    public function bindValues(\SQLite3Stmt $stmt, array $values) {
        foreach($values as $key => $value) {
            $stmt->bindValue(":".$key, $value);
        }
        return $stmt;
    }

    public static function getDefault() {
        if(is_null(self::$instance))
            self::$instance = new Db();
        return self::$instance;
    }

}
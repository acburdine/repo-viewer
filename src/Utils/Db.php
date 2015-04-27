<?php
/**
 * Github Repo Viewer - an easy way to show your Github profile on your site - in style!
 *
 * @author      Austin Burdine <austin@acburdine.me>
 * @copyright   2015 Austin Burdine
 * @link        http://projects.acburdine.me/repoviewer
 * @license     http://projects.acburdine.me/repoviewer/license
 * @version     1.0.0
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
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
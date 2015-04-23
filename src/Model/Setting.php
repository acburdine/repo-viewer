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

namespace Acburdine\RepoViewer\Model;

use Acburdine\RepoViewer\Utils\Db;

class Setting {

    protected $data;

    public function __construct() {
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

}
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

class Session implements \ArrayAccess {

    protected static $sessionName = 'repoviewersession';

    protected $data;
    protected $name;

    public function __construct($name) {
        session_name(self::$sessionName);
        session_start();
        $this->name = $name;
        if(!array_key_exists($name, $_SESSION))
            $_SESSION[$name] = array();
        $this->data = $_SESSION[$name];
    }

    public function get($key) {
        if(!$this->has($key))
            return null;
        return $this->data[$key];
    }

    public function has($key) {
        return array_key_exists($this->data, $key);
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
        $this->saveSession();
        return $this;
    }

    public function remove($key) {
        if(!$this->has($key))
            return null;
        $value = $this->data[$key];
        unset($this->data[$key]);
        $this->saveSession();
        return $value;
    }

    // array access
    public function offsetExists($offset) { return $this->has($offset); }
    public function offsetGet($offset) { return $this->get($offset); }
    public function offsetSet($offset, $value) { $this->set($offset, $value); }
    public function offsetUnset($offset) { $this->remove($offset); }

    private function saveSession() {
        $_SESSION[$this->name] = $this->data;
    }

    public function close() {
        session_destroy();
    }

    public function clear() {
        $this->data = array();
        $_SESSION[$this->name] = array();
    }

    public function clearAll() {
        $this->data = array();
        $_SESSION = array();
    }

}
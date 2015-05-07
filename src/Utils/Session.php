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
        return array_key_exists($key, $this->data);
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
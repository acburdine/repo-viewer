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
use Acburdine\RepoViewer\Utils\Session;

/**
 * Handles all login/permissions for the program
 */
class User {

    protected static $session;

    public static function isActive() {
        self::init();
        return (self::$session->has('isActive') && self::$session->get('isActive'));
    }

    public static function login($user, $pass) {
        $result = Db::getDefault()->query('SELECT password FROM users WHERE username = :user LIMIT 1', array('user' => $user));

        $userData = $result->fetchArray(SQLITE3_ASSOC);
        if(!$userData)
            return false;
        if(password_verify($pass, $userData['password'])) {
            self::init();
            self::$session->set('isActive', true);
            self::$session->set('username', $user);
            return true;
        } else {
            return false;
        }
    }

    public static function logout() {
        self::init();
        self::$session->clear();
    }

    protected static function init() {
        if(is_null(self::$session))
            self::$session = new Session('auth');
    }

    public static function changePassword($newPassword) {
        self::init();
        if(!self::isActive()) {
            return false;
        }
        $pass = password_hash($newPassword, PASSWORD_BCRYPT);
        $user = self::$session->get('username');
        Db::getDefault()->query('UPDATE users SET password = :pass WHERE username = :user', array('pass' => $pass, 'user' => $user));
        return true;
    }

}
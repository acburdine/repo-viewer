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

namespace Acburdine\RepoViewer\Controller;

use Acburdine\RepoViewer\Model\User;
use Acburdine\RepoViewer\Utils\Url;

class Admin extends AbstractController {

    public function indexAction() {
        if(!User::isActive()) {
            $this->app->redirect(Url::getUrl('signin'));
        }
        $this->app->render('index', array('title'=>'Github Repo Viewer | Admin', 'user' => array('name'=>'Austin Burdine')));
    }

    public function signinAction() {
        $this->app->render('login', array('title'=>'Github Repo Viewer | Login'));
    }

    public function signoutAction() {
        User::logout();
        $this->app->redirect(Url::getUrl('signin'));
    }

    public function authorizeAction() {
        $user = $this->app->request->post('user');
        $pass = $this->app->request->post('pass');
        $response = array();

        $isAuth = User::login($user, $pass);
        if(!$isAuth) {
            $response['error'] = 'Username or password incorrect';
        } else {
            $response['to'] = Url::getUrl('admin');
        }

        $this->app->response->headers->set('Content-Type', 'application/json');
        echo json_encode($response);
    }

    public function changePassword() {
        $pass = $this->app->request->post('pass');
        $change = User::changePassword($pass);
        $response = ($change) ? array() : array('error'=>'You are not logged in');
        echo json_encode($response);
    }

    public function installAction() {

    }

}
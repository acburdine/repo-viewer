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

namespace Acburdine\RepoViewer;

class Router {

    protected static function setViewsDir($dir, $app) {
        return function () use ($dir, $app) {
            $app->view->setViewDir($dir);
        };
    }

    public static function loadRoutes(\Slim\Slim $app) {
        $frontendController = self::loadController('Frontend', $app);
        $adminController = self::loadController('Admin', $app);
        $assetsController = self::loadController('Assets', $app);

        $app->group('/admin', self::setViewsDir('./view', $app), function () use ($app, $adminController, $assetsController) {

            $app->get('(/)', array($adminController, 'indexAction'));

            $app->get('/signin(/)', array($adminController, 'signinAction'));
            $app->post('/authorize(/)', array($adminController, 'authorizeAction'));
            $app->get('/signout(/)', array($adminController, 'signoutAction'));

            $app->get('/setup(/)', array($adminController, 'installAction'));

            $app->get('/assets/:path+', array($assetsController, 'serveAdminAsset'));

        });

        // Index route
        $app->get('/', array($frontendController, 'home'));

        // Asset Rendering Controller
        $app->get('/assets/:path+', array($assetsController, 'serveAsset'));

        // Catch-all for project
        $app->get('/:project(/:extra+)', array($frontendController, 'single'));

    }

    protected static function loadController($name, \Slim\Slim $app) {
        $class = '\Acburdine\RepoViewer\Controller\\'.$name;
        return new $class($app);
    }

}
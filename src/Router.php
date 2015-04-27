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

namespace Acburdine\RepoViewer;

class Router {

    protected static function setViewsDir($dir, $app) {
        return function () use ($dir, $app) {
            $app->view->setViewDir($dir);
        };
    }

    public static function loadRoutes(\Slim\Slim $app) {
        $projectsController = self::loadController('Projects', $app);
        $adminController = self::loadController('Admin', $app);

        $app->group('/admin', self::setViewsDir('./view', $app), function () use ($app, $adminController) {

            $app->get('(/)', array($adminController, 'indexAction'));

            $app->get('/signin(/)', array($adminController, 'signinAction'));
            $app->post('/authorize(/)', array($adminController, 'authorizeAction'));

            $app->get('/setup(/)', array($adminController, 'installAction'));

        });

        // Catch-all for project
        $app->get('/:project(/:extra+)', array($projectsController, 'singleProject'));

    }

    protected static function loadController($name, \Slim\Slim $app) {
        $class = '\Acburdine\RepoViewer\Controller\\'.$name;
        return new $class($app);
    }

}
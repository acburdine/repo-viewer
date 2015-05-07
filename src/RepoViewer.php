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

use Slim\Slim;

class RepoViewer {

    public static function launch() {
        Utils\Schema::check();

        $app = new \Slim\Slim(array(
            'view' => new Utils\HandlebarsView(),
        ));

        $app->view->loadHelpers();

        Router::loadRoutes($app);

        $app->run();
    }

}

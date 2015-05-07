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

use Handlebars\Handlebars;
use Acburdine\RepoViewer\Helpers;

class HandlebarsView extends \Slim\View {

    protected $viewsDir;
    protected $engine;

    public function __construct($dir = './content/themes/theme-default/') {
        $this->viewsDir = $dir;
        $this->engine = new Handlebars();
        parent::__construct();
    }

    public function setViewDir($dir) {
        if(file_exists($dir)) {
            $this->viewsDir = rtrim($dir, '/');
        }
    }

    public function loadHelpers() {
        $this->engine->addHelper('asset', new Helpers\AssetHelper());
        $this->engine->addHelper('urlFor', new Helpers\UrlHelper());
    }

    public function render($template) {
        $this->engine->setLoader(new \Handlebars\Loader\FilesystemLoader($this->viewsDir, array('extension' => '.hbs')));
        $this->engine->setPartialsLoader(new \Handlebars\Loader\FilesystemLoader($this->viewsDir.'/partials/', array('extension' => '.hbs')));

        echo $this->engine->render($template, $this->data);
    }

}
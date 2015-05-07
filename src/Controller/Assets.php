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

use Acburdine\RepoViewer\Model\Theme;
use Assetic\Asset;

class Assets extends AbstractController {

    protected function getAsset($path) {
        $info = pathinfo($path);
        $file = new Asset\AssetCollection(array(new Asset\FileAsset($path)));
        if($info['extension'] == 'js') {
            $this->app->response->headers->set('Content-Type', 'application/javascript');
        } else if($info['extension'] == 'css') {
            $this->app->response->headers->set('Content-Type', 'text/css');
        }
        return $file->dump();
    }

    public function serveAsset($path) {
        $assetPath = implode('/', $path);
        $assetToRender = Theme::getActiveTheme()->getPath('/assets/'.$assetPath);
        $this->getAsset($assetToRender)->dump();
    }

    public function serveAdminAsset($path) {
        $assetPath = implode('/', $path);
        $assetToRender = './view/assets/'.$assetPath;
        echo $this->getAsset($assetToRender);
    }
    
}
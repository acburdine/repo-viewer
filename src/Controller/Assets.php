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
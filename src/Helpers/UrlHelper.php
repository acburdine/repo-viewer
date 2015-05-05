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

namespace Acburdine\RepoViewer\Helpers;

use Handlebars\Helper;
use Handlebars\Template;
use Handlebars\Context;
use Acburdine\RepoViewer\Model\Settings;

class UrlHelper implements Helper {

    protected $hasHtaccess;
    protected static $urls = array(
        'home' => '/',
        'admin' => '/admin',
        'signout' => '/admin/signout/'
    );

    public function __construct() {
        $settings = Settings::getSettings();
        $this->hasHtaccess = ($settings->get('htaccess') == 'true');
    }

    protected function getUrl($for) {
        $url = ($this->hasHtaccess) ? '/index.php' : '';
        $url .= self::$urls[$for];
        return $url;
    }

    public function execute(Template $template, Context $context, $args, $source) {
        $parsed = $template->parseArguments($args);
        if(count($parsed) < 1) {
            throw new \InvalidArgumentException('url helper expects one argument');
        }
        $urlFor = $context->get(array_shift($parsed));
        return $this->getUrl($urlFor);
    }
    
}
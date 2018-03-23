<?php

namespace Chronos\Views\Render;

use Chronos\Chronos;
use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;
use Chronos\Views\BaseRender;
use Chronos\Views\Form;

class RenderDefault implements BaseRender
{
    private $params = [];
    private $viewVars = [];

    public function setViewVars($viewVars)
    {
        $this->viewVars = $viewVars;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function render()
    {
        //$this->viewVars['title'] = 'chronosPHP';
        pr($this->viewVars);
        pr($this->params);

        if (Chronos::CAMELCASE === Configure::read('App.View.Folder')) {
            $viewPath = Inflector::camelize($this->params['url']['controller']);
        }
        if (Chronos::UNDERSCORE === Configure::read('App.View.Folder')) {
            $viewPath = Inflector::underscore($this->params['url']['controller']);
        }

        $fileName = '';
        if (Chronos::CAMELCASE === Configure::read('App.View.File')) {
            $fileName = Inflector::camelize($this->params['url']['action']);
        }
        if (Chronos::UNDERSCORE === Configure::read('App.View.File')) {
            $fileName = Inflector::underscore($this->params['url']['action']);
        }

        $action = $viewPath.'/'.$fileName;
        $pathApp = Configure::read('App.Path');
        $pathCore = Configure::read('Chronos.Path');
        $pathViewFile = '/Views/'; //.$viewPath.'/'; //.$action.'.php';

        $pathApp = $pathApp.$pathViewFile;
        $pathCore = $pathCore.$pathViewFile;

        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;
        $path .= $action.'.php';

        extract($this->viewVars, EXTR_SKIP);
        ob_start();

        $Form = new Form();

        require $path;

        $out = '';
        $out .= "<!-- Start file: Stored in {$path} -->\n";
        $out .= ob_get_clean();
        $out .= "\n<!-- End file: Stored in {$path} -->";

        return $this->renderLayout($out);
    }

    private function renderLayout($content_for_layout)
    {
        $data_for_layout = array_merge($this->viewVars, [
            'title_for_layout' => $this->viewVars['title'],
            'content_for_layout' => $content_for_layout,
        ]);

        $viewPath = 'Page';
        $action = 'Layouts/default';
        $pathApp = Configure::read('App.Path');
        $pathCore = Configure::read('Chronos.Path');
        $pathViewFile = '/Views/'; //.$viewPath.'/'; //.$action.'.php';

        $pathApp = $pathApp.$pathViewFile;
        $pathCore = $pathCore.$pathViewFile;

        $path = (file_exists($pathApp.$action.'.php')) ? $pathApp : $pathCore;
        $path .= $action.'.php';

        extract($data_for_layout, EXTR_SKIP);
        ob_start();

        $Form = new Form();

        require $path;

        $out = '';
        $out .= "<!-- Start file: Stored in {$path} -->\n";
        $out .= ob_get_clean();
        $out .= "\n<!-- End file: Stored in {$path} -->";

        return $out;
    }
}

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
    private $layout = '';
    private $showPathFile = false;

    public function setViewVars($viewVars)
    {
        $this->viewVars = $viewVars;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render()
    {
        $namespace = Inflector::camelize($this->params['url']['namespace']);
        if (Chronos::CAMELCASE === Configure::read($namespace.'.View.Folder')) {
            $viewPath = Inflector::camelize($this->params['url']['controller']);
        }
        if (Chronos::UNDERSCORE === Configure::read($namespace.'.View.Folder')) {
            $viewPath = Inflector::underscore($this->params['url']['controller']);
        }

        $fileName = '';
        if (Chronos::CAMELCASE === Configure::read($namespace.'.View.File')) {
            $fileName = Inflector::camelize($this->params['url']['action']);
        }
        if (Chronos::UNDERSCORE === Configure::read($namespace.'.View.File')) {
            $fileName = Inflector::underscore($this->params['url']['action']);
        }

        if (empty(Configure::read($namespace.'.Path'))) {
            trigger_error('Missing settings on Configure::read(\''.$namespace.'\').'.PHP_EOL, E_USER_ERROR);
        }

        $action = $viewPath.'/'.$fileName;
        $pathApp = Configure::read($namespace.'.Path');
        $pathCore = Configure::read('Chronos.Path');
        $pathViewFile = '/Views/'; //.$viewPath.'/'; //.$action.'.php';

        $pathApp = $pathApp.$pathViewFile;
        $pathCore = $pathCore.$pathViewFile;

        $path = (file_exists($pathApp.$action.'.php')) ? $pathApp : $pathCore;
        $path .= $action.'.php';

        extract($this->viewVars, EXTR_SKIP);
        ob_start();

        $Form = new Form();

        require $path;

        $out = '';
        if ($this->showPathFile) {
            $out .= "<!-- [File] - Start file: Stored in {$path} -->\n";
        }
        $out .= ob_get_clean();
        if ($this->showPathFile) {
            $out .= "\n<!-- [File] - End file: Stored in {$path} -->";
        }

        return $this->renderLayout($out);
    }

    private function renderLayout($content_for_layout)
    {
        $data_for_layout = array_merge($this->viewVars, [
            'title_for_layout' => $this->viewVars['title'],
            'content_for_layout' => $content_for_layout,
        ]);

        $namespace = Inflector::camelize($this->params['url']['namespace']);

        $viewPath = 'Page';
        $action = 'Layouts/'.$this->layout;
        $pathApp = Configure::read($namespace.'.Path');
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
        if ($this->showPathFile) {
            $out .= "<!-- [Layout] - Start file: Stored in {$path} -->\n";
        }
        $out .= ob_get_clean();
        if ($this->showPathFile) {
            $out .= "\n<!-- [Layout] - End file: Stored in {$path} -->";
        }

        return $out;
    }
}

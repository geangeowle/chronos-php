<?php

namespace Chronos\Views\Render;

use Chronos\Chronos;
use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;
use Chronos\Views\BaseRender;
use Chronos\Views\Form;

class RenderTwig implements BaseRender
{
    private $params = [];
    private $viewVars = [];
    private $layout = '';

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

        $loader = new \Twig_Loader_Filesystem([$pathCore, $pathApp]);
        $twig = new \Twig_Environment($loader, ['debug' => true]);
        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addGlobal('Form', new Form());

        return $twig->render($action.'.html', $this->viewVars);
    }
}

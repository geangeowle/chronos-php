<?php

namespace Chronos\Views\Render;

use Chronos\Utils\Configure;
use Chronos\Views\BaseRender;
use Chronos\Views\Form;

class RenderTwig implements BaseRender
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
        $this->viewVars['title'] = 'ChronosPHP';
        pr($this->viewVars);

        $viewPath = 'Page';
        $action = 'Page/index';

        $pathApp = Configure::read('App.Path');
        $pathCore = Configure::read('Chronos.Path');
        $pathViewFile = '/Views/'; //.$viewPath.'/'; //.$action.'.php';

        $pathApp = $pathApp.$pathViewFile;
        $pathCore = $pathCore.$pathViewFile;

        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;

        $loader = new \Twig_Loader_Filesystem([$pathCore, $pathApp]);
        $twig = new \Twig_Environment($loader, ['debug' => true]);
        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addGlobal('Form', new Form());

        return $twig->render($action.'.html', $this->viewVars);
    }
}

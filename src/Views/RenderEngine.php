<?php

namespace Chronos\Views;

use Chronos\Base\App;
use Chronos\Utils\Configure;

class RenderEngine extends App
{
    public $viewVars = [];

    public function renderLayout()
    {
        $pageTitle = 'ChronosPHP';
        $content_for_layout = $this->getRenderMethod();

        return $content_for_layout;
        $data_for_layout = array_merge($this->viewVars, [
            'title_for_layout' => $pageTitle,
            'content_for_layout' => $content_for_layout,
        ]);

        $viewPath = 'Layouts';
        $action = 'Layouts/default_twig';
        $pathApp = Configure::read('App.Path');
        $pathCore = Configure::read('Chronos.Path');
        $pathViewFile = '/Views/'; //.$viewPath.'/'; //.$action.'.php';

        $pathApp = $pathApp.$pathViewFile;
        $pathCore = $pathCore.$pathViewFile;

        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;

        $loader = new \Twig_Loader_Filesystem([$pathCore, $pathApp]);
        $twig = new \Twig_Environment($loader);
        $this->output = $twig->render($action.'.html', $data_for_layout);

        return $this->output;
    }

    public function getRenderMethod()
    {
        $viewPath = 'Page';
        $action = 'Page/index';
        $pathApp = Configure::read('App.Path');
        $pathCore = Configure::read('Chronos.Path');
        $pathViewFile = '/Views/'; //.$viewPath.'/'; //.$action.'.php';

        $pathApp = $pathApp.$pathViewFile;
        $pathCore = $pathCore.$pathViewFile;

        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;

        $loader = new \Twig_Loader_Filesystem([$pathCore, $pathApp]);
        $twig = new \Twig_Environment($loader);
        $this->output = $twig->render($action.'.html', ['title' => 'ChronosPHP']);

        return $this->output;
    }
}

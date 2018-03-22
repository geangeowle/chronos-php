<?php

namespace Chronos\Views;

use Chronos\Base\App;
use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

class View extends App
{
    public $autoLayout = true;
    public $viewPath;
    public $viewVars = [];
    public $pageTitle = '';
    private $layout = 'default';
    private $output;
    private $renderEngine = 'default';

    public function __construct($controller)
    {
        if (is_object($controller)) {
            $params = $controller->getParams();
            $this->viewPath = $controller->viewPath;
            $this->viewVars = $controller->viewVars;
            $this->action = Inflector::underscore($params['url']['action']);
            $this->params = $params;
            $this->pageTitle = $controller->pageTitle;
            $this->setLayout($controller->getLayout());
        }
    }

    public function setLayout($newLayout)
    {
        $this->layout = $newLayout;
    }

    public function render($action = null)
    {
        $out = null;

        $this->viewVars['title'] = $this->pageTitle;

        $dsRender = '\\Chronos\\Views\\Render\\Render'.Configure::read('App.RenderEngine');
        $objRenderEngine = new Engine(new $dsRender());
        $objRenderEngine->setParams($this->params);
        $objRenderEngine->setViewVars($this->viewVars);
        $out = $objRenderEngine->render();
        //$out = $objRenderEngine->renderLayout();

        return $out;
        if (false !== $action) {
            $out = $this->renderFile($this->getViewFileName($action), $this->viewVars);
        }

        if (false !== $out) {
            if ($this->autoLayout) {
                $out = $this->renderLayout($out, $this->layout);
            }
        }

        return $out;
    }

    public function renderLayout($content_for_layout, $layout = null)
    {
        $layoutFileName = $this->getLayoutFileName($layout);
        // if (empty($layoutFileName)) {
        //     return $this->output;
        // }

        if (!empty($this->pageTitle)) {
            //$pageTitle = 'APP_TITLE'.': '.$this->pageTitle;
            $pageTitle = $this->pageTitle;
        } else {
            $pageTitle = 'APP_TITLE'.': '.Inflector::humanize($this->viewPath);
        }

        $data_for_layout = array_merge($this->viewVars, [
            'title_for_layout' => $pageTitle,
            'content_for_layout' => $content_for_layout,
        ]);

        $this->output = $this->renderFile($layoutFileName, $data_for_layout);

        return $this->output;
    }

    private function getViewFileName($action = null)
    {
        $action = Inflector::underscore($action);
        $viewPath = Inflector::camelize($this->viewPath);

        $pathApp = Configure::read('App.Path');
        $pathCore = Configure::read('Chronos.Path');
        $pathViewFile = '/Views/'.$viewPath.'/'.$action.'.php';

        $pathApp = $pathApp.$pathViewFile;
        $pathCore = $pathCore.$pathViewFile;

        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;

        return $path;
    }

    private function getLayoutFileName($action = null)
    {
        $action = Inflector::underscore($action);

        $pathApp = Configure::read('App.Path');
        $pathCore = Configure::read('Chronos.Path');
        $pathViewFile = '/Views/Layouts/'.$action.'.php';

        $pathApp = $pathApp.$pathViewFile;
        $pathCore = $pathCore.$pathViewFile;

        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;

        return $path;
    }

    private function renderFile($___viewFn, $___dataForView)
    {
        extract($___dataForView, EXTR_SKIP);
        ob_start();

        include $___viewFn;

        $out = '';
        $out .= "<!-- Start file: Stored in {$___viewFn} -->\n";
        $out .= ob_get_clean();
        $out .= "\n<!-- End file: Stored in {$___viewFn} -->";

        return $out;
    }
}

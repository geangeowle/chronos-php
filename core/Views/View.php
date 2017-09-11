<?php

namespace Chronos\Views;

use Chronos\Base\App;
use Chronos\Utils\Inflector;

class View extends App
{
    public $autoLayout = true;
    public $viewPath;
    public $viewVars = [];
    public $layout = 'default';
    public $pageTitle = '';

    public function __construct($controller)
    {
        if (is_object($controller)) {
            $this->viewPath = $controller->viewPath;
            $this->action = Inflector::underscore($controller->params['params']['action']);
            $this->params = $controller->params;
            $this->pageTitle = $controller->pageTitle;
            if (isset($controller->layout)) {
                $this->layout = $controller->layout;
            }
            $this->setConfig($controller->getConfig());
        }
    }

    public function render($action = null, $layout = null, $file = null)
    {
        $out = null;

        if ($action !== false && $viewFileName = $this->_getViewFileName($action)) {
            $out = $this->_render($viewFileName, $this->viewVars);
        }

        if ($layout === null) {
            $layout = $this->layout;
        }

        if ($out !== false) {
            if ($layout && $this->autoLayout) {
                $out = $this->renderLayout($out, $layout);
            }
        }

        return $out;
    }

    public function _render($___viewFn, $___dataForView)
    {
        extract($___dataForView, EXTR_SKIP);
        ob_start();

        include $___viewFn;

        $out = '';
        $out .= "<!-- Start file: {$___viewFn} -->\n";
        $out .= ob_get_clean();
        $out .= "\n<!-- End file: {$___viewFn} -->";

        return $out;
    }

    public function renderLayout($content_for_layout, $layout = null)
    {
        $layoutFileName = $this->_getLayoutFileName($layout);
        if (empty($layoutFileName)) {
            return $this->output;
        }

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

        $this->output = $this->_render($layoutFileName, $data_for_layout);

        return $this->output;
    }

    public function _getViewFileName($action = null)
    {
        $action = Inflector::underscore($action);
        $viewPath = Inflector::camelize($this->viewPath);
        $appConfig = $this->getConfig();
        $pathCore = $appConfig['CHRONOS_PATH'].'/Views/'.$viewPath.'/'.$action.'.php';
        $pathApp = $appConfig['APP_PATH'].'/Views/'.$viewPath.'/'.$action.'.php';
        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;

        return $path;
    }

    public function _getLayoutFileName($action = null)
    {
        $action = Inflector::underscore($action);
        $appConfig = $this->getConfig();
        $pathCore = $appConfig['CHRONOS_PATH'].'/Views/Layouts/'.$action.'.php';
        $pathApp = $appConfig['APP_PATH'].'/Views/Layouts/'.$action.'.php';
        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;

        return $path;
    }
}

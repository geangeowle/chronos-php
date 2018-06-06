<?php

namespace Chronos\Views;

use Chronos\Base\App;
use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

class View extends App
{
    public $autoLayout = true;
    public $viewVars = [];
    public $pageTitle = '';
    protected $controller;
    protected $action;
    private $layout = 'default';
    private $viewPath = '';
    private $output;
    private $renderEngine = 'default';

    public function __construct($controller)
    {
        if (is_object($controller)) {
            $params = $controller->getParams();
            $this->viewVars = $controller->viewVars;
            $this->layout = $controller->getLayout();
            $this->controller = $controller;
            $this->action = Inflector::underscore($params['url']['action']);
            $this->params = $params;
            $this->pageTitle = $controller->pageTitle;
            $this->setLayout($controller->getLayout());
            $this->setViewPath($controller->getViewPath());
        }
    }

    public function setLayout($newLayout)
    {
        $this->layout = $newLayout;
    }

    public function setViewPath($newViewPath)
    {
        $this->viewPath = $newViewPath;
    }

    public function render($action = null)
    {
        $out = null;

        $this->viewVars['title'] = $this->pageTitle;

        $dsClassRender = Configure::read('Chronos.RenderEngine');
        $namespace = Inflector::camelize($this->params['url']['namespace']);
        if (!empty(Configure::read($namespace.'.RenderEngine'))) {
            $dsClassRender = Configure::read($namespace.'.RenderEngine');
        }

        $engine = '\\Chronos\\Views\\Render\\Render'.$dsClassRender;
        $renderEngine = new $engine($this->controller, $this->action);

        $objRenderEngine = new Engine($renderEngine);
        $objRenderEngine->setParams($this->params);
        $objRenderEngine->setViewVars($this->viewVars);
        $objRenderEngine->setLayout($this->layout);
        $objRenderEngine->setViewPath($this->viewPath);
        $out = $objRenderEngine->render();
        //$out = $objRenderEngine->renderLayout();

        return $out;
    }
}

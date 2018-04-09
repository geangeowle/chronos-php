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
            $this->layout = $controller->getLayout();
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

        $dsClassRender = Configure::read('Chronos.RenderEngine');
        $namespace = Inflector::camelize($this->params['url']['namespace']);
        if (!empty(Configure::read($namespace.'.RenderEngine'))) {
            $dsClassRender = Configure::read($namespace.'.RenderEngine');
        }

        $dsRender = '\\Chronos\\Views\\Render\\Render'.$dsClassRender;

        $objRenderEngine = new Engine(new $dsRender());
        $objRenderEngine->setParams($this->params);
        $objRenderEngine->setViewVars($this->viewVars);
        $objRenderEngine->setLayout($this->layout);
        $out = $objRenderEngine->render();
        //$out = $objRenderEngine->renderLayout();

        return $out;
    }
}

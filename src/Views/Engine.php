<?php

namespace Chronos\Views;

class Engine
{
    private $viewVars = [];
    private $params = [];
    private $layout = '';
    private $viewPath = '';
    private $objRender;

    public function __construct(BaseRender $render)
    {
        $this->objRender = $render;
    }

    public function setViewVars($viewVars)
    {
        $this->viewVars = $viewVars;
        $this->viewVars['PHP_VERSION'] = PHP_VERSION;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    public function render()
    {
        $out = '';
        $this->objRender->setParams($this->params);
        $this->objRender->setViewVars($this->viewVars);
        $this->objRender->setLayout($this->layout);
        $this->objRender->setViewPath($this->viewPath);
        $out = $this->objRender->render();

        return $out;
    }
}

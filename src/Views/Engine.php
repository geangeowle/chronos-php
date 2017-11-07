<?php

namespace Chronos\Views;

class Engine
{
    private $viewVars = [];
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

    public function render()
    {
        $out = '';
        $this->objRender->setViewVars($this->viewVars);
        $out = $this->objRender->render();

        return $out;
    }
}

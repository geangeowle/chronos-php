<?php

namespace Chronos\Views;

interface BaseRender
{
    public function render();

    public function setViewVars($viewVars);
    
    public function setViewPath($viewPath);

    public function setParams($params);

    public function setLayout($layout);

}

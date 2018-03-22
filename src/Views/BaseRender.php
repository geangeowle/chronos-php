<?php

namespace Chronos\Views;

interface BaseRender
{
    public function render();

    public function setViewVars($viewVars);

    public function setParams($params);
}

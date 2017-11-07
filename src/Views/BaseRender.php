<?php

namespace Chronos\Views;

interface BaseRender
{
    public function render();

    public function setViewVars($viewVars);
}

<?php

namespace Chronos\Base;

class BaseObject
{
    private $appConfig = [];

    public function setConfig($newAppConfig = [])
    {
        $this->appConfig = $newAppConfig;
    }

    public function getConfig()
    {
        return $this->appConfig;
    }
}

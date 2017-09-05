<?php

namespace Chronos\Base;

use Chronos\Utils\Inflector;

class App extends BaseObject
{
    public function import($type, $file)
    {
        $nameFile = Inflector::camelize($file.'_controller');
        $appConfig = $this->getConfig();
        $pathCore = $appConfig['CHRONOS_PATH']."/Controllers/{$nameFile}.php";
        $pathApp = $appConfig['APP_PATH']."/Controllers/{$nameFile}.php";
        $path = (file_exists($pathApp)) ? $pathApp : $pathCore;

        $statusImport = false;
        if (file_exists($path)) {
            require_once $path;
            $statusImport = true;
        }

        return $statusImport;
    }

    public function dispatchMethod($method, $params = [])
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([
                &$this,
                $method,
            ], $params);
        }
        // $name = down($this->name);
        // $this->redirect(URL_FULL_APP . "/error/missingMethod/{$name}/{$method}/");
    }
}

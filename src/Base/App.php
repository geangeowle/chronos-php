<?php

namespace Chronos\Base;

use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

class App extends BaseObject
{
    public function import($type, $file)
    {
        $paths = [
            'Model' => [
                'folder' => 'Models',
                'alias' => '_model',
            ],
            'Controller' => [
                'folder' => 'Controllers',
                'alias' => '_controller',
            ],
        ];

        $nameFile = Inflector::camelize($file.$paths[$type]['alias']);
        $pathApp = Configure::read('App.Path').'/'.$paths[$type]['folder']."/{$nameFile}.php";
        $pathCore = Configure::read('Chronos.Path').'/'.$paths[$type]['folder']."/{$nameFile}.php";

        $baseNamespace = 'Chronos\\';
        $path = $pathCore;
        if (file_exists($pathApp)) {
            $baseNamespace = 'App\\';
            $path = $pathApp;
        }

        // pr($path);

        $statusImport = false;
        //if (file_exists($path)) {
        require_once $path;
        $statusImport = true;
        //}
        $dsNamespace = $baseNamespace.$paths[$type]['folder'];

        return $dsNamespace;
    }

    public function dispatchMethod($method, $params = [])
    {
        if (is_callable([$this, $method])) {
            return call_user_func_array([&$this, $method], $params);
        }
        $name = $this->name; //down($this->name);
        $this->redirect("http://localhost:8056/public/?url=error/missingMethod/{$name}/{$method}/");
    }

    public function redirect($url)
    {
        header('Location: '.$url);
    }
}

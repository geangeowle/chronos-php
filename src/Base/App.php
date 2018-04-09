<?php

namespace Chronos\Base;

use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

class App extends BaseObject
{
    public function import($type, $file, $namespace)
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

        $namespace = Inflector::camelize($namespace);
        $nameFile = Inflector::camelize($file.$paths[$type]['alias']);
        $pathApp = Configure::read($namespace.'.Path').'/'.$paths[$type]['folder']."/{$nameFile}.php";
        $pathCore = Configure::read('Chronos.Path').'/'.$paths[$type]['folder']."/{$nameFile}.php";

        // pr($pathApp);
        // pr($pathCore);

        $baseNamespace = 'Chronos\\';
        $path = $pathCore;
        if (file_exists($pathApp)) {
            $baseNamespace = Configure::read($namespace.'.Namespace').'\\';
            $path = $pathApp;
        }

        $statusImport = false;
        if (is_file($path)) {
            require_once $path;
            $statusImport = true;
        }

        // pr($baseNamespace);

        $dsNamespace = $baseNamespace.$paths[$type]['folder'];

        return $dsNamespace;
    }

    public function dispatchMethod($method, $params = [])
    {
        if (is_callable([$this, $method])) {
            return call_user_func_array([&$this, $method], $params);
        }
        $name = $this->name; //down($this->name);
        // die('missingMethod');
        // $this->redirect("http://localhost:8056/public/?url=error/missingMethod/{$name}/{$method}/");
    }

    public function redirect($url)
    {
        header('Location: '.$url);
    }
}

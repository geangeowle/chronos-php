<?php

namespace Chronos\Views\Render;

use Chronos\Chronos;
use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

class Render
{
    protected $controller;
    protected $action;
    protected $params = [];
    protected $viewVars = [];
    protected $layout = '';
    protected $showPathFile = false;
    protected $viewPath = '';
    protected $extension;

    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    public function setViewVars($viewVars)
    {
        $this->viewVars = $viewVars;
    }

    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function boot()
    {
        $namespace = Inflector::camelize($this->params['url']['namespace']);
        $pathApp = Configure::read($namespace.'.Path');
        $pathCore = Configure::read('Chronos.Path');
        $fileName = '';
        $pathViewsFolder = DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR;
        $pathApp .= $pathViewsFolder;
        $pathCore .= $pathViewsFolder;
        $pathLayout = $pathApp.'Layouts';

        if (Chronos::CAMELCASE === Configure::read($namespace.'.View.Folder')) {
            $pathActionFolder = Inflector::camelize($this->params['url']['controller']);
        }
        if (Chronos::UNDERSCORE === Configure::read($namespace.'.View.Folder')) {
            $pathActionFolder = Inflector::underscore($this->params['url']['controller']);
        }

        if (Chronos::CAMELCASE === Configure::read($namespace.'.View.File')) {
            $fileName = Inflector::camelize($this->params['url']['action']);
        }
        if (Chronos::UNDERSCORE === Configure::read($namespace.'.View.File')) {
            $fileName = Inflector::underscore($this->params['url']['action']);
        }

        if (empty(Configure::read($namespace.'.Path'))) {
            trigger_error('Missing settings on Configure::read(\''.$namespace.'\').'.PHP_EOL, E_USER_ERROR);
        }

        $pathLayoutFile = $pathLayout.DIRECTORY_SEPARATOR."{$this->layout}.{$this->extension}";
        $pathActionFile = $pathApp.$pathActionFolder.DIRECTORY_SEPARATOR.$fileName.'.'.$this->extension;

        $config = compact(
            'pathApp', // /var/www/app-folder/Views/
            'pathActionFolder', // controller-folder
            'pathActionFile', // /var/www/app-folder/Views/controller-folder/action-file.html
            'pathLayoutFile' // /var/www/app-folder/Views/Layouts/layout-file.html
        );

        // missing class
        if (($this->controller instanceof \Chronos\Controllers\ErrorController)) {
            $this->stopAndDisplayError($pathCore, 'Error/missing-class.php');
        }

        // missing method
        if (!is_callable([$this->controller, $this->action])) {
            // pass variables to views
            $this->viewVars['controller'] = get_class($this->controller);
            $this->viewVars['action'] = $this->action;
            $this->stopAndDisplayError($pathCore, 'Error/missing-method.php');
        }

        // missing template file
        if (!file_exists($pathLayoutFile)) {
            $this->viewVars['file'] = $pathLayoutFile;
            $this->stopAndDisplayError($pathCore, 'Error/missing-file.php');
        }

        // missing action file
        if (!file_exists($pathActionFile)) {
            $this->viewVars['file'] = $pathActionFile;
            $this->stopAndDisplayError($pathCore, 'Error/missing-file.php');
        }

        return $config;
    }

    private function stopAndDisplayError($pathCore, $pathError)
    {
        // define variables related to paths and files location
        $pathLayout = $pathCore.DIRECTORY_SEPARATOR.'Layouts';
        $pathLayout .= DIRECTORY_SEPARATOR.'default_error.php';
        $pathError = $pathCore.DIRECTORY_SEPARATOR.$pathError;

        // Extracts the variables defined previously into the view file
        extract($this->viewVars, EXTR_SKIP);

        // Render an error file using the memory buffer and stores
        // the result into a content variable
        ob_start();
        require $pathError;
        $content = ob_get_clean();
        $viewVars = array_merge($this->viewVars, [
            'title_for_layout' => $this->viewVars['title'],
            'content_for_layout' => $content,
        ]);

        // Extracts the variables defined previously into the layout file
        // now the viewVars array also contains a reference to a file
        // contents
        extract($viewVars, EXTR_SKIP);

        // Render an error template file using the memory buffer and
        // stores the result into a content variable
        ob_start();
        require $pathLayout;
        $content = ob_get_clean();

        // Because its an error so stop the programs execution
        exit($content);
    }
}

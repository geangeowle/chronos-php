<?php

namespace Chronos\Controllers;

use Chronos\Http\Router;
use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

final class ErrorController extends BaseController
{
    public $name = 'Error';
    public $pageTitle = 'ChronosPHP Error';

    public function initialize()
    {
        //$this->Page = new PageModel();
        $this->setLayout('default_error');
    }

    public function index()
    {
        $this->set('varX', 'dataX');
    }

    public function missingClass($className, $url)
    {
        $dsParams = Router::parse(str_replace('\\', '/', $url), false);
        $dsPathNamespace = Configure::read(Inflector::camelize($dsParams['url']['namespace']).'.Path');
        $this->set('dsNamespace', $dsParams['url']['namespace']);
        $this->set('dsPathNamespace', $dsPathNamespace);
        $this->set('dsPath', $dsPathNamespace);
        $this->set('dsClassName', $className);
    }

    public function missingMethod($methodName = '')
    {
    }
}

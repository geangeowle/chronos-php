<?php

namespace Chronos\Views\Render;

use Chronos\Chronos;
use Chronos\Session\Session;
use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;
use Chronos\Utils\Input;
use Chronos\Views\BaseRender;
use Chronos\Views\Form;

class RenderTwig extends Render implements BaseRender
{
    protected $extension = 'html';

    public function render()
    {
        $config = parent::boot();
        $pathApp = $config['pathApp'];
        $actionFolder = $config['pathActionFolder'];
        $actionFile = basename($config['pathActionFile']);
        $renderAction = $actionFolder.DIRECTORY_SEPARATOR.$actionFile;

        $loader = new \Twig_Loader_Filesystem([$pathApp]);
        $twig = new \Twig_Environment($loader, ['debug' => true]);
        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addGlobal('Form', new Form());
        $twig->addGlobal('Input', new Input());
        $twig->addGlobal('Session', new Session());

        return $twig->render($renderAction, $this->viewVars);
    }
}

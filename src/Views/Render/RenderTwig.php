<?php

namespace Chronos\Views\Render;

use Chronos\Session\Session;
use Chronos\Utils\Cookie;
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
        $twig->addExtension(new \Twig_Extensions_Extension_Text());
        $twig->addGlobal('Form', new Form());
        $twig->addGlobal('Input', new Input());
        $twig->addGlobal('Session', new Session());
        $twig->addGlobal('Cookie', new Cookie());

        return $twig->render($renderAction, $this->viewVars);
    }
}

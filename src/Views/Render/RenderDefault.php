<?php

namespace Chronos\Views\Render;

use Chronos\Session\Session;
use Chronos\Utils\Cookie;
use Chronos\Utils\Input;
use Chronos\Views\BaseRender;
use Chronos\Views\Form;

class RenderDefault extends Render implements BaseRender
{
    protected $extension = 'php';

    public function render()
    {
        $config = parent::boot();
        $pathLayoutFile = $config['pathLayoutFile'];
        $pathActionFile = $config['pathActionFile'];
        $content = $this->renderFile($pathActionFile);

        return $this->renderLayout($content, $pathLayoutFile);
    }

    protected function renderFile($path)
    {
        extract($this->viewVars, EXTR_SKIP);

        $content = '';

        ob_start();

        $Form = new Form();
        $Session = new Session();
        $Cookie = new Cookie();
        $Input = new Input();

        require $path;

        if ($this->showPathFile) {
            $content .= "<!-- [File] - Start file: Stored in {$path} -->\n";
        }

        $content .= ob_get_clean();

        if ($this->showPathFile) {
            $content .= "\n<!-- [File] - End file: Stored in {$path} -->";
        }

        return $content;
    }

    protected function renderLayout($content, $path)
    {
        $viewVars = array_merge($this->viewVars, [
            'title_for_layout' => $this->viewVars['title'],
            'content_for_layout' => $content,
        ]);

        extract($viewVars, EXTR_SKIP);
        ob_start();

        $Form = new Form();
        $Session = new Session();
        $Cookie = new Cookie();
        $Input = new Input();

        require $path;

        $out = '';

        if ($this->showPathFile) {
            $out .= "<!-- [Layout] - Start file: Stored in {$path} -->\n";
        }

        $out .= ob_get_clean();

        if ($this->showPathFile) {
            $out .= "\n<!-- [Layout] - End file: Stored in {$path} -->";
        }

        return $out;
    }
}

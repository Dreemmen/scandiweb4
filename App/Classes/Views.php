<?php
declare(strict_types = 1);

namespace App\Classes;

use App\Exceptions\ViewNotFound;

class Views{
    private $view;
    public array $params;

    public function __construct(string $view, array $params = []){
        $this->view = $view;
        $this->params = $params;
    }

    public function renderLayout(): string{
        return $this->renderPart('head') . $this->renderPart($this->view) . $this->renderPart('foot');
    }

    public function renderPart($template_path): string{

        $viewPath = VIEW_PATH . '/' . $template_path . '.php';

        if(file_exists($viewPath)){
            //start buffer
            ob_start();

            //file to be outputed to buffer
            include $viewPath;

            //get buffer value and clear buffer
            return (string) ob_get_clean();
        }else{
            //throw exception
            throw new ViewNotFound();
        }
    }
}
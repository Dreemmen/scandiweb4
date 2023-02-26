<?php
declare(strict_types = 1);

namespace App\Controllers;

use App\Classes\Views;

class Page404Controller{
    public function index(): string{
        // $View = new View('add-product/index');
        // return $View->render();
    return '404';
    }
}
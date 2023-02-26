<?php
declare(strict_types = 1);

namespace App\Controllers;

use App\Classes\Application;
use App\Classes\Views;
use App\Models\Product;
use App\Models\Products;

class HomeController{
    //$params are generated from global $_POST, $_GET
    public function index($params): string{
        $products_handler = new Products();
        $products_handler->select();
        $params['products'] = $products_handler->all;

                
        $View = new Views('home/index', $params);
        return $View->renderLayout();
    }
    public function delete($params): void{
        if(isset($params['to_delete'])){
            $products_handler = new Products();
            $products_handler->delete($params['to_delete']);
        }
        header("Location: \\");
        exit();
    }
}
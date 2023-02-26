<?php
declare(strict_types = 1);

namespace App\Controllers;

use App\Classes\Views;
use App\Classes\Application;
use App\Models\Categories;
use App\Models\Product;

class AddproductController{
    //$params are generated from global $_POST, $_GET
    public function index($params): string{
        $categories_handler = new Categories();
        $categories_handler->select();
        $params['categories'] = $categories_handler->all;
        
        $View = new Views('add-product/index', $params);
        return $View->renderLayout();
    }
    public function create($params): string{
        $product_handler = new Product();
        if($product_handler->create($params)) {
            header("Location: \\");
            exit();
            return $this->index($params);
        }else{
            $params['warnings'] = $product_handler->nonValid;
            return $this->index($params);
        }
        return '';
    }
}
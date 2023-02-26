<?php
declare(strict_types = 1);

namespace App\Models;

use App\Models\Product;
use App\Models\Model;

class Products extends Model {
    public array $all;
    
    public function __construct(){
        $this->all = [];
        parent::__construct();
    }

    public function select($filter = []): void{
        //db object
        //db special querry
        $data = $this->db->select('products', $filter);
        $i = 0;
        if($data) foreach($data as $product){
            $this->all[$i] = new Product();
            $this->all[$i]->populate([
                'id' => $product['id'],
                'sku' => $product['sku'],
                'price' => $product['price'],
                'name' => $product['name'],
                'parameters' => $product['parameters'],
                'parameters_value' => $product['parameters_value']
            ]);
            $i++;
        }
    }
    public function delete($to_delete): void{
        //db querry
        var_dump($to_delete);
        $this->db->delete('products', $to_delete);
    }
}
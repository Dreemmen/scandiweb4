<?php
declare(strict_types = 1);

namespace App\Models;

use App\Models\Model;

class Categories extends Model {
    public array $all;
    
    public function select($filter = []): void{
        //db object
        $data = $this->db->select('categories', $filter);
        foreach($data as $cat){
            $this->all[] = ['id' => $cat['id'], 'name' => $cat['name'], 'description' => $cat['description']];
        }
    }
}
<?php
declare(strict_types = 1);

namespace App\Models;

use App\Models\Model;

class Product extends Model {
    private $id;
    private $sku;
    private $name;
    private $price;
    private $productType;
    private $parameters;
    private $parameters_value;

    public array $nonValid;
    
    public function create($params): bool{

        if($this->validate($params)){
            //special parsing for parameters, fist array is keys in jsnon, second array are values joined by 'x'
            [$parameters, $parameters_value] = $this->validateParameters($params['parameters']);
            //db insert querry
            $this->db->insert('products', [
                'sku' => $params['sku'],
                'name' => $params['name'],
                'price' => $params['price'],
                'productType' => $params['productType'],
                'parameters' => $parameters,
                'parameters_value' => $parameters_value
            ]);
            return true;
        }else{
            return false;
        }

    }
    public function populate($params): void{
        if(isset($params['id'])) $this->setId($params['id']);
        if(isset($params['sku'])) $this->setSku($params['sku']);
        if(isset($params['name'])) $this->setName($params['name']);
        if(isset($params['price'])) $this->setPrice($params['price']);
        if(isset($params['productType'])) $this->setProductType($params['productType']);
        if(isset($params['parameters'])) $this->setParameters($params['parameters']);
        if(isset($params['parameters_value'])) $this->setParameters_value($params['parameters_value']);
    }
    public function delete($params): void{

    }
    public function validate($params): bool{
        if(empty($params['sku'])){ 
            $this->nonValid['sku'] = 'Required. Please, provide valid SKU.'; 
        }else if( $this->db->select('products', ['sku' => $params['sku']]) ){ 
            $this->nonValid['sku'] = 'Provided SKU value already exists.'; 
        }
        if(empty($params['name'])){ 
            $this->nonValid['name'] = 'Required. Please, provide valid name.'; 
        }
        if(empty($params['price']) || !is_numeric($params['price']) || $params['price'] < 0 ){ 
            $this->nonValid['price'] = 'Required. Please, provide valid price.'; 
        }
        if(empty($params['productType'])){ 
            $this->nonValid['productType'] = 'Required. Please, select valid product type.'; 
        }
        //special case for parameters
        if(is_array($params['parameters'])){
            foreach($params['parameters'] as $key => $val){
                if(empty($val)){ 
                    $this->nonValid['parameters'][$key] = 'Required. Please, provide product specifics.'; 
                }
            }
        }
        return (empty($this->nonValid))? true : false;
    }
    public function validateParameters($parameters): array{
        $parameters = array_filter($parameters);
        return [json_encode(array_keys($parameters)), join('x', $parameters)];
    }
    public function setId($param){
        $this->id = $param;
    }
    public function getId(){
        return $this->id;
    }
    public function setSku($param){
        $this->sku = $param;
    }
    public function getSku(){
        return $this->sku;
    }
    public function setName($param){
        $this->name = $param;
    }
    public function getName(){
        return $this->name;
    }
    public function setPrice($param){
        $this->price = $param;
    }
    public function getPrice(){
        return $this->price;
    }
    public function setProductType($param){
        $this->productType = $param;
    }
    public function getProductType(){
        return $this->productType;
    }
    public function setParameters($param){
        $this->parameters = $param;
    }
    public function getParameters(){
        return $this->parameters;
    }
    public function setParameters_value($param){
        $this->parameters_value = $param;
    }
    public function getParameters_value(){
        return $this->parameters_value;
    }
}
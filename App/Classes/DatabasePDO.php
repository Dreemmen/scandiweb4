<?php

namespace App\Classes;

use \PDO;

class DatabasePDO extends PDO {
    
    public function __construct($host, $username = NULL, $password = NULL, $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]){

        parent::__construct($host, $username, $password, $options);
    }
    public function select($table, $where_array = [], $options = []){
        //bulding Where clause for item filtering
        $where_clause = (!empty($where_array))?' WHERE ':'';
        $execute_array = [];

        //building query string, adding where clauses. for single item and many items
        // may be flawed, need give it to pen tester
        if(count($where_array) == 1){
            $key = array_key_first($where_array);
            $where_clause .= '`'. $key .'` = :'. $key;
            $execute_array[':'.$key] = $where_array[$key];
        }else if(count($where_array) > 1){

        }
        
        //$table is inner code variable, so its safe to include in querry direcly
        $stmt = $this->prepare("SELECT * FROM `".$table."`".$where_clause);
        $stmt->execute($execute_array);
        
        return $stmt->fetchAll();
    }

    public function insert($table, $values_array = []){
        if(empty($values_array)) return false;
        //bulding Where clause for item filtering
        $column_names = '';
        $value_placeholder = '';
        $execute_array = [];

        foreach($values_array as $field => $value){
            $column_names .= '`'. $field .'`,';
            $value_placeholder .= ":".$field.",";
            $execute_array[':'.$field] = $value;
        }
        $column_names = rtrim($column_names, ',');
        $value_placeholder = rtrim($value_placeholder, ',');

        //$table is inner code variable, so its safe to include in querry direcly
        $stmt = $this->prepare("INSERT INTO `".$table."` (".$column_names.") VALUES (".$value_placeholder.")");
        $stmt->execute($execute_array);
        
        return $stmt->fetchAll();
    }
    public function delete($table, $delete_array = []){
        foreach($delete_array as $index => $id){
            if(!is_numeric($id)) unset($delete_array[$index]);
        }
        if(empty($delete_array)) return;
        $q_marks = str_repeat('?,', count($delete_array) - 1) . '?';

        //$table is inner code variable, so its safe to include in querry direcly
        $stmt = $this->prepare("DELETE FROM `".$table."` WHERE `id` IN ( ".$q_marks." )");
        $stmt->execute($delete_array);
    }
}
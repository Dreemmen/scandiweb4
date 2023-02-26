<?php
declare(strict_types = 1);

namespace App\Classes;

use App\Classes\DatabasePDO;

class Application{
    protected Router $router;
    protected array $request;
    protected array $db_config;
    private static DatabasePDO $db;

    public function __construct(\App\Classes\Router $router, array $request, array $db_config){
        $this->router = $router;
        $this->request = $request;
        $this->db_config = $db_config;

        try{
            static::$db = new DatabasePDO('mysql:host='.$db_config['DB_HOST'].';port='.$db_config['DB_PORT'].';dbname='.$db_config['DB_DATABASE'], $db_config['DB_USER'], $db_config['DB_PASS']);
            
        }catch(\PDOException $e){
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public function run($uri = '', $method = ''){
        if(empty($uri)) $uri = $this->request['uri'];
        if(empty($method)) $method = $this->request['method'];
        try{
            //ECHO handler/controller for matching path, all consecutive methods should return text
            // this generates html content futher in views
            echo $this->router->resolve($uri, $method);
        }catch(\Exception $e){
            // Handle the general case
            throw new \Exception( 'Unable to resolve router path',0,$e);
        }
    }
    public static function db(): DatabasePDO{
        //its static, so only 1 isntance of db across whole project
        return static::$db;
    }
}
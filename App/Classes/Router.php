<?php
declare(strict_types=1);

namespace App\Classes;

use App\Exceptions\RouteNotFound;

class Router {
    private array $handlers;
    
    public function addHandler(string $method, string $path, $handler): void{
        //remove trailing slash; keeps same, if othervise empty
        $path = (!empty(rtrim($path, '/')))? rtrim($path, '/') : $path;
        //$handler may be array of class and method; or callable
        $this->handlers[$method][$path] = $handler;
    }

    public function get(string $path, $handler): void{
        
        $this->addHandler('GET', $path, $handler);
    }

    public function post(string $path, $handler): void{
        
        $this->addHandler('POST', $path, $handler);
    }

    public function resolve($requestUri, $server_method){

        //first parse request uri, then get 'path' value from it
        $requestPath = parse_url($requestUri);
        if($requestPath){ $requestPath = $requestPath['path']; }
        $callback = null;

        //match method and path to registered handler
        if(isset($this->handlers[$server_method][$requestPath])){
            //we are setting callable or array here
            $callback = $this->handlers[$server_method][$requestPath];
        }
        
        if(!$callback){
            //404 handling
            //Dont know why it is like that, tutorial showed so
            throw new RouteNotFound();
        }
            
        if(is_array($callback)){
            //destructure array
            [$class, $method] = $callback;

            //if class exists, call for new class (used in views controllers)
            if(class_exists($class)){
                $class = new $class();

                //call method of this class
                if(method_exists($class, $method)){
                    return call_user_func_array([$class, $method], [($server_method=='POST'?$_POST:$_GET)]);
                }
            }
        }else if(is_callable($callback)){
            //we call callback we found
            return call_user_func($callback);

        }else{
            //404 handling; no callbacks were executed
            throw new RouteNotFound();
        }
    }
}
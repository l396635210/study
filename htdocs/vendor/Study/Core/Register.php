<?php

namespace Study\Core;

class Register{

    protected $container;
    protected $parameters;

    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set($container){
        $this->container = $container;
    }

    public function get($key){
        if(isset($this->container[$key])){
            return $this->container[$key];
        }
        return null;
    }

    public function setParams($parameters){
        $this->parameters = $parameters;
    }

    public function getParam($key){
        if(isset($this->parameters[$key])){
            return $this->parameters[$key];
        }
        return null;
    }


}
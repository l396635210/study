<?php

namespace Study\Core;

class Register{

    protected $container;

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
    }
}
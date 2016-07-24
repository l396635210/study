<?php

namespace Study\Core\Security;

class CookieStorage{

    private static $instance;

    private function __construct(){}

    public static function getInstance(){
        if( !isset(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set($name, $val){
        setcookie($name, $val);
    }

    public function get($name){
        if(isset($_COOKIE[$name])){
            return $_COOKIE[$name];
        }
    }
}
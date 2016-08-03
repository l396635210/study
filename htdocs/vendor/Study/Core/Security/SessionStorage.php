<?php

namespace Study\Core\Security;

class SessionStorage{
	
	protected $sessionStarted;
	
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance(){

		if ( !isset(self::$instance) )
        {
			
            self::$instance = new self();
			
        }
		self::$instance->sessionStart();
		return self::$instance;
	}
	
	protected function sessionStart(){
		if( PHP_SESSION_NONE == session_status() ){
			session_start();
		}
		$this->sessionStarted = true;
	}
	
	public function set($name, $value){
		$_SESSION[$name] = $value;
	}
	
	public function get($name){
		if(isset($_SESSION[$name])){
			return $_SESSION[$name];
		}
	}
	
	public function has($name){
		return isset($_SESSION[$name]);
	}
	
	public function remove($name){
		if(isset($_SESSION[$name])){
			unset($_SESSION[$name]);
		}
		return $_SESSION;
	}
	
	public function destroy(){
		if($_SESSION){
			unset($_SESSION);
		}
	}
}
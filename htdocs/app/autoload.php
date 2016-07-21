<?php

class Autoload{
	protected $vendor = [];
	protected $registers;
	protected $app;
	protected $functions;
	protected static $instance;
	
	protected function register(){
		//读取注册组件列表
		if(!$this->registers){
			$ini = __DIR__.'/config/register.ini';
			$this->registers = parse_ini_file($ini);
		}
		return $this->registers;
	}
	
	protected function vendor(){
		foreach( $this->registers as $register ){
			$ini = __DIR__.'/../'.$register.'/vendor.ini';
			$this->vendor = array_merge($this->vendor, parse_ini_file($ini)); 
		}
		return $this->vendor;
	}

	protected function loadVendorClass($class){
		if(in_array($class, $this->vendor)){
			include __DIR__.'/../vendor/' . $class . '.php';
		}
	}
	
	protected function loadKernel($class){
		if(!strstr($class,'/')){
			include_once $class.'.php';
		}
		include __DIR__.'/functions.php';
	}
	
	protected function loadApp($class){
		
		if(strstr($class, 'Bundle')){
			include __DIR__.'/../src/' . $class . '.php';
			return;
		}
	}
	
	protected function loadChip($class){
		if(strstr($class, 'chip')){
			include __DIR__.'/../var/' . $class . '.php';
			return;
		}
	}
	
	protected function _autoload($class){
		$class = strtr($class, '\\', '/');
		$this->loadKernel($class);
		$this->loadApp($class);
		$this->loadVendorClass($class);
		$this->loadChip($class);
	}
	
	public function __construct( $class ){
		$register = $this->register();
		$vendor = $this->vendor();
		$this->_autoload($class);
	}
	
}

spl_autoload_register(function ($class) {
	new Autoload($class);
});
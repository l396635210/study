<?php

namespace Study\Core\Security;

use Study\Core\Register;

class Authorize {
	
	private $authors;
	protected $register;
	private static $instance;
	
	private $parseAuthors = [
		'/'		=>  '\/',
	];
	
	private function __construct(){
		$this->register = Register::getInstance();
	}
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new self();
		}
		self::$instance->config();
		return self::$instance;
	}
	
	protected function config(){
		$config = parse_ini_file($this->register->getParam('rootDir').'/../app/config/parameters.ini');
		$this->authors = $config['author'];
	}
	
	public function getAuthors(){
		return $this->authors;
	}
	
	public function parseAuthor($path){
		return '/'.strtr($path, $this->parseAuthors).'/';
	}
}
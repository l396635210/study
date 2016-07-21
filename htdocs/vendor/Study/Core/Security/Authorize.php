<?php

namespace Study\Core\Security;

class Authorize {
	
	private $authors;
	
	private static $instance;
	
	private $parseAuthors = [
		'/'		=>  '\/',
	];
	
	private function __construct(){
		
	}
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new self();
		}
		self::$instance->config();
		return self::$instance;
	}
	
	protected function config(){
		$config = parse_ini_file(__ROOT__.'/../app/config/parameters.ini');
		$this->authors = $config['author'];
	}
	
	public function getAuthors(){
		return $this->authors;
	}
	
	public function parseAuthor($path){
		return '/'.strtr($path, $this->parseAuthors).'/';
	}
}
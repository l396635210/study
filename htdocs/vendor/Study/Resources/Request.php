<?php

namespace Study\Resources;

class Request{
	private static $request;  
	protected static $post;
	protected static $get;
	
	protected function __construct($post, $get){
		self::$post = $post;
		self::$get  = $get;
	}
	
	public static function setRequest($post=null, $get=null){
		if(NULL == self::$request)
			self::$request = new self($post, $get);
		return self::$request;
	}
	
	public static function instance($post=null, $get=null){
		return self::setRequest($post, $get);
	}
	
	public function request(){
		$request['post'] = self::$post;
		$request['get']  = self::$get;
		return $request;
	}
	
	public function get($key=NULL, $val=NULL){
		if($key && $val){
			self::$get[$key] = $val;
			return self::$request;
		}
		if(array_key_exists ($key , self::$get ))
			return self::$get[$key];
		if(NULL===$key)
			return self::$get;
		
	}
	
	public function post($key=NULL){
		if(array_key_exists ($key , self::$post )){
			return self::$post[$key];
		}
			
		if(NULL===$key){
			return self::$post;
		}
			
	}
	
	public function isPost(){
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}
	
	public function isGet(){
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}
}
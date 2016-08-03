<?php

namespace Study\Core;

use Study\Core\DocParse;
use Study\Resources\Request;
use Study\Resources\StudyException;

class Router{
	protected static $routes;
	
	protected static function parseIntInfo($url, $routes){
		$preg_url = preg_replace( '/\d+/', '{id}', $url );
		$name = array_search($preg_url,$routes);

		if(!$name){
			$preg_url = preg_replace( '/\d+/', '{page}', $url );
			$name = array_search($preg_url, $routes);
		}
		return $name;
	}
	
	protected static function parseStrInfo($url, $routes){
		$preg_url = preg_replace( '/[a-zA-Z].+?/', '{name}', $url );
		$name = array_search($preg_url,$routes);
		if(!$name){
			$preg_url = preg_replace( '/[a-zA-Z].+?/', '{title}', $url );
			$name = array_search($preg_url, $routes);
		}
		return $name;
	}
	
	protected static function parseInfo($url, $routes){
		
		if(filter_var($url, FILTER_SANITIZE_NUMBER_INT)){
			$name = self::parseIntInfo($url, $routes);
		}else{
			$name = self::parseStrInfo($url, $routes);
		}
		if(!$name){
			throw new \Exception('没有找到该路由');
		}
		preg_match('/{[a-zA-Z].+?}/', $routes[$name], $attr);
		$attr = substr($attr[0],1,-1);
		preg_match ("/\d+/",$url, $val);
		Request::setRequest()->get($attr, $val[0]);
		return $name;
		
	}
	
	public static function setRoute($url, $name, $action){
		self::$routes[$name]['name']	= $name;
		self::$routes[$name]['url']	    = $url;
		self::$routes[$name]['action']  = $action;
	}
	
	public static function route($name){
		if(isset(self::$routes[$name])){
			return self::$routes[$name];
		}
	}
	
	public static function path($path){
		if(is_string($path)){
			$route = self::route($path);
		}else{
			$path[1]['{'] = '';
			$path[1]['}'] = '';
			$route = self::route($path[0]);
			$route['url'] = strtr($route['url'], $path[1]);
		}
		$rootURI = $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
		return 'http://'.$rootURI.$route['url'];
	}
	
	public static function getRouteByUrl($url){
		try{
			$routes = array_column(self::$routes, 'url', 'name');
			$name = array_search($url, $routes);
			if( !$name ){
				$name = self::parseInfo( $url, $routes );
			}
			return self::$routes[$name];
		}catch(\Exception $e){
			#$trace = explode("#",$e->getTraceAsString());
			StudyException::show($e);die;
		}
		
	}
	
	public static function routes($name=null){
		if($name=='all')
			return self::$routes;
	}
	
	public function getRoutesFromController($dir){

		$docParse = new DocParse($dir);

		$docParse->parseController();

	}
	

	
}
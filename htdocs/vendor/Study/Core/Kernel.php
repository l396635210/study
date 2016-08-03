<?php 

namespace Study\Core;

use AppBundle\Entity\User;
use Study\Resources\Debug;
use Study\Resources\StudyException;
use Study\Core\Security\SessionStorage;

class Kernel{
	
	protected $rely;
	
	protected $environment;
	protected $debug;
	protected $rootDir;
	protected $debugPackage;
	protected $startTime;
	
	public function __construct($environment,$debug){

		$this->environment = $environment;
		$this->debug 	   = $debug;
		$this->rootDir = $this->getRootDir();
		$this->register();
		if($this->debug){
			$this->startTime = microtime(true);
		}

	}

	public function get($name){
		$register = Register::getInstance();
		return $register->get($name);
	}

	public function handle($request)
    {
		return $this->handlePathInfo($request);
    }
	
	protected function handlePathInfo($request){
		
		try{
			if($this->access()){
				$router = new Router();
                $router->getRoutesFromController($this->getRootDir().'../src/');
					#var_dump($_SERVER['PATH_INFO']!='\\');
				#默认主页	
				if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO']!='/'){
					$commond = explode('/',$_SERVER['PATH_INFO'],2);
					$route = $router::getRouteByUrl('/'.$commond[1]);
				}

				$route = isset($route) ? $route : route('home');
				Debug::addDebug('route',$route);
				list($Controller, $action) = explode('@',$route['action']);
				$controller = new $Controller($this);
				return $controller->$action($request);
			}
			throw new \Exception('没有权限');
		}catch(\Exception $e){
			StudyException::show($e);
		}
		
	}

	public function terminate(){
		if($this->environment=='dev' && $this->debug){
			Debug::load($this->startTime);
		}
	}

	protected function validAuthor(){
		$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
		#$authorize = $this->get('author');
		$register = Register::getInstance();
		$authorize = $register->get('author');
		$authors = $authorize->getAuthors();

		foreach($authors as $role=>$author){
			#$author = '/\\'.$author.'\w+/';
			preg_match($authorize->parseAuthor($author), $url, $match);
			if(isset($match[0]) && substr($author, 1)==$match[0]){
				return $role;
			}
		}
	}
	
	protected function access(){
		$role = $this->getUser()->getRole();
		$isAccess = $this->validAuthor();

		if($isAccess && $role!=$isAccess){
			return false;
		}
		return true;
		
	}
	
	public function getUser(){
		$sessionStorage = SessionStorage::getInstance();
		return new User($sessionStorage->get('user'));
	}
}
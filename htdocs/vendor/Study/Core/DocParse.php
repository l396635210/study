<?php

namespace Study\Core;

use Study\Core\Router;
class DocParse{
	protected $rootDir;

	protected $ctrlDirs;
	protected $ctrlClasses;
	protected $ctrlMethods = [];
	
	public function __construct($root){
		$this->rootDir = $root;
		$pathes = array_diff(scandir($root), ['.','..']);
		$this->initCtrl($pathes);

	}
	
	protected function initCtrl($pathes){
		$this->setCtrlDirs($pathes);
		$this->setCtrlClasses();
        $this->setCtrlMethods();
	}
	//controller·��
	protected function setCtrlDirs($pathes){
		array_walk($pathes,function($item){
			$this->ctrlDirs[] = $item.'/Controller';
		});
	}
	//controller��
	protected function setCtrlClasses(){
		foreach($this->ctrlDirs as $ctrlDir){
			$files = array_diff(scandir($this->rootDir.$ctrlDir), ['.','..']);
			foreach($files as $file){
				$this->ctrlClasses[] = strtr($ctrlDir.'\\'.substr($file, 0, -4),'/','\\');
			}
		}
	}
	//controller����
	protected function setCtrlMethods(){
		foreach($this->ctrlClasses as $Class){
			$reflection = new \ReflectionClass ( $Class );
			//ͨ�������ȡ���ע��  
			$this->ctrlMethods = array_merge($this->ctrlMethods, $reflection->getMethods( \ReflectionMethod::IS_PUBLIC));
		}
		
	}
	
	public function parseController(){
		foreach($this->ctrlMethods as $method){
			
			$args = $this->parseRoute($method, '@Route(');
			
			if($args){
				Router::setRoute(trim($args['url']), trim($args['name']),$method->class.'@'.$method->name);
			}
			
		}
	}
	
	protected function parseRoute($method, $_method){
		$doc = $method->getDocComment();
		$args = [];
		if($doc){
			$doc = substr($doc, (stripos($doc, $_method)+strlen($_method)));
			$doc = substr($doc, 0, stripos($doc,')'));
			$doc = strtr($doc, "'", " ");
			
			list($args['url'], $args['name']) = explode(',', $doc);
		}
		return $args;
	}
}
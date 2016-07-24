<?php

use Study\Core\Kernel;

class AppKernel extends Kernel{
	
	public function setRely(){
		$this->rely = [
		'author'	=>	Study\Core\Security\Authorize::getInstance(),
		'session'	=>  Study\Core\Security\SessionStorage::getInstance(),
		];
	}

	public function getRootDir()
    {
		if(!$this->rootDir){
			$this->rootDir = __DIR__.'/';
		}
		return $this->rootDir;
    }
}
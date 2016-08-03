<?php

use Study\Core\Kernel;
use Study\Core\Register;

class AppKernel extends Kernel{

	protected function register(){

		$register = Register::getInstance();

        $register->setParams([
            'rootDir'	=>	$this->getRootDir(),
        ]);

		$register->set([
			'author'	=>	Study\Core\Security\Authorize::getInstance(),
			'session'	=>  Study\Core\Security\SessionStorage::getInstance(),
		]);

	}

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
<?php

namespace DBAL\Resources;

class MySqlException{
	
	public static function show($title, $error){
		$register = Register::getInstance();
		$excptionFile = ($register->getParam('rootDir').'/../app/Resources/security/excption.html');
		include($excptionFile);
			
	}
}
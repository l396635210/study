<?php

namespace Study\Resources;

use Study\Core\Register;

class StudyException {

	public static function show($e){
		$register = Register::getInstance();
		$rootDir = $register->getParam('rootDir');
		$title = $e->getMessage(); $error = explode("\n",$e->getTraceAsString());
		$excptionFile = ($rootDir.'/../app/Resources/security/excption.html');
		include($excptionFile);
			
	}
}
<?php

namespace Study\Resources;

class StudyException {
	
	public static function show($e){
		$title = $e->getMessage(); $error = explode("\n",$e->getTraceAsString());
		$excptionFile = (__ROOT__.'/../app/Resources/security/excption.html');
		include($excptionFile);
			
	}
}
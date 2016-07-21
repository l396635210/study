<?php

namespace DBAL\Resources;

class MySqlException{
	
	public static function show($title, $error){
		
		$excptionFile = (__ROOT__.'/../app/Resources/security/excption.html');
		include($excptionFile);
			
	}
}
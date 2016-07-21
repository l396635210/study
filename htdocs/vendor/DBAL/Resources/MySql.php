<?php

namespace DBAL\Resources;

class MySql{
	protected static $dbname;
	
	public static function myConf( $args ){
		$tmp = $args[0];
		if( is_array($args) ){
			self::$$tmp = $args[1];
		}else{
			return self::$$args;
		}
		
	}
	
}

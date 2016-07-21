<?php

namespace Study\Resources;

class Dumper{
	
	static function dump( $var ){
		echo "<pre style='background:#000;color:#1f2'>";
		if(self::canEcho($var))
			echo $var.'<br>';
		else if(is_bool($var))
			var_dump($var);
		else
			print_r($var);
		echo "</pre>";
	}
	
	static function canEcho( $var ){
		if( is_numeric($var) || is_string($var) )
			return true;
	}
	
}
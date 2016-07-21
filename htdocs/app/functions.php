<?php 

$functions = __DIR__.'/config/functions.ini';
$functions = parse_ini_file($functions);

foreach( $functions as $func=>$class ){
	if (!function_exists($func)) {
		$string = 'function ' . $func . '($var) { return '.$class.'::'.$func.'($var); }';
		eval($string);
	}
}


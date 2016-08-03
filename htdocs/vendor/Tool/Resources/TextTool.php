<?php

namespace Tool\Resources;

class TextTool{
	
	public static function symbol2camelize($args){

		if(is_array($args)){
			$input = $args[0];
			$separator = $args[1];
		}else if(is_string($args)){
			if($args[0]=='_'){
				$args = substr($args, stripos($args, '_',1)+1);
			}
			$input = $args;
			$separator = '_';
		}
		return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
	}
	
	public static function camelize2symbol($args){
		if(is_array($args)){
			$input = $args[0];
			$separator = $args[1];
		}else if(is_string($args)){
			$input = $args;
			$separator = '_';
		}
		return strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', $separator, $input));
	}
	
}
<?php

namespace Tool\Resources;

class AlertTool{
	
	protected static $error = [];
	protected static $success = [];
	public static function addError($error){
		self::$error[] = '<p class=\'alert alert-danger\'>警告：'.$error.'</p>';
	}
	
	public static function errors($param){
		if($param=='all'){
			return self::$error;
		}
		return self::$error[$param];
	}
	
	
	public static function addSuccess($success){
		self::$success[key($success)] = '<p class=\'alert alert-success\'>提示：'.current($success).'</p>';
	}
	
	public static function success($param='all'){
		if(isset(self::$success[$param])){
			return self::$success[$param];
		}
		return self::$success;
	}
}
<?php

namespace Tool\Resources;

use Study\Resources\Request;

class FileTool{
	
	public static function saveBase64Image($base64_string){
		$data = explode(',', $base64_string);

		if(self::isBase64Image($data[0])){
			$assets = './assets/';
			$uploadDir = 'upload/'.date('Y/m/d/');
			if(!is_dir($assets.$uploadDir)){
				mkdir($assets.$uploadDir, 0777, true);
			}
			$fileName = md5(time()).'.png';
			file_put_contents($assets.$uploadDir.$fileName,base64_decode($data[1]));
			return $uploadDir.$fileName;

		}
		addError("图片格式不正确");
		return $base64_string;
	}

	public static function isBase64Image($data){
		if(stripos($data, ',')){
			$data = substr($data, 0, stripos($data, ','));
		}
		return stripos($data,"data:image/")===0&&strrchr($data,"base64")==="base64";
	}
}
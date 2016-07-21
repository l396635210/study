<?php

namespace Commond;

use Commond\Schema\Migration;

class Commond{
	
	protected $commond;
	protected $args;
	
	public function __construct(){
		$this->commond = explode(':', strtolower($_SERVER["argv"][1]));
		$this->args = explode(':', substr($_SERVER["argv"][2], 1));
		$this->doCommond();
	}
	
	protected function doCommond(){
		switch($this->commond[0]){
			case 'schema':
				$this->schema();
			break;
		}
	}
	
	protected function schema(){
		$migration = new Migration();
		$function = $this->commond[1];
		$migration->$function($this->args);
	}
	
}
<?php 

namespace Study\Core\Form;

class FormException extends \Exception{
	
	public function show($assign){
		extract($assign);
		
	}
}
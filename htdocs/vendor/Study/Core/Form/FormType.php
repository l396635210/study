<?php

namespace Study\Core\Form;

abstract class FormType{
	
	const TEXT 		 = 'text';
	const ENTITY	 = 'entity';
	const TEXTAREA	 = 'textarea';
	const HIDDEN	 = 'hidden';
	const PASSWORD	 = 'password';
	
	protected $options = [
		'method'	=>	'post',
	];
	
	public function get($option){
		return $this->options[$option];
	}
	
	abstract function buildForm( $form, $entity );
	
	public function setFormValue( $form, $entity ){
		$formContent = $form->content();
		foreach($formContent as $key=>$val){
			$form->setFormValue($key, $entity[$key]);
		}
	}
	
	abstract function configOptions();
	
	public function getEntity(){
		return $this->options['entity'];
	}
	
	public function getEntityName(){
		return strtolower(
			substr(get_class($this->getEntity())
				, strripos(get_class($this->getEntity()), '\\') + 1
			)
		);
	}

}
<?php

namespace Study\Core\Form;

use Study\Core\Form\FormType;

class Form{
	
	protected $form;
	protected $entity;
	protected $formType;
	
	protected $request;
	
	protected $_token;
	protected $isSubmit = false;
	protected $isValid = true;
	public function createForm( $formType, $entity=NULL){

		$this->formType = $formType;
		$this->formType->configOptions();
		$this->formType->buildForm( $this, $entity );
		
		$this->entity = $this->formType->getEntity();
		$this->createToken();

		$this->form['_method'] = $this->formType->get('method');
	}
	
	public function isValid(){
		try{
			$entityName = $this->formType->getEntityName();
			foreach($this->form as $key => $val){
				if($key!='_token' && $key!='_method'){
					$this->setEntity($key, $this->request[$entityName][$key]);
					$this->setFormValue($key, $this->request[$entityName][$key]);
				}
			}
		}catch(FormException $e){
			var_dump($e);
		}
		return $this->isValid;
	}
	
	public function setFormValue($key, $val=NULL){
		$method = 'get'.ucfirst($key);
		#var_dump($this->row($key));
		$val = $val ? $val : $this->formType->getEntity()->$method();
		if(strstr($this->form[$key], 'input') && !is_array($val)){
			$value = 'value='.$val.' />';
			$this->form[$key] = strtr($this->form[$key], ['/>'=> $value]);
			return;
		}
		if(strstr($this->form[$key], 'select') && !is_array($val)){
			$value = 'value='.$val.' selected ';
			$this->form[$key] = strtr($this->form[$key], ['value='.$val => $value]);
			return;
		}
		if(strstr($this->form[$key], 'textarea') && !is_array($val)){
			$value = '>'.$val.'</textarea>';
			$this->form[$key] = strtr($this->form[$key], ['></textarea>'=>$value]);
			return;
		}
	}
	
	protected function setEntity($property, $value){
		$isValid = $this->entity->validate(':'.$property, $value);
		$this->isValid = !$isValid ? $isValid : $this->isValid;
		if($isValid){
			$this->entity->set($property, $value);
		}
	}
		
	public function isSubmit(){
		return $this->isSubmit;
	}
	
	public function handleRequest($request){
		
		$formMethod = $this->form['_method'];
		$isRequest = 'is'.$formMethod;
		if(!$request->$isRequest()){
			return;
		}

		if($request->$formMethod()){
			$token = md5($_SERVER['HTTP_REFERER'].date('Y-m-d H').'123!@#QWE');
			if($request->$formMethod('_token')==$token){

				$this->isSubmit = true;
				$this->request = $request->$formMethod();

			}
		}

	}
	
	public function getData(){
		return $this->entity;
	}
	
	public function getToken(){
		return $this->_token;
	}
	
	public function add($field, $type, $attr){
		
		foreach($attr as $key=>$item){
			$encode = mb_detect_encoding($item, array("ASCII","UTF-8","GB2312","GBK",'BIG5')); 
			$attr[$key]= iconv($encode, "UTF-8", $item);
		}
		
		$label = $this->buildLabel($field, $attr);
		$entity = $this->formType->getEntityName();
		
		switch($type){
			case $type==FormType::TEXT:
			case $type==FormType::HIDDEN:
			case $type==FormType::PASSWORD:
					$this->buildInput($field, $type, $attr, $label, $entity);
				break;
			
			case $type==FormType::ENTITY:
					$this->buildEntity($field, $type, $attr, $label, $entity);
				break;
			
			case $type==FormType::TEXTAREA:
					$this->buildTextArea($field, $type, $attr, $label, $entity);
				break;	
		}
		
		return $this;
	}
	
	protected function buildLabel($field, $attr){
		$entity = $this->formType->getEntityName();
		return isset($attr['label']) ? "<label for='{$entity}_$field' >{$attr['label']}</label>" : "";
	}
	protected function buildInput($field, $type, $attr, $label, $entity){
		
		$method = 'get'.ucfirst($field);
		$value = $this->formType->getEntity()->$method();
		$value = is_string($value) ? "value = {$value}" : "";
		$this->form[$field] = $label."<input id={$entity}_$field name={$entity}["."$field] type='$type' {$value} $attr[attr] />";
	
	}
	
	protected function buildEntity($field, $type, $attr, $label, $entity){
		$Model = strtr($attr['option'], [':'=>'\\Model\\']);
		$Model .= 'Model';
		$Entity = strtr($attr['option'], [':'=>'\\Entity\\']);

		$model = new $Model(new $Entity());
		
		$list = $model->findAll()->getFind();
		
		$option = "";
		foreach($list as $item){
			$option .= "<option value={$item['id']}>{$item[$attr['option_label']]}</option>";
		}
		$this->form[$field] = $label.
			"<select id={$entity}_$field name={$entity}["."$field] $attr[attr] >"
			.$option."</select>";
	}
	
	protected function buildTextArea($field, $type, $attr, $label, $entity){
		$this->form[$field] = $label."<textarea id={$entity}_{$field} name={$entity}["."{$field}] $attr[attr] ></textarea>";
	}
	
	public function start($action='', $attr=''){
		return "<form name={$this->formType->getEntityName()} action='{$action}' method='{$this->formType->get('method')}' {$attr}>";
	}
	
	protected function createToken(){
		$host = $_SERVER['HTTP_HOST'];
		$self = $_SERVER['PHP_SELF'];
		$token = 'http://'.$host.$self.date('Y-m-d H').'123!@#QWE';
		$this->_token = md5($token);
	}
	
	protected function addToken(){
		$this->form['_token'] = "<input id='_token' name='_token' type='hidden' value={$this->_token} />";
	}
	
	public function end(){
		$this->addToken();
		return $this->form['_token']."</form>";
	}
	
	public function row( $property ){
		return $this->form[$property];
	}
	
	public function content(){
		return $this->form;
	}
}
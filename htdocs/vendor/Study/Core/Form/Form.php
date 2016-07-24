<?php

namespace Study\Core\Form;

use Study\Core\Form\FormType;

class Form{
	
	protected $form;
	protected $view;
	protected $entity;
	protected $formType;
	
	protected $request;
	
	protected $_token;
	protected $isSubmit = false;
	protected $isValid = true;
	public function createForm( $formType, $entity=NULL){

		$this->formType = $formType;
		$this->formType->configOptions($entity);
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
				}
			}
		}catch(FormException $e){
		}
		return $this->isValid;
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


		$this->form[$field] = ['field'=>$field, 'type'=>$type, 'attr'=>$attr, 'label'=>$label];

		
		return $this;
	}


	protected function buildView(){

		foreach($this->form as $field => $item){
			if($field!='_method'){
				$type = $item['type']; $attr = $item['attr'];
				$label = $item['label'];
				switch($type){
					case $type==FormType::TEXT:
					case $type==FormType::HIDDEN:
					case $type==FormType::PASSWORD:
						$this->buildInput($field, $type, $attr, $label);
						break;

					case $type==FormType::ENTITY:
						$this->buildEntity($field, $type, $attr, $label);
						break;

					case $type==FormType::TEXTAREA:
						$this->buildTextArea($field, $type, $attr, $label);
						break;
				}
			}

		}

	}

	public function view(){
		$this->buildView();
		#var_dump($this->view);die;
		return $this;
	}

	protected function buildLabel($field, $attr){
		$entity = $this->formType->getEntityName();
		return isset($attr['label']) ? "<label for='{$entity}_$field' >{$attr['label']}</label>" : "";
	}
	protected function buildInput($field, $type, $attr, $label){
		$entity = $this->formType->getEntityName();
		$method = 'get'.ucfirst($field);
		$value = $this->formType->getEntity()->$method();
		$value = is_string($value) ? "value = {$value}" : "";
		$this->view[$field] = $label."<input id={$entity}_$field name={$entity}["."$field] type='$type' {$value} $attr[attr] />";
	
	}
	
	protected function buildEntity($field, $type, $attr, $label){

		$Model = strtr($attr['option'], [':'=>'\\Model\\']);
		$Model .= 'Model';
		$Entity = strtr($attr['option'], [':'=>'\\Entity\\']);

		$model = new $Model(new $Entity());
		
		$list = $model->findAll()->getFind();

		$entity = $this->formType->getEntityName();
		$method = 'get'.ucfirst($field);
		$value = $this->formType->getEntity()->$method();

		$option = "";
		foreach($list as $item){
			$_selected = $value == $item['id'] ? 'selected' : '';
			$option .= "<option value={$item['id']} {$_selected} >{$item[$attr['option_label']]}</option>";
		}
		$this->view[$field] = $label.
			"<select id={$entity}_$field name={$entity}["."$field] $attr[attr] >"
			.$option."</select>";
	}
	
	protected function buildTextArea($field, $type, $attr, $label){
		$entity = $this->formType->getEntityName();
		$method = 'get'.ucfirst($field);
		$value = $this->formType->getEntity()->$method();
		$this->view[$field] = $label."<textarea id={$entity}_{$field} name={$entity}["."{$field}] $attr[attr] >{$value}</textarea>";
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
		$this->view['_token'] = "<input id='_token' name='_token' type='hidden' value={$this->_token} />";
	}
	
	public function end(){
		$this->addToken();
		return $this->view['_token']."</form>";
	}
	
	public function row( $property ){
		return $this->view[$property];
	}
	
	public function content(){
		return $this->view;
	}
}
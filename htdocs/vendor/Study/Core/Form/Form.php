<?php

namespace Study\Core\Form;

use Study\Resources\Request;
use Tool\Resources\FileTool;

class Form{
	
	protected $form;
	protected $view;
	protected $entity;
	protected $formType;
	
	protected $request;
	
	protected $_token;
	protected $isSubmit = false;
	protected $isValid = true;

	/**
	 * 创建表单
	 * @param $formType FormType 子类
	 * @param null $entity entity 子类实体
	 */
	public function createForm( $formType, $entity=NULL){

		$this->formType = $formType;
		$this->formType->configOptions($entity);
		$this->formType->buildForm( $this, $entity );
		
		$this->entity = $this->formType->getEntity();
		$this->createToken();
		$this->form['_method'] = $this->formType->get('method');
	}

	/**
	 * 验证数据是否有效
	 * @param null $request
	 * @return bool
	 */
	public function isValid($request=NULL){
		if($request && get_class($request)==Request::class){
			$this->request = $request;
		}
		try{
			$entityName = $this->formType->getEntityName();
			foreach($this->form as $key => $val){
				if($key!='_token' && $key!='_method'){
					$this->saveBase64Image($entityName, $key);
					$this->setEntity($key, $this->request[$entityName][$key]);
				}
			}
		}catch(FormException $e){
		}
		return $this->isValid;
	}

	/**
	 * 保存base64图片
	 * @param $entityName $this->formType->getEntityName();
	 * @param $key $this->form as $key
	 */
	protected function saveBase64Image($entityName, $key){
		if(FileTool::isBase64Image($this->request[$entityName][$key])){
			$this->request[$entityName][$key] = FileTool::saveBase64Image($this->request[$entityName][$key]);
		}
	}

	/**
	 * 验证Entity数据是否正确，并赋值
	 * @param $property
	 * @param $value
	 */
	protected function setEntity($property, $value){
		$isValid = $this->entity->validate(':'.$property, $value);
		$this->isValid = !$isValid ? $isValid : $this->isValid;
		if($isValid){
			$this->entity->set($property, $value);
		}
	}

	/**
	 * 是否提交合法
	 * @return bool
	 */
	public function isSubmit(){
		return $this->isSubmit;
	}

	/**
	 * 处理Request请求中的数据
	 * @param $request
	 */
	public function handleRequest($request){
		$formMethod = $this->form['_method'];
		$isRequest = 'is'.$formMethod;
		if(!$request->$isRequest()){
			return;
		}
		if($request->$formMethod()){
			$token = $this->createToken();
			if($request->$formMethod('_token')==$token){
				$this->isSubmit = true;
				$this->request = $request->$formMethod();

			}
		}

	}

	/**
	 * 获取entity
	 * @return mixed
	 */
	public function getData(){
		return $this->entity;
	}

	/**
	 * 获取token
	 * @return mixed
	 */
	public function getToken(){
		return $this->_token;
	}

	/**
	 * @param $field  字段名
	 * @param $type 字段类型
	 * @param $attr html属性
	 * @return $this
	 */
	public function add($field, $type, $attr){
		
		foreach($attr as $key=>$item){
			$encode = mb_detect_encoding($item, array("ASCII","UTF-8","GB2312","GBK",'BIG5')); 
			$attr[$key]= iconv($encode, "UTF-8", $item);
		}
		
		$label = $this->buildLabel($field, $attr);
		$this->form[$field] = ['field'=>$field, 'type'=>$type, 'attr'=>$attr, 'label'=>$label];

		return $this;
	}

	/**
	 * 构建form视图
	 */
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
		return "<form name={$this->formType->getEntityName()} id='form-{$this->formType->getEntityName()}' action='{$action}' method='{$this->formType->get('method')}' {$attr}>";
	}
	
	protected function createToken(){
		$host = $_SERVER['HTTP_HOST'];
		$token = 'http://'.$host.get_class($this->entity).date('Y-m-d H').'123!@#QWE';
		$this->_token = md5($token);
		return $this->_token;
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

	public function id(){
		return 'form-'.$this->formType->getEntityName();
	}
	
	public function content(){
		return $this->view;
	}
}
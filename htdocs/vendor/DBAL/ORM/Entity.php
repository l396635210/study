<?php 

namespace DBAL\ORM;


class Entity{
	
	protected $id = ['type'=>'int', 'key'=>'primary key', 'comment'=>'primary key'];
	
	protected $table;
	protected $fields;
	
	protected $pdoType = [];
	
	public function __construct( $result=NULL ){
		$this->init();
		
	}
	
	protected function init(){
		$this->setTable();
		$this->setFields();
	}
	
	/**
	 *初始化表
	 */
	private function setTable(){
		if(!$this->table){
			$this->table = strtolower(substr(get_class($this), (strripos(get_class($this),'\\'))+1));
		}
	}
	
	public function getTable(){
		return $this->table;
	}
	
	/**
	 * 初始化所有字段
	 * 获得entity中的全部字段
	 */
	private function setFields(){
		foreach($this as $attr=>$rule){
			if($attr!='table' && $attr!='fields' && $attr!='pdoType'){
				/*
				if(isset($rule['length'])){
					$rule['type'] = $rule['type']."($rule[length])";
					unset($rule['length']);
				}
				*/
				$rule['field'] = $attr;
				$rule = $this->setFieldLenth($rule);
				$rule = $this->setFieldNotNull($rule);
				$this->fields[$attr] = $rule;
			}
		}
	}
	
	/**
	 * 设置字段默认长度
	 * 无限制则为0
	 */
	private function setFieldLenth( $rule ){
		if(!isset($rule['length'])){
			switch(strtolower($rule['type'])){
				case 'int': 	$rule['length'] = 10;
					break;
					
				case 'char':
				case 'varchar':  $rule['length'] = 255;
					break;
					
				case 'bool':	 $rule['length'] = 1;
					break;
					
				case 'email':	 $rule['length'] = 60;
					break;
					
				case 'password': $rule['length'] = 60;
					break;
				
				default:		 $rule['length'] = 0;
					break;
			}
		}
		return $rule;
	}
	
	/**
	 * 设置字段notNull
	 */
	private function setFieldNotNull($rule){
		if(!isset($rule['notNull'])){
			$rule['notNull'] = true;
		}
		return $rule;
	}
	
	public function getFields(){
		return $this->fields;
	}
	
	public function __call($methodName, $args) {
        if (preg_match('~^(set|get)([A-Z])(.*)$~', $methodName, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];
            if (!property_exists($this, $property)) {
                #throw new MemberAccessException('Property ' . $property . ' not exists');
				return 'Property ' . $property . ' not exists';
            }
            switch($matches[1]) {
                case 'set':
                    return $this->set($property, $args[0]);
                case 'get':
                    return $this->get($property);
            }
        }
    }
	
	public function get($property) {
        return $this->$property;
    }

    public function set($property, $value) {
		$this->validate($property, $value);
		if($property=='password'){
			$this->$property = password_hash($value, PASSWORD_BCRYPT);
		}else{
			$this->$property = $value;
		}
		
		return $this;
    }
	
	public function validate($property, $value){
		$property = $property[0] == ':' ? substr($property,1) : $property;
		$property = symbol2camelize($property);
		if(!$this->nullValidate($property, $value)){
			$this->invalidProperty($property, '不能为空');
			return false;
		}
		if(!$this->typeValidate($property, $value)){
			$this->invalidProperty($property, '格式不正确');
			return false;
		}
		if(!$this->lengthValidate($property, $value)){
			$this->invalidProperty($property, '字数不匹配');
			return false;
		}
		if(!$this->uniqueValidate($property, $value)){
			$this->invalidProperty($property, '已存在');
			return false;
		}
		return true;
	}
	
	protected function invalidProperty($property, $message){
		$property = $this->$property;
		addError($property['comment'].$message);
	}
	
	protected function nullValidate($property, $value){
		$property = $this->$property;
		if(!isset($property['notNull']) && ($value==NULL&&$value!==0)){
			return false;
		}
		if(NULL===$value && strtolower(trim($property['notNull'])=='not null')){
			return false;
		}
		return true;
	}
	
	protected function typeValidate($property, $value){
		$property = $this->$property;
		switch(strtolower($property['type'])){
			case 'char':
			case 'varchar':
			case 'text':
			case 'password':
				return is_string($value);
			
			case 'email':
				return filter_var($value, FILTER_VALIDATE_EMAIL);
				
			case 'int':
				return (int)$value==$value;
				
			case 'bool':
				return 	is_bool($value);
			
			case 'date':
				return $this->checkdate($value);
			
			case 'time':
				return $this->checktime($value);
				
			case 'timestamp':
			case 'datetime':
				list($date, $time) = explode(' ',$value);
				return $this->checkdate($date) && $this->checktime($time);
			
		}
	}
	
	protected function checkdate($date){
		$date = explode('-', $date);
		return checkdate($date[1], $date[2], $date[0]);
	}
	
	protected function checktime($time){
		return preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])/", $time);
	}
	
	protected function lengthValidate($property, $value){
		$property = $this->$property;
		return isset($property['length']) ? $property['length'] > strlen($value) : true;
	}
	
	protected function uniqueValidate($property, $value){
		list($unique, $_property) = array(false, $this->$property);
		if(isset($_property['unique']) && $_property['unique']=='unique'){
			$sql = "SELECT * FROM ".$this->getTable()." WHERE $property = :$property";
			$model = new Model();

			$unique = $model->createQuery($sql)
			  ->setParam([":$property"=>$value]
					, $this->getPDOType($property)
					, isset($_property['length']) ? $_property['length'] : 0)
			  ->execute()
			  ->fetch();
		}
		
		return !$unique;	  
	}
	
	public function getPDOType( $property ){
		$property = $this->symbol2camelize($property);

		switch(strtolower($property['type'])){
			case 'char':
			case 'varchar':
			case 'date':
			case 'time':
			case 'timestamp':
			case 'datetime':
			case 'text':
				return \PDO::PARAM_STR;
			
			case 'int':
				return \PDO::PARAM_INT;
				
			case 'bool':
				return 	\PDO::PARAM_BOOL;
		}
		
	}
	
	public function getFieldLength( $property ){
		$property = $this->symbol2camelize($property);
		return isset($property['length']) ? $property['length'] : 0;
	}
	
	public function getPDOLength( $property ){
		return $this->getFieldLength( $property );
	}
}
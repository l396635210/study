<?php

namespace Commond\Schema;

use DBAL\ORM\Model;

class Migration{
	
	protected $model;
	
	protected $bundle;
	protected $entity;
	
	protected $dbConf;
	public function __construct(){
		$this->model = new Model();
		$this->dbConf = parse_ini_file(getcwd().'/app/config/mysql.ini');
	}
	
	protected function create( $Entity ){
		$entity = new $Entity();
		if($entity->getFields()){
			$sql = $this->createEntitySql($entity);
			$this->model->exec($sql);
			print_r($this->model->info("CREATE {$entity->getTable()} Success!\n"));
		}
	}
	
	protected function createEntitySql($entity){

		$_sql = "CREATE TABLE if not exists {$entity->getTable()} (\n";
		$_key = "";
		foreach($entity->getFields() as $field=>$rules){

			$_sql .= $this->entityFieldRuleSql($entity, $field, $rules);
			$_key .= isset($rules['key']) ? "{$rules['key']}({$field}),\n" : "";
		}
		$sql = substr($_sql.$_key, 0 , strripos($_sql.$_key, ','))."\n";

		$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		return $sql;
	}

	protected function entityFieldRuleSql($entity, $field, $rules, $end=",\n"){
		$field = camelize2symbol($field);
		$_field = $field;
		$type = $entity->getSchemaType($field);
		$_type_length = $rules['length']===0 ? $type : $type."({$rules['length']})";
		$_unsigned = $rules['type']=='int'	 ? 'unsigned' : '';
		$_notNull = $rules['notNull']===true ? 'NOT NULL' : 'default NULL';
		$_auto_increment = $field == 'id' 	 ? 'AUTO_INCREMENT' : '';
		$_comment = $rules['comment'] 		 ? "comment' ".$rules['comment']." '" : '';
        if($rules['type']=='timestamp'){
            $_default_value = 'DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
        }else{
            $_default_value = '';
        }
        $sql = "{$_field} {$_type_length} {$_unsigned} {$_notNull} {$_auto_increment} {$_default_value} {$_comment}{$end}";
        return $sql;
	}
	
	public function migrate( $args ){
		$this->bundle = $args[0];
		$this->entity = ucfirst($args[1]);
		if(strtolower($this->entity)=='entities'){
			$dir = getcwd().'/src/'.$this->bundle.'/Entity/';
			$files = array_diff(scandir($dir), ['.','..']);
			$this->migrateEntities( $files );
		}else{
			$Entity = $this->bundle.'\Entity\\'.$this->entity;
			$this->migrateEntity( $Entity );
		}
		
	}
	
	protected function migrateEntities( $files ){
		foreach( $files as $entity ){
			$Entity = $this->bundle.'\Entity\\'.ucfirst(substr($entity, 0, -4));
			$this->migrateEntity( $Entity );
		}
	}
	
	protected function migrateEntity( $Entity ){
		
		$entity = new $Entity();
		if($schemaFields = $this->getSchemaEntity($entity)){
			//更新
			$this->update($schemaFields, $entity);
		}else{
			$this->create($entity);
		}
	}
	
	protected function getSchemaEntity($entity){
		
		$dbname = $this->dbConf['dsn']['dbname'];
		$sql = "select column_name AS field, column_type AS type from information_schema.columns
				where TABLE_SCHEMA = '$dbname' AND table_name='".$entity->getTable()."'";
		$pdos = $this->model->query($sql);
		$schemaFields = $pdos->fetchAll();
		return $schemaFields;
	}
	
	protected function update($schemaFields, $entity){
		//数组降维
		$fields = array_reduce($schemaFields,function(&$fields,$v){
				$fields[symbol2camelize($v['field'])] = $v;
				return $fields;
		});
		
		//判断添加字段，向表里添加字段	
		$addFields = array_diff_key($entity->getFields(),$fields);
		if( $addFields ){
			$this->addFieldToEntitySql($entity, $addFields);
		}
		
		//判断删除字段，从表里删除字段
		$dropKey = array_diff_key($fields, $entity->getFields());
		if(isset($dropKey['id'])){
			unset($dropKey['id']);		
		}
		if( $dropKey ){
			$this->drop($entity->getTable(), $dropKey);
		}
	}

	protected function addFieldToEntitySql($entity, $fields){
		$_add = "alter table {$entity->getTable()} add ";
		foreach($fields as $field=>$rules){
			$field = camelize2symbol($field);
			$sql = $_add .' '.$this->entityFieldRuleSql($entity, $field, $rules, ";");
            $this->model->exec($sql);
			print_r($this->model->info("ADD $field to {$entity->getTable()} Success!\n"));
		}
	}

	protected function drop($table, $fields){
		foreach($fields as $key=>$val){
			$sql = "alter table $table drop ".camelize2symbol($key).";";
			$this->model->exec($sql);
			print_r($this->model->info("DROP $key FROM $table Success!\n"));
		}
	}
	
}
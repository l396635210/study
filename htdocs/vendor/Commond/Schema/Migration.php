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
			$table = $entity->getTable();
			$sql = "CREATE TABLE if not exists {$table} (
					id int(10) unsigned NOT NULL AUTO_INCREMENT,\n";
					
					var_dump($entity->getFields());die;
			foreach($entity->getFields() as $key=>$val){
				$key = camelize2symbol($key);
				$sql .= $this->createSqlFields($key, $val);
			}
			foreach($entity->getFields() as $key=>$val){
				$key = camelize2symbol($key);
				$sql .= $this->createSqlKey($key, $val);
			}
			$sql .=" PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

			$this->model->exec($sql);
			print_r($this->model->info("CREATE $table Success!\n"));
		}
	}
	
	protected function createSqlKey($field, $rules, $end=",\n"){
		$sql = "";
		foreach($rules as $key=>$val){
			if($key=='unique' && $val == 'unique'){
				$sql .= "unique({$field}){$end}";
			}
		}
		return $sql;
	}
	
	protected function createSqlFields($field, $rules, $end=",\n"){
		
		
		var_dump($field);
		var_dump($rules);
		$sql = $field ;
		var_dump($sql);die;
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
			$this->add($entity->getTable(), $addFields);
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
	
	protected function add($table, $fields){
		foreach($fields as $key=>$val){
			$sql = "alter table $table add ";
			$key = camelize2symbol($key);
			$sql .= $this->createSqlFields($key, $val, ';');
			$this->model->exec($sql);
			print_r($this->model->info("ADD $key to $table Success!\n"));
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
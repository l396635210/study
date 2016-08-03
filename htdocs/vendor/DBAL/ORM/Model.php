<?php

namespace DBAL\ORM;

use DBAL\PDOMySql\Driver;
use DBAL\Resources\MySqlException;
use Study\Core\Security\SessionStorage;
use Study\Resources\Debug;

class Model{
	
	protected $conn;
	protected $sth;
	protected $sql;
	protected $parameters = [];
	protected $entity;
	
	protected $container;
	
	const FIND_ALL = 'all';
	const FIND_ONE = 'one';
	public function __construct($entity = null){
		$this->conn();
		if(!$this->entity){
			$this->entity = $entity;
		}
		if(strpos(strtolower(get_class($this->entity)),'user') !== false){
			$this->container['session'] = SessionStorage::getInstance();
		}
	}
	
	protected function getContainer($name='all'){
		if($name=='all'){
			return $this->container;
		}
		return $this->container[$name];
	}
	
	protected function conn(){
		if(!$this->conn){
			$driver = new Driver();

			$this->conn = $driver->connect();
		}
		return $this->conn;
	}
	
	public function exec($sql){
		return $this->conn->exec($sql);
	}
	
	public function errorInfo(){
		return $this->conn->errorInfo();
	}
	
	public function info($successInfo){
		$errorInfo = $this->conn->errorInfo();
		if($errorInfo[0]==0){
			return $successInfo;
		}else{
			return $errorInfo;
		}
	}
	
	public function beginTransaction(){
		$this->conn->beginTransaction();
	}
	
	public function rollBack(){
		$this->conn->rollBack();
	}
	
	public function commit(){
		$this->conn->commit();
	}
	
	public function query($sql){
		return $this->conn->query($sql);
	}
	
	public function fetchAll(){
		return $this->sth->fetchAll();
	}
	
	public function fetch(){
		return $this->sth->fetch();
	}
	
	/**
	 * $model->createQuery($sql)->setParam([':key'=>$val])->execute()
	 */
	public function createQuery($sql){
		$this->prepare($sql);
		return $this;
	}
	
	public function getFind($find=self::FIND_ALL){
		$this->execute();
        $this->parameters = null;
		if($find==self::FIND_ONE){
			return $this->fetch();
		}
		return $this->fetchAll();
	}

	public function getCount(){
        $this->execute();
        $this->parameters = null;
        $res = $this->fetch();
        return $res['cnt'];
    }
	
	public function findAll(){
		$this->select('*', $this->entity->getTable());
		$this->prepare($this->sql);
		return $this;
	}

    /**
     * @param $wheres ['status','=',1] or [['status','=',1],['id','>',1]]
     * @param array $orderBy ['id'=>'desc'] [['id'=>'desc'],['date'=>'desc']]
     * @param array $limit [0,10]
     * @return $this
     */
	public function findBy($wheres, $orderBy=[], $limit=[]){
		$whereFunction = (count($wheres, COUNT_RECURSIVE)==count($wheres)) ? 'where' : 'wheres';
		$this->select('*', $this->entity->getTable())
			 ->$whereFunction($wheres)
			 ->orderBy($orderBy)
			 ->limit($limit);
		$this->prepare($this->sql);
        #$this->bindParams();
		return $this;
	}

	public function _sql(){
	    return ['sql'=>$this->sql, 'params'=>$this->parameters];
    }
	
	public function findOne($id){
		return $this->findBy(['id', '=', $id]);
	}

	public function count(){
        $this->select('COUNT(*) AS cnt', $this->entity->getTable());
        $this->prepare($this->sql);
        return $this;
    }

    public function countBy($wheres){
        $whereFunction = (count($wheres, COUNT_RECURSIVE)==count($wheres)) ? 'where' : 'wheres';
        $this->select('COUNT(*) AS cnt', $this->entity->getTable())
            ->$whereFunction($wheres);
        $this->prepare($this->sql);
        #$this->bindParams();
        return $this;
    }

	protected function select($fields, $table){
		$fields = is_array($fields) ? implode(',', $fields) : $fields;
		$this->sql = "SELECT " .$fields. " FROM ". $table ;
		return $this;
	}

	/**
	 * @param $table string tableName
	 * @param $on ['table1'=>'id','table2'=>'id']
	 */
	protected function join($table, $on, $type='INNER'){
		$_join = $type." JOIN ".$table." ON ".key($on[0]).".".current($on[0])." = ".key($on[1]).".".current($on[1]);
		$this->sql .= $_join;
		return $this;
	}
	
	protected function wheres($wheres){
		
		if(is_array($wheres) && count($wheres>0)){
			foreach($wheres as $where){
				$this->sql .= $this->where($where);
			}
		}
		return $this;
	}
	
	protected function where($where){
		$_where = " WHERE 1=1 ";
		if(is_array($where) && count($where>0)){
			if(count($where)==2){
				$_where = [$where[0], '=', $where[1]];
			}
			$_where .= " AND {$where[0]} {$where[1]} :{$where[0]}";
			$this->setParam([':'.$where[0]=>$where[2]]);
		}
		$this->sql .= $_where;
		return $this;
	}
	
	protected function orderBy($order){
		$_order = " ORDER BY ";
		if(is_array($order) && count($order)>0){
			foreach( $order as $key=>$val ){
				$_order .= $key ." ". $val.",";
			}
			$this->sql .= substr($_order, 0, -1);
		}
		return $this;
	}
	
	protected function limit($limit){
		if( is_array($limit) && count($limit)>0 ){
			$limit = is_array($limit) ? implode(',', $limit) : $limit;
			$this->sql .= " LIMIT ".$limit;
		}
		return $this;
	}
	
	public function insert($entity){

		try{
			$this->entity = $entity;
			if($this->entity->getTable()==$entity->getTable()){
				$sql = "INSERT INTO {$this->entity->getTable()} ";
				$properties = array_keys($this->entity->getFields());
				$sql .= '('.implode( ', ',$properties ).')VALUES';
				$values = array_map(function($n){
					return ":$n";
				}, $properties );

				$sql .= '('.implode( ', ', $values ).')';

				$this->prepare(camelize2symbol($sql));

				foreach($entity->getFields() as $field=>$rule){
					$getMethod = 'get'.ucfirst(symbol2camelize($field));
					$value = $this->entity->$getMethod();

					$this->setParam([':'.camelize2symbol($field)=>$value]);
				}
				$this->execute();
				return $this->lastInsertId();
			}
		}catch(MySqlException $e){
			$e->show('添加数据出错',$e->getTrace());die;
		}
		
	}
	
	public function update($entity){
		try{
			if($this->entity->getTable()==$entity->getTable()){
				//update 语句
				$sql = "UPDATE {$this->entity->getTable()} SET ";

				//set 参数
				foreach($entity->getFields() as $property=>$value){
					if($entity->get($property)!==NULL){
						#$sql .= "{$property} = '{$entity->get($property)}', ";
						$sql .= "{$property} = :{$property}, ";
						$this->setParam([':'.camelize2symbol($property)=>$entity->get($property)]);
					}
				}
				$sql = substr($sql, 0, strripos($sql, ','))." WHERE id={$entity->get('id')}";
				$this->prepare(camelize2symbol($sql));
				$this->execute();
				return $this->rowCount();
			}

		}catch(MySqlException $e){
			$e->show('修改数据出错',$e->getTrace());die;
		}
	}

	/**
	 * 把表中status字段改为0
	 * @param $entity
	 * @return mixed
	 */
	public function delete($entity){
		try{
			if($this->entity->getTable()==$entity->getTable()){
				//update 语句
				$sql = "UPDATE {$this->entity->getTable()} SET
						{$this->entity->getTable()}.status = 0
						 WHERE id={$entity->get('id')}";
				$this->prepare(camelize2symbol($sql));
				$this->execute();
				return $this->rowCount();
			}

		}catch(MySqlException $e){
			$e->show('删除数据失败',$e->getTrace());die;
		}
	}
	
	public function prepare($sql, $attr=[]){
		$this->sth = $this->conn->prepare($sql, $attr);
		return $this;
	}

	/**
	 * @param $array
	 * @param null $type PDO::PARAM 常量
	 * @param int $length 字段长度
	 * @return $this
	 */
	public function setParam($array, $type=Null, $length=0){

		$field = key($array)[0]==':' ? substr(key($array), 1) : key($array);

		if(strstr($field, ':')){
			$field = substr($field, stripos($field, ':')+1);
		}
		$type = $type ? \PDO::PARAM_STR : $this->entity->getPDOType($field);

        $length = $length ? $length : $this->entity->getPDOLength($field);

		if($type == \PDO::PARAM_INT && is_numeric(current($array))){
			$val = (int)current($array);
		}else{
			$val = current($array);
		}
		$this->parameters[] = [
			'parameter' => key($array),
			'variable'	=> $val,
			'data_type' => $type,
			'length'	=> $length,
			];
		return $this;
	}
	
	protected function bindParams(){
		if($this->parameters){
			foreach( $this->parameters as $parameter ){
				if($parameter['length']){
					$this->sth->bindParam(camelize2symbol($parameter['parameter']), $parameter['variable'], 
					$parameter['data_type'], $parameter['length']);
				}else{
					$this->sth->bindParam($parameter['parameter'], $parameter['variable'],
					$parameter['data_type']);
				}
			}
		}
		return $this;
	}
	
	public function execute(){
		if($this->parameters){
			$this->bindParams();
		}
		$query_start = microtime('true');
		$this->sth->execute();
		$query_end   = microtime('true');
		$query_runtime = round(($query_end-$query_start)*1000,2);
		Debug::addDebug('query_runtime', $query_runtime.'毫秒');
		return $this;
	}
	
	public function lastInsertId(){
		return $this->conn->lastInsertId();
	}
	
	public function rowCount(){
		return $this->sth->rowCount();
	}

	public function debugDumpParams(){
		return $this->sth->debugDumpParams();
	}
}
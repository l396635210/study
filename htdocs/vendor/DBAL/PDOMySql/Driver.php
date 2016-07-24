<?php 

namespace DBAL\PDOMySql;
use DBAL\Resources\MySql;
use DBAL\Resources\MySqlException;

class Driver {
	
	protected $dsn = "mysql:";
	protected $user;
	protected $password;
	protected $confDir;
	protected $env;
	public function connect(){

		$this->config();
		try {
			$dbh = new \PDO($this->dsn, $this->user, $this->password);
			if($this->env=='dev'){
				$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			}
		} catch (\PDOException $e) {
			$title = "数据库连接失败";
			$error = "Error!: " . iconv("gbk", "UTF-8", $e->getMessage());
			MySqlException::show($title, $error);
			die;
		}
		return $dbh;
	}
	
	protected function config(){

		if(defined('__ROOT__'))
			$conf = __ROOT__.'/../app/config/mysql.ini';
		else
			$conf = getcwd().'/app/config/mysql.ini';

		$this->confDir = substr($conf,0, strripos($conf,'/'));
		$conf = parse_ini_file($conf);
		
		foreach($conf['dsn'] as $key=>$val){
			$this->dsn .= "$key=$val;";
		}
		MySql::myConf(['dbname', $conf['dsn']['dbname']]);
		$this->user 	= $conf['user'];
		$this->password = $conf['password'];
		$this->env		= $conf['env'];
		
	}
}

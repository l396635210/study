<?php

namespace AppBundle\Entity;

use DBAL\ORM\Entity;

class User extends Entity{
	
	protected $username = ['type' => 'char', 'length'=>40, 'comment'=>'姓名'];
	
	protected $account = ['type' => 'char', 'length'=>40, 'comment'=>'帐号', 'unique'=>'unique'];
	
	protected $email = ['type' => 'email', 'length'=>40, 'comment'=>'email', 'unique'=>'unique'];
	
	protected $password = ['type' => 'password', 'length'=>60, 'comment'=>'密码'];
	
	protected $status = ['type'=>'bool', 'comment'=>'状态'];
	
	protected $lastLogin = ['type'=>'timestamp', 'comment'=>'上次登陆时间'];
	
	protected $createTime = ['type'=>'timestamp', 'comment'=>'创建时间'];
	
	protected $updateTime = ['type'=>'timestamp', 'comment'=>'修改时间'];
	
	protected $role		  = ['type'=>'char', 'length'=>20, 'comment'=>'角色', 'notNull'=>'default NULL'];
	
}
<?php

namespace AppBundle\Entity;

use DBAL\ORM\Entity;

class Article extends Entity{
	
	
	protected $title = 			['type' => 'char', 'length'=>40, 'comment'=>'标题'];
	
	protected $content = 		['type'=>'text',   'comment'=>'内容'];
	
	protected $categoryId  = 	['type'=>'int',    'comment'=>'栏目id'];
	
	protected $status = 		['type'=>'bool',   'comment'=>'状态'];
	
	protected $publishTime = 	['type'=>'timestamp', 'comment'=>'发布时间'];
	
	protected $publishUser = 	['type'=>'int', 	   'comment'=>'发布人'];
	
	protected $createTime = 	['type'=>'timestamp', 'comment'=>'创建时间'];
	
	protected $createUser = 	['type'=>'int', 'comment'=>'创建人'];
	
	protected $updateTime = 	['type'=>'timestamp', 'comment'=>'修改时间'];
	
	protected $updateUser = 	['type'=>'int', 'comment'=>'修改人'];
	
}
<?php

namespace AppBundle\Entity;

use DBAL\ORM\Entity;

class Category extends Entity{

	protected $title	  = ['type'=>'char', 'length'=>40, 'comment'=>'标题'];
	
	protected $descr	  = ['type'=>'varchar', 'comment'=>'描述'];
	
	protected $createTime = ['type'=>'timestamp', 'comment'=>'创建时间'];
	
	protected $createUser = ['type'=>'int', 'comment'=>'创建人'];
	
	protected $updateTime = ['type'=>'timestamp', 'comment'=>'修改时间'];
	
	protected $updateUser = ['type'=>'int', 'comment'=>'修改人'];	
	
}
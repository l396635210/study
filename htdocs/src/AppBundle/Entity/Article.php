<?php

namespace AppBundle\Entity;

use DBAL\ORM\Entity;
use Study\Core\Security\SessionStorage;

class Article extends Entity{
	
	protected $title = 			['type' => 'char', 'length'=>40, 'comment'=>'标题'];
	
	protected $content = 		['type'=>'text',   'comment'=>'内容'];
	
	protected $categoryId  = 	['type'=>'int',    'comment'=>'栏目id'];
	
	protected $status = 		['type'=>'bool',   'comment'=>'状态'];

    #protected $publishDate = 	['type'=>'date', 'comment'=>'发布时间'];

	protected $publishTime = 	['type'=>'timestamp', 'comment'=>'发布时间'];
	
	protected $publishUser = 	['type'=>'int', 	   'comment'=>'发布人'];

    #protected $createDate = 	['type'=>'date', 'comment'=>'创建时间'];

	protected $createTime = 	['type'=>'timestamp', 'comment'=>'创建时间'];
	
	protected $createUser = 	['type'=>'int', 'comment'=>'创建人'];

   # protected $updateDate = 	['type'=>'date', 'comment'=>'修改时间'];

	protected $updateTime = 	['type'=>'timestamp', 'comment'=>'修改时间'];
	
	protected $updateUser = 	['type'=>'int', 'comment'=>'修改人'];

	protected $picture	  = 	['type'=>'varchar', 'comment'=>'图片'];

	public function setInsertDefaultValue(){
		$this->status = 1;
		$this->createTime  = $this->publishTime = $this->updateTime = date('Y-m-d H:i:s');
		$this->createUser  = $this->publishUser = $this->updateUser = $this->getUser()->getId();
	}

	public function setUpdateDefaultValue(){
		$this->publishTime = $this->updateTime = date('Y-m-d H:i:s');
		$this->publishUser = $this->updateUser = $this->getUser()->getId();
	}
}
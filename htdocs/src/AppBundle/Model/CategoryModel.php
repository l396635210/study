<?php

namespace AppBundle\Model;

use DBAL\ORM\Model;
use AppBundle\Entity\Category;
use Study\Resources\Request;

class CategoryModel extends Model{

    public function findAll()
    {
        return $this->findBy(['status','=',1],['id'=>'desc']);
    }

    public function findByPage(Request $request){
        return $this->findBy(['status','=',1],['id'=>'desc'],$request->pagination());
    }

    public function count(){
        $sql = "SELECT COUNT(1) AS cnt FROM {$this->entity->getTable()} WHERE 1=1 AND status = 1";
        $res = $this->createQuery($sql)->execute()->getFind(self::FIND_ONE);
        return $res['cnt'];
    }

}
<?php

namespace AppBundle\Model;

use DBAL\ORM\Model;
use AppBundle\Entity\Article;
use Study\Resources\Request;

class ArticleModel extends Model{

    public function findAll()
    {
        return $this->findBy(['status','=',1],['id'=>'desc']);
    }

    public function findByPage(Request $request){
        $sql = "SELECT a.id AS id ,
                a.title AS title ,
                a.content AS content ,
                a.picture AS picture ,
                a.publish_time AS pTime ,
                c.id AS cId,
                c.title AS cTitle
                FROM article AS a
                JOIN category AS c
                ON a.category_id = c.id
                WHERE 1=1
                AND a.status = :_a_status
                ORDER BY a.id DESC
                LIMIT ".implode(',',$request->pagination());
        return $this->createQuery($sql)->setParam([':_a_status'=>1]);
        #return $this->findBy(['status','=',1],['id'=>'desc'],$request->pagination());
    }

    public function count(){

    }

}
<?php

namespace AppBundle\Model;

use DBAL\ORM\Model;
use AppBundle\Entity\User;

class UserModel extends Model{
	
	public function validAuthor($request){
		$post = $request->post('user');
		$user = $this->findBy(['account','=',$post['account']])->getFind('one');
		if( $user && password_verify($post['password'],$user['password']) ){
			$sessionStorage = $this->getContainer('session');
			$sessionStorage->set('user',$user);
			return true;
		}
		return false;
	}
}
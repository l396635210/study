<?php

namespace AppBundle\Controller;

use Study\Core\Controller;
use Study\Core\Route;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class UserController extends Controller{
	
	
	/**
	 * @Route('/register', 'user_create')
	 */
	public function create($request){
		
		$form = $this->createForm(new UserType());
		$form->handleRequest($request);

		if($form->isSubmit() && $form->isValid()){
			$user = $form->getData();
			$user->setStatus(true);
			$user->setLastLogin(date('Y-m-d H:i:s'));
			$user->setCreateTime(date('Y-m-d H:i:s'));
			$user->setUpdateTime(date('Y-m-d H:i:s'));
			$user->setRole('user');
			$this->getModel('user')->insert($user);
			
			addSuccess(['success'=>"注册成功"]);

			return $this->redirectToRoute('home',success('all'));
		}
		return $this->render('user/create.chip.php', [
			'form'	=> $form,
		]);
	}
	
	/**
	 * @Route('/login', 'user_login')
	 */
	public function login($request){
		$form = $this->createForm(new UserType());
		$form->handleRequest($request);

		if($form->isSubmit()){
			if($this->getModel('user')->validAuthor($request)){
				addSuccess(['success'=>"登陆成功"]);
				return $this->redirectToRoute('admin', success('all'));
			}
		}
		return $this->render('user/login.chip.php', [
			'form'	=> $form,
		]);
	}
}
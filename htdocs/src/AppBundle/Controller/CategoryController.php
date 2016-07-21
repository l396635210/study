<?php

namespace AppBundle\Controller;

use Study\Core\Controller;
use Study\Core\Route;

use AppBundle\Form\CategoryType;

class CategoryController extends Controller{
	
	/**
	 * @Route('/admin/category/list', 'category_list')
	 */
	public function index($request){
		$list = $this->getModel('category')
			->findAll()
			->getFind();
			
		return $this->render('category/index.chip.php', [
			'list'	=> $list
		]);
	}
	
	/**
	 * @Route('/admin/category/edit/{id}', 'category_edit')
	 */
	public function edit($request){
		$details = $this->getModel('category')
			->findOne($request->get('id'))
			->getFind('one');
		$form = $this->createForm(new CategoryType(), $details);
		
		$form->handleRequest($request);
		
		if($form->isSubmit() && $form->isValid()){
			$category = $form->getData();
			$category->setUpdateTime(date('Y-m-d H:i:s'));
			$user = $this->getUser();
			$category->setUpdateUser($user['id']);
			$this->getModel('category')->update($category);
		}
		
		return $this->render('category/edit.chip.php', [
			'category'	=> $details,
			'form'		=> $form,
		]);
	}

}
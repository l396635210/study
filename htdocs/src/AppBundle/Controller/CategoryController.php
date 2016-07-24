<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
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

		return $this->render('admin/category/index.chip.php', [
			'list'	=> $list,
			'title'	=> '栏目管理',
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
			$res = $this->getModel('category')->update($category);

			if($res){
				$this->_addSuccess("修改{$res}条记录");
				$this->redirectToRoute('category_list');
			}

		}
		
		return $this->render('admin/category/create.chip.php', [
			'category'	=> $details,
			'form'		=> $form->view(),
		]);
	}

	/**
	 * @Route('/admin/category/create', 'category_create')
	 */
	public function create($request){
		$form = $this->createForm(new CategoryType(), new Category());

		$form->handleRequest($request);

		if($form->isSubmit() && $form->isValid()){
			$category = $form->getData();
			$category->setCreateTime(date('Y-m-d H:i:s'));
			$user = $this->getUser();
			$category->setCreateUser($user['id']);
			$category->setUpdateTime(date('Y-m-d H:i:s'));
			$category->setUpdateUser($user['id']);
			$res = $this->getModel('category')->insert($category);

			if($res){
				$this->_addSuccess('添加'.$category->getTitle().'成功');
				$this->redirectToRoute('category_list');
			}

		}

		return $this->render('admin/category/create.chip.php', [
			'form'		=> $form->view(),
		]);

	}

}
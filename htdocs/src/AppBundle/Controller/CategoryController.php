<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Study\Core\Controller;
use Study\Core\Route;

use AppBundle\Form\CategoryType;

class CategoryController extends Controller{
	
	/**
	 * @Route('/admin/category/list/{page}', 'category_list')
	 */
	public function index($request){

		$model = $this->getModel('category');
		$list = $model ->findByPage($request)
			->getFind();

		$cnt = $model->count();

		return $this->render('admin/category/index.chip.php', [
			'page' => $request->get('page'),
			'cnt'	=> $cnt,
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

		if($form->isSubmit()){
			if($form->isValid()) {
				$category = $form->getData();
				$category->setUpdateTime(date('Y-m-d H:i:s'));
				$category->setUpdateUser($this->getUser()->getId());
				$res = $this->getModel('category')->update($category);

				if ($res) {
					$alert = $this->_addSuccess("修改{$category->getTitle()}成功");
					return $this->jsonResponse(['res' => $res, 'alert' => $alert]);
				}
				return $this->jsonResponse(['error'=>errors('all')]);
			}
		}
		
		return $this->render('admin/category/create.chip.php', [
			'action'	=> path(['category_edit',['id'=>$details['id']]]),
			'form'		=> $form->view(),
            'title'	=> '栏目管理',
		]);
	}

	/**
	 * @Route('/admin/category/create', 'category_create')
	 */
	public function create($request){
		$form = $this->createForm(new CategoryType(), new Category());

		$form->handleRequest($request);
		if($form->isSubmit()){
			if($form->isValid()){
				$category = $form->getData();
				$category->setStatus(true);
				$category->setCreateTime(date('Y-m-d H:i:s'));
				$category->setCreateUser($this->getUser()->getId());
				$category->setUpdateTime(date('Y-m-d H:i:s'));
				$category->setUpdateUser($this->getUser()->getId());
				$res = $this->getModel('category')->insert($category);

				if($res){
					$alert = $this->_addSuccess('添加'.$category->getTitle().'成功');
					#$this->redirectToRoute('category_list');
					return $this->jsonResponse(['res'=>$res, 'alert'=>$alert]);
				}
			}
			return $this->jsonResponse(['error'=>errors('all')]);

		}

		return $this->render('admin/category/create.chip.php', [
			'action'	=> path('category_create'),
			'form'		=> $form->view(),
            'title'	=> '栏目管理',
		]);

	}

	/**
	 * @Route('/admin/category/delete/{id}', 'category_delete')
	 */
	public function delete($request){
		$category = new Category();
		$category->setId($request->get('id'));
		$res = $this->getModel('category')->delete($category);
		if($res){
			$alert = $this->_addSuccess('删除'.$category->getTitle().'成功');
			#$this->redirectToRoute('category_list');
			return $this->jsonResponse(['res'=>$res, 'alert'=>$alert]);
		}
	}


}
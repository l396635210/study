<?php

namespace AppBundle\Controller;

use Study\Core\Controller;
use Study\Core\Route;

use AppBundle\Entity\Article;

use AppBundle\Form\ArticleType;

class DefaultController extends Controller{
	
	/**
	 * @Route('/', 'home')
	 */
	public function index($request){
		$list = $this->getModel('article')->findAll()->getFind();
		$str = ':title';
		
		return $this->render('default/index.chip.php', [
			'list' => $list,
		]);
		
	}
	
	/**
	 * @Route('/default/list/page/{page}', 'default_list')
	 */
	public function listAction($request){
		
		return $this->render('default/index.chip.php', [
			#'str' => $str,
			#'list' => $list,
		]);
	}
	
	/**
	 * @Route('/default/{id}', 'default_show')
	 */
	public function show($request){
		$title = 'title';
		$list = $this->getModel('article')->setParam([':title'=>$title])->findBy(['title','=',':title']);
		return $this->render('default/index.chip.php', [
			#'str' => $str,
			'list' => $list,
		]);
	}
	
	/**
	 * @Route('/default/create', 'default_create')
	 */
	public function create($request){
		$form = $this->createForm(new ArticleType(), new Article());
		
		$form->handleRequest($request);

		if($form->isSubmit() && $form->isValid()){
			$article = $form->getData();
			$article->setStatus(true);
			$article->setPublishTime(date('Y-m-d H:i:s'));
			$article->setPublishUser(1);
			$article->setCreateTime(date('Y-m-d H:i:s'));
			$article->setCreateUser(1);
			$article->setUpdateTime(date('Y-m-d H:i:s'));
			$article->setUpdateUser(1);
			$this->getModel('article')->insert($article);
			
			addSuccess(['success'=>"添加{$article->getTitle()}成功！"]);
			return $this->redirectToRoute('home', success('all'));
		}
		return $this->render('default/create.chip.php', [
			'form'	=> $form,
		]);
	}
}
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

		return $this->render('home/index.chip.php', [
			'list' => $list,
		]);
		
	}

	/**
	 * @Route('/admin', 'admin')
	 */
	public function admin($request){
		return $this->render('admin/index.chip.php', [
			'title'	=> '后台管理',
		]);
	}

}
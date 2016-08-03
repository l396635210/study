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

		$model = $this->getModel('article');

		$about = $model->findOne(1)->getFind('one');

		$new = $model->findBy(['status','=',1],['id'=>'desc'],[0,1])->getFind('one');
		return $this->render('home/index.chip.php', [
			'about'	=> $about,
			'new'	=> $new,
		]);
		
	}

	/**
	 * @Route('/welcome', 'welcome')
	 */
	public function welcome($request){

        $model = $this->getModel('article');
        $about = $model->findOne(1)->getFind();

        $new = $model->findBy(['status','=',1],['id'=>'desc'],[0,1])->getFind('one');

		return $this->render('home/welcome.chip.php', [
			'about'	=> $about,
			'new'	=> $new,
		]);

		return $this->render('home/welcome.chip.php', [
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
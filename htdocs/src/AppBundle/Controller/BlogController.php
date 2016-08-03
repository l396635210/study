<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Study\Core\Controller;
use Study\Resources\Request;

class BlogController extends  Controller{

    /**
     * @Route('/blog', 'blog_index')
     */
    public function index(Request $request){
        $model = $this->getModel('article');
        $cnt = $model->countBy(['status','=',1])
                ->getCount();
        $list = $model->findByPage($request)
                ->getFind();
        return $this->render('home/blog/index.chip.php',[
            'page' => $request->get('page'),
            'cnt'	=> $cnt,
            'list'	=> $list,
            'title'	=> 'My Blog',
        ]);
    }

    /**
     * @param Request $request
     * @Route('/blog/{id}', 'blog_show')
     */
    public function show(Request $request){
        $detail = $this->getModel('article')
            ->findOne($request->get('id'))
            ->getFind('one');
        return $this->render('home/blog/show.chip.php',[
            'article'     => $detail,
        ]);
    }

}
<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Study\Core\Controller;
use Study\Resources\Request;
use Tool\Resources\FileTool;

class ArticleController extends  Controller{

    /**
     * @Route('/admin/article/list/{page}', 'article_list')
     */
    public function index(Request $request){
        $model = $this->getModel('article');
        $cnt = $model->countBy(['status','=',1])
                ->getCount();
        $list = $model->findByPage($request)
                ->getFind();
        return $this->render('admin/article/index.chip.php',[
            'page' => $request->get('page'),
            'cnt'	=> $cnt,
            'list'	=> $list,
            'title'	=> '文章管理',
        ]);
    }

    /**
     * @param Request $request
     * @Route('/admin/article/create', 'article_create')
     */
    public function create(Request $request){
        $form = $this->createForm(new ArticleType(), new Article());

        $form->handleRequest($request);
        if($form->isSubmit()){
            if($form->isValid()){
                //insert操作
                $article = $form->getData();
                $article->setInsertDefaultValue();
                $res = $this->getModel('article')->insert($article);
                if($res){
                    $alert = $this->_addSuccess('添加'.$article->getTitle().'成功');
                    #$this->redirectToRoute('category_list');
                    return $this->jsonResponse(['res'=>$res, 'alert'=>$alert]);
                }
            }
            return $this->jsonResponse(['error'=>errors('all')]);
        }
        return $this->render('admin/article/create.chip.php',[
            'action'	=> path('article_create'),
            'form'		=> $form->view(),
            'title'	=> '文章管理-写',
        ]);
    }

    /**
     * @param Request $request
     * @Route('/admin/article/edit/{id}', 'article_edit')
     */
    public function edit(Request $request){
        $detail = $this->getModel('article')
            ->findOne($request->get('id'))
            ->getFind('one');

        $form = $this->createForm(new ArticleType(), $detail);

        $form->handleRequest($request);

        if($form->isSubmit()){
            if($form->isValid()){
                //update
                $article = $form->getData();
                $article->setUpdateDefaultValue();
                $res = $this->getModel('article')->update($article);

                if($res){
                    $alert = $this->_addSuccess("修改{$article->getTitle()}成功");
                    return $this->jsonResponse(['res'=>$res, 'alert'=>$alert]);
                }
            }else{
                return $this->jsonResponse(['error'=>errors('all')]);
            }
        }

        return $this->render('admin/article/create.chip.php',[
            'action'    => path([ 'article_edit',['id'=>$detail['id']] ]),
            'form'      => $form->view(),
            'title'     => '文章管理-改',
        ]);
    }

    /**
     * @param Request $request
     * @Route('/admin/article/delete/{id}','article_delete')
     */
    public function delete(Request $request){
        $article = new Article();
        $article->setId($request->get('id'));
        $res = $this->getModel('article')->delete($article);
        if($res){
            $alert = $this->_addSuccess('删除'.$article->getTitle().'成功');
            #$this->redirectToRoute('category_list');
            return $this->jsonResponse(['res'=>$res, 'alert'=>$alert]);
        }
    }
}
<?php

namespace AppBundle\Form;

use Study\Core\Form\FormType;
use AppBundle\Entity\Article;
class ArticleType extends FormType{
	
	public function buildForm( $form, $entity=NULL){
		$form->add('title', self::TEXT, ['label'=>'标题'
			, 'attr'=>"class='form-control' placeholder='请输入标题'"])
			 ->add('categoryId', self::ENTITY, ['label'=>'栏目','option'=>'AppBundle:Category'
			, 'option_label'=>'title', 'attr'=>"class='form-control'"])
			 ->add('content', self::TEXTAREA, ['label'=>'内容'
			, 'attr'=>"class='form-control'"]);
	}
	
	public function configOptions(){
		$this->options['entity'] = new Article();
	}
}
<?php

namespace AppBundle\Form;

use Study\Core\Form\FormType;
use AppBundle\Entity\Category;

class CategoryType extends FormType{
	
	public function buildForm( $form , $entity){
		$form->add('title', self::TEXT, ['label'=>'标题'
			, 'attr'=>"class='form-control' placeholder='请输入标题'"])
			 ->add('descr', self::TEXTAREA, ['label'=>'描述'
			, 'attr'=>"class='form-control'"]);
	}
	
	public function configOptions( $category ){
		$this->options['entity'] = new Category( $category );
	}
}
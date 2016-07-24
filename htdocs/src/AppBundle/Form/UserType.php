<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Study\Core\Form\FormType;

class UserType extends FormType{
	
	public function buildForm( $form , $entity){
		$form->add('username', self::TEXT, ['label'=>'姓名'
			, 'attr'=>"class='form-control' placeholder='最多输入10个字'"])
			 ->add('account', self::TEXT, ['label'=>'帐号'
			, 'attr'=>"class='form-control'"])
			 ->add('email', self::TEXT, ['label'=>'Email'
			, 'attr'=>"class='form-control'"])
			 ->add('password', self::PASSWORD, ['label'=>'密码'
			, 'attr'=>"class='form-control'"]);
			
	}
	
	public function configOptions( $user ){
		$this->options['entity'] = new User( $user );
	}
	
}
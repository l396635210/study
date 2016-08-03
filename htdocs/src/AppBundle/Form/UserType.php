<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Study\Core\Form\Form;
use Study\Core\Form\FormType;

class UserType extends FormType{
	
	public function buildForm(Form $form , $entity){
		$form->add('username', self::TEXT, ['label'=>'姓名'
			, 'attr'=>"class='form-control' placeholder='最多输入10个字'"])
			 ->add('account', self::TEXT, ['label'=>'帐号'
			, 'attr'=>"class='login-control m-b-10' placeholder='Username'"])
			 ->add('email', self::TEXT, ['label'=>'Email'
			, 'attr'=>"class='form-control'"])
			 ->add('password', self::PASSWORD, ['label'=>'密码'
			, 'attr'=>"class='login-control' placeholder='Password'"]);
			
	}
	
	public function configOptions( $user ){
		$this->options['entity'] = new User( $user );
	}
	
}
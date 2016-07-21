<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Study\Core\Form\FormType;

class UserType extends FormType{
	
	public function buildForm( $form ){
		$string = '����������10����';
		$encode = mb_detect_encoding($string, array("ASCII","UTF-8","GB2312","GBK",'BIG5')); 
		$form->add('username', self::TEXT, ['label'=>'����'
			, 'attr'=>"class='form-control' placeholder='����������10����'"])
			 ->add('account', self::TEXT, ['label'=>'�ʺ�'
			, 'attr'=>"class='form-control'"])
			 ->add('email', self::TEXT, ['label'=>'Email'
			, 'attr'=>"class='form-control'"])
			 ->add('password', self::PASSWORD, ['label'=>'����'
			, 'attr'=>"class='form-control'"]);
			
	}
	
	public function configOptions(){
		$this->options['entity'] = new User();
	}
	
}
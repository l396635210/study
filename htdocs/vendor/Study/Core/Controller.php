<?php

namespace Study\Core;

use Study\Core\Template;
use Study\Core\Form\Form;
use Study\Resources\Debug;
use Study\Resources\Request;

class Controller{
	
	protected $template;
	protected $view;
	protected $kernel;
	
	protected $form;
	
	protected $bundleSpace;
	protected $modelSpace;
	protected $entitySpace;
	
	public function __construct($kernel){
		$this->template = new Template($kernel);
		$this->kernel = $kernel;
		$bundleSpace = explode('\\',get_class($this))[0];
		$this->modelSpace = $bundleSpace.'\\Model\\';
		$this->entitySpace = $bundleSpace.'\\Entity\\';
	}
	
	protected function get($name){
		return $this->kernel->get($name);
	}
	
	protected function render($view, array $parameters = array()){
		$build_start = microtime(true);
		$response = $this->template->render($view, $parameters);
		$build_end = microtime(true);
		Debug::addDebug('build_runtime', (int)(($build_end - $build_start)*1000));
		return $response;
	}
	
	protected function getModel($entity){
		if(is_string($entity)){
			$Model = $this->modelSpace . ucfirst($entity).'Model';
			$Entity = $this->entitySpace . ucfirst($entity);
			$entity = new $Entity();
		}
		return new $Model( $entity );
	}

    /**
     * @param $formType 子类formType
     * @param $entity 子类实体
     * @return Form
     */
	protected function createForm( $formType, $entity){
		$this->form = new Form();

		$this->form->createForm( $formType, $entity);
		return $this->form;
	}
	
	protected function redirectToRoute( $name, $parameters = array()){
		$route = route($name);
		$rootURI = $_SERVER['SERVER_NAME'].$_SERVER['CONTEXT_PREFIX'].'index.php';
 		header("location:http://$rootURI"."{$route['url']}");
		
	}
	
	protected function getUser(){
		return $this->kernel->getUser();
	}

	protected function addFlash($type, $message){
		$sessionStorage = $this->get('session');
		$sessionStorage->set($type, $message);
	}

	protected function _addSuccess($message){
		$message = '<p class=\'alert alert-success\'>提示：'.$message.'</p>';
		$this->addFlash('success', $message);
		return $message;
	}

	protected function jsonResponse($arr){
		echo json_encode($arr);
		die;
	}
}

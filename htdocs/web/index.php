<?php

use Study\Resources\Request;

$loader = require __DIR__.'/../app/autoload.php';

define('__ROOT__', $_SERVER['CONTEXT_DOCUMENT_ROOT']);
		
$kernel = new AppKernel('dev',true);

$request = Request::setRequest($_POST, $_GET);

$template = $kernel->handle($request);

if(method_exists($template, 'display')){
	$template->display();	
}

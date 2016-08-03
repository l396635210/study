<?php

use Study\Resources\Request;
session_start();
$loader = require __DIR__.'/../app/autoload.php';

$kernel = new AppKernel('dev',true);

$request = Request::setRequest($_POST, $_GET);

$template = $kernel->handle($request);
if(method_exists($template, 'display')){
	$template->display();	
}else{
	echo "controller中action方法没有返回值";
}
$kernel->terminate();

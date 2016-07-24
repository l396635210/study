<?php
namespace cache\chip;
class blank_chip {

protected $parameters;
public function __construct($parameters){

			$this->parameters = $parameters;

		}
public function display(){
 echo"";
$this->struct_head();
 echo "  ";
$this->struct_body();
 echo "  ";
$this->struct_foot();
 echo "";
}
public function struct_head (){
 echo "";
}
public function struct_body (){
 echo "";
}
public function struct_foot (){
 echo "";
}
}
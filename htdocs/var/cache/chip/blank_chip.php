<?php
namespace cache\chip;
class blank_chip {

protected $parameters;
public function __construct($parameters){

			$this->parameters = $parameters;

		}
public function display(){
 echo"";
$this->struct_css();
 echo "  <div id=\"alert\" class=\"block-area\">";
$this->struct_alert();
 echo "</div>  ";
$this->struct_body();
 echo "  ";
$this->struct_js();
 echo "";
}
public function struct_css (){
 echo "";
}
public function struct_alert (){
 echo "";
}
public function struct_body (){
 echo "";
}
public function struct_js (){
 echo "";
}
}
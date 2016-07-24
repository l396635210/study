<?php
namespace cache\chip;
class user_chip {

protected $parameters;
public function __construct($parameters){

			$this->parameters = $parameters;

		}
public function display(){
 echo"<!DOCTYPE html>  <html lang=\"zh-CN\">  <head>      <meta charset=\"UTF-8\"/>   <title>";
$this->struct_title();
 echo "</title>      <link href=\"http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css\" rel=\"stylesheet\">      <link crossorigin=\"anonymous\" href=\"https://assets-cdn.github.com/assets/github-5e4edcfc690fbfc4db1e4a54b57a1d37b3d02fe753300746845a9c204c1d0470.css\" media=\"all\" rel=\"stylesheet\" />   ";
$this->struct_stylesheet();
 echo "  </head>  <body>  <div class=\"container\">   ";
$this->struct_body();
 echo "   <footer>";
$this->struct_foot();
 echo "</footer>  </div><!-- /.container -->    <script src=\"http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js\"></script>  <script src=\"http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js\"></script>  ";
$this->struct_script();
 echo "    </body>  </html>";
}
public function struct_title (){
 echo "";
}
public function struct_stylesheet (){
 echo "";
}
public function struct_body (){
 echo "";
}
public function struct_foot (){
 echo "";
}
public function struct_script (){
 echo "";
}
}
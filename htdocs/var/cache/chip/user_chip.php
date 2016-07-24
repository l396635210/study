<?php
namespace cache\chip;
class user_chip {

protected $parameters;
public function __construct($parameters){

			$this->parameters = $parameters;

		}
public function display(){
 echo"<!DOCTYPE html>  <head>   <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0\" />   <meta name=\"format-detection\" content=\"telephone=no\">   <meta charset=\"UTF-8\">     <meta name=\"description\" content=\"Violate Responsive Admin Template\">   <meta name=\"keywords\" content=\"Super Admin, Admin, Template, Bootstrap\">     <title>后台管理</title>   <!-- CSS -->   <link href=\"/std/assets/common/css/bootstrap.min.css\" rel=\"stylesheet\">   <link href=\"/std/assets/admin/css/form.css\" rel=\"stylesheet\">   <link href=\"/std/assets/admin/css/style.css\" rel=\"stylesheet\">   <link href=\"/std/assets/admin/css/animate.css\" rel=\"stylesheet\">   <link href=\"/std/assets/admin/css/generics.css\" rel=\"stylesheet\">  </head>  <body id=\"skin-blur-violate\">  <section id=\"login\">   ";
$this->struct_body();
 echo "  </section>    <!-- Javascript Libraries -->  <!-- jQuery -->  <script src=\"/std/assets/common/js/jquery.min.js\"></script> <!-- jQuery Library -->    <!-- Bootstrap -->  <script src=\"/std/assets/common/js/bootstrap.min.js\"></script>  <!--  Form Related -->  <script src=\"/std/assets/admin/js/icheck.js\"></script> <!-- Custom Checkbox + Radio -->  <!-- All JS functions -->  <script src=\"/std/assets/admin/js/functions.js\"></script>  </body>  </html>  ";
}
public function struct_body (){
 echo "";
}
}
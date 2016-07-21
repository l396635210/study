<?php
namespace cache\chip;
class base_chip {

protected $parameters;
public function __construct($parameters){

			$this->parameters = $parameters;

		}
public function display(){
 echo"<!DOCTYPE html>  <html lang=\"zh-CN\">    <head>      <meta charset=\"utf-8\">      <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">      <title>";
$this->struct_title();
 echo "</title>      <!-- Bootstrap core CSS -->      <link href=\"http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css\" rel=\"stylesheet\">   <style>   body {     padding-top: 50px;   }   .starter-template {     padding: 40px 15px;     text-align: center;   }   </style>   ";
$this->struct_stylesheet();
 echo "    </head>      <body>        <nav class=\"navbar navbar-inverse navbar-fixed-top\">        <div class=\"container\">          <div class=\"navbar-header\">            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">              <span class=\"sr-only\">Toggle navigation</span>              <span class=\"icon-bar\"></span>              <span class=\"icon-bar\"></span>              <span class=\"icon-bar\"></span>            </button>            <a class=\"navbar-brand\" href=\"#\">Project name</a>          </div>          <div id=\"navbar\" class=\"collapse navbar-collapse\">            <ul class=\"nav navbar-nav\">              <li class=\"active\"><a href=\"#\">Home</a></li>              <li><a href=\"#about\">About</a></li>              <li><a href=\"#contact\">Contact</a></li>            </ul>          </div><!--/.nav-collapse -->        </div>      </nav>        <div class=\"container\">    ";
$this->struct_body();
 echo "            <footer>    ";
$this->struct_foot();
 echo "     </footer>           </div><!-- /.container -->          <!-- Bootstrap core JavaScript      ================================================== -->      <!-- Placed at the end of the document so the pages load faster -->      <script src=\"http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js\"></script>      <script src=\"http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js\"></script>      ";
$this->struct_script();
 echo "    </body>  </html>  ";
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
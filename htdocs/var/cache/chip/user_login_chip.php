<?php
namespace cache\chip;
class user_login_chip  extends user_chip {
    public function struct_body (){
 echo "  <header>   <h1>管理</h1>   <p>";
foreach(errors('all') as $error){
echo $error;
}
echo"</p>  </header>    <div class=\"clearfix\"></div>    <!-- Login -->  ";
echo $this->parameters['form']->start(" "," class='box tile animated active' id='box-login'");
echo "  <h2 class=\"m-t-0 m-b-15\">Login</h2>  ";
echo $this->parameters['form']->row('account');
echo "  ";
echo $this->parameters['form']->row('password');
echo "  <div class=\"checkbox m-b-20\">  </div>  <button class=\"btn btn-sm m-r-5\">Sing In</button>  ";
echo $this->parameters['form']->end();
echo "  ";
}
}
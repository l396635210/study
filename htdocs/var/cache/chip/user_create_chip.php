<?php
namespace cache\chip;
class user_create_chip  extends user_chip {
    public function struct_body (){
 echo "  <div class=\"row\">   <div class=\"col-md-12\">    ";
foreach(errors('all') as $error){
echo $error;
}
echo"   </div>  </div>  <div class=\"row\">   <div class=\"auth-form\">    <div class=\"auth-form-header\">     <h1>注册</h1>    </div>      <div class=\"auth-form-body\">    ";
echo $this->parameters['form']->start();
echo "    <div class=\"form-group\">    ";
echo $this->parameters['form']->row('username');
echo "    </div>    <div class=\"form-group\">    ";
echo $this->parameters['form']->row('account');
echo "    </div>    <div class=\"form-group\">    ";
echo $this->parameters['form']->row('email');
echo "    </div>    <div class=\"form-group\">    ";
echo $this->parameters['form']->row('password');
echo "    </div>    <button type=\"submit\" class=\"btn btn-primary btn-block\"  value=\"submit\" />提交</button>    ";
echo $this->parameters['form']->end();
echo "    </div>   </div>  </div>   ";
}
}
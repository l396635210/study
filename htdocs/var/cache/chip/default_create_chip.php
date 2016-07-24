<?php
namespace cache\chip;
class default_create_chip  extends base_chip {
  public function struct_body (){
 echo "  <div class=\"row\">   <div class=\"col-md-12\">    ";
foreach(errors('all') as $error){
echo $error;
}
echo"   </div>   <div class=\"col-md-12\">    ";
echo $this->parameters['form']->start();
echo "    <div class='form-group'>    ";
echo $this->parameters['form']->row('title');
echo "    </div>    <div class='form-group'>    ";
echo $this->parameters['form']->row('categoryId');
echo "    </div>    <div class='form-group'>    ";
echo $this->parameters['form']->row('content');
echo "    </div>    <div class='form-group'>    <button type=\"submit\" class=\"btn btn-primary\">提交</button>    <button type=\"reset\" class=\"btn\">取消</button>    </div>    ";
echo $this->parameters['form']->end();
echo "    <!--";
if(isset($this->parameters['list']) ? $this->parameters['list'] : $list ):
echo "     ";
foreach(isset($this->parameters['list']) ? $this->parameters['list'] : $list as $item):
echo"      ";
echo $item['id'];
echo" ";
echo $item['title'];
echo"     ";
endforeach;
echo "    ";
endif;
echo "-->   </div>  </div>  ";
}
}
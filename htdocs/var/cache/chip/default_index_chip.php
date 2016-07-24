<?php
namespace cache\chip;
class default_index_chip  extends base_chip {
  public function struct_body (){
 echo "   <div class=\"row\">   <div class=\"col-md-12\">    ";
echo isset($_SESSION['success']) ? $_SESSION['success'] : "";unset($_SESSION['success']);
echo"    ";
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
echo "   </div>   </div>  ";
}
}
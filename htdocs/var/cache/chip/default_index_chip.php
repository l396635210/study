<?php
namespace cache\chip;
class default_index_chip  extends base_chip {
  public function struct_body (){
 echo "   <div class=\"row\">   <div class=\"col-md-12\">    ";
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
<?php
namespace cache\chip;
class category_create_chip  extends base_chip {
  public function struct_head (){
 echo "  <script src=\"//cdn.ckeditor.com/4.5.10/standard/ckeditor.js\"></script>  ";
}    public function struct_body (){
 echo "  <div class=\"row\">   <div class=\"col-md-12\">    ";
foreach(errors('all') as $error){
echo $error;
}
echo"   </div>   <div class=\"col-md-12\">    ";
echo $this->parameters['form']->start();
echo "    <div class='form-group'>    ";
echo $this->parameters['form']->row('title');
echo "    </div>    <div class='form-group'>    ";
echo $this->parameters['form']->row('descr');
echo "    </div>    <div class='form-group'>    <button type=\"submit\" class=\"btn btn-primary\">提交</button>    <button type=\"reset\" class=\"btn\">取消</button>    </div>    ";
echo $this->parameters['form']->end();
echo "   </div>  </div>  ";
}    public function struct_script (){
 echo "  <script>   CKEDITOR.replace( 'category[descr]',{    filebrowserImageUploadUrl : \"";
echo path('upload');
echo "\"   } );  </script>  ";
}
}
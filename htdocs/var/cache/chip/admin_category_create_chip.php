<?php
namespace cache\chip;
class admin_category_create_chip  extends blank_chip {
    public function struct_head (){
 echo "    ";
}    public function struct_body (){
 echo "  ";
echo $this->parameters['form']->start("","");
echo "  <div class=\"block-area\">      ";
echo $this->parameters['form']->row('title');
echo "  </div>  <div class=\"block-area\">      ";
echo $this->parameters['form']->row('descr');
echo "  </div>  <div class=\"block-area\">      <button class=\"btn m-r-5\">提交</button>  </div>  ";
echo $this->parameters['form']->end();
echo "  ";
}  public function struct_foot (){
 echo "  <script src=\"/std/assets/admin/js/fileupload.min.js\"></script> <!-- File Upload -->  <script>      CKEDITOR.replace( 'category[descr]', {          filebrowserUploadUrl : \"actions/ckeditorUpload\"      });      var Category = function(){          var submit = '';      };  </script>  ";
}
}
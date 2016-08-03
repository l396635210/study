<?php
namespace cache\chip;
class admin_category_create_chip  extends blank_chip {
    public function struct_body (){
 echo "  <div class=\"block-area\">  <h2 class=\"page-title\">";
echo $this->parameters['title'];
echo "</h2>  ";
echo $this->parameters['form']->start("","");
echo "  <div class=\"block-area\">      ";
echo $this->parameters['form']->row('title');
echo "  </div>  <div class=\"hidden\">      ";
echo $this->parameters['form']->row('descr');
echo "  </div>  <div class=\"block-area\">      <div class=\"wysiwye-editor\"></div>  </div>  <div class=\"block-area\">      <button class=\"btn m-r-5 ajaxsubmit\">提交</button>  </div>  ";
echo $this->parameters['form']->end();
echo "  </div>  ";
}  public function struct_js (){
 echo "      <!-- Text Editor -->  <script src=\"/std/assets/admin/js/editor2.min.js\"></script> <!-- WYSIWYG Editor -->  <script src=\"/std/assets/admin/js/fileupload.min.js\"></script> <!-- File Upload -->  <script>          var CategoryDetail = function(){          this.submit = function(){              $(\"#form-category\").find('.ajaxsubmit').click(function(e){                  e.preventDefault();                  $(\"#form-category\").find(\"textarea\").val($(\".note-editable\").html());                  ajaxSubmit();              });                var ajaxSubmit = function(){                  $.post(\"";
echo $this->parameters['action'];
echo "\"                      , $(\"#form-category\").serialize()                      , function(data){                          data = eval(\"(\"+data+\")\");                          ajaxSubmitCallback(data);                  });              };                var ajaxSubmitCallback = function (data){                  console.log(data);                  if(data.res>0){                      console.log($(\"#aside-category\").find('.list'));                      $(\"#aside-category\").find('.list').click();                  }              }          };          /* Spinners */          var init = function(){              if($(\"#form-category\").find('.wysiwye-editor')) {                  $('.wysiwye-editor').summernote({                      height: 200                  });                  $(\".note-editable\").html($(\"#form-category\").find(\"textarea\").val());              }          };          init();      };        var categoryDetail = new CategoryDetail();      categoryDetail.submit();    </script>  ";
}
}
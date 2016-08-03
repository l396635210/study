<?php
namespace cache\chip;
class admin_article_create_chip  extends blank_chip {
    public function struct_body (){
 echo "    <div class=\"block-area\">  ";
echo $this->parameters['form']->start("","");
echo "  <div class=\"block-area\">      ";
echo $this->parameters['form']->row('title');
echo "  </div>  <div class=\"block-area\">      ";
echo $this->parameters['form']->row('categoryId');
echo "  </div>  <div class=\"hidden\">      ";
echo $this->parameters['form']->row('content');
echo "  </div>  <div class=\"block-area\">      <div class=\"wysiwye-editor\"></div>  </div>  <div class=\"hidden\">      ";
echo $this->parameters['form']->row('picture');
echo "  </div>  <div class=\"block-area block-image\">      <div class=\"fileupload fileupload-new\" data-provides=\"fileupload\">          <div class=\"fileupload-preview thumbnail form-control\"></div>          <div>              <span class=\"btn btn-file btn-alt btn-sm\">                  <span class=\"fileupload-new\">选择图片</span>                  <span class=\"fileupload-exists\">Change</span>                  <input type=\"file\" />              </span>              <a href=\"#\" class=\"btn fileupload-exists btn-sm\" data-dismiss=\"fileupload\">Remove</a>          </div>      </div>  </div>    <div class=\"block-area\">      <button class=\"btn m-r-5 ajaxsubmit\">提交</button>  </div>  ";
echo $this->parameters['form']->end();
echo "  </div>  ";
}  public function struct_js (){
 echo "      <!-- Text Editor -->  <script src=\"/std/assets/admin/js/editor2.min.js\"></script> <!-- WYSIWYG Editor -->  <script src=\"/std/assets/admin/js/fileupload.min.js\"></script> <!-- File Upload -->  <script src=\"/std/assets/common/js/form-ajax.js\"></script> <!-- ajaxform module -->    <script>  new FormAjax({      id        : \"#";
echo $this->parameters['form']->id();
echo "\",      action    : \"";
echo $this->parameters['action'];
echo "\",      prepare   : function(){          $(\"#article_picture\").val($(\".block-image\").find('img').attr('src'));      },      ajaxSubmitCallback  : function(data){          console.log(data);          if(data.error){              console.log(data.error);              $(\"#alert\").html(data.error.join(\"<br>\"));          }          if(data.res>0){              console.log($(\"#aside-article\").find('.list'));              $(\"#aside-article\").find('.list').click();          }      }  });  </script>  ";
}
}
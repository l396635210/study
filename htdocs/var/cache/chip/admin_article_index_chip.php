<?php
namespace cache\chip;
class admin_article_index_chip  extends blank_chip {
    public function struct_alert (){
 echo "  ";
echo isset($_SESSION['success']) ? $_SESSION['success'] : "";unset($_SESSION['success']);
echo"  ";
}    public function struct_body (){
 echo "  <div class=\"block-area\" id=\"article_list\">      <h2 class=\"page-title\">";
echo $this->parameters['title'];
echo "</h2>      <h3 class=\"block-title\"><button class=\"btn m-r-5 create\">写文章</button></h3>      <div class=\"table-responsive overflow\" style=\"overflow: hidden;\" tabindex=\"5003\">          <table class=\"table table-bordered table-hover tile\">              <thead>              <tr>                  <th>No.</th>                  <th>所属栏目</th>                  <th>文章标题</th>                  <th>操作</th>              </tr>              </thead>              <tbody>              ";
foreach(isset($this->parameters['list']) ? $this->parameters['list'] : $list as $item):
echo"              <tr>                  <td>";
echo isset($item['id']) ? $item['id'] : $this->parameters['item']['id'];
echo"</td>                  <td>";
echo isset($item['cTitle']) ? $item['cTitle'] : $this->parameters['item']['cTitle'];
echo"</td>                  <td>";
echo isset($item['title']) ? $item['title'] : $this->parameters['item']['title'];
echo"</td>                  <td>                      <button href=\"";
echo path(['article_edit', ['id'=>$item['id']]]);
echo "\" class=\"btn m-r-5 edit\">修改</button>                      <button href=\"";
echo path(['article_delete', ['id'=>$item['id']]]);
echo "\" class=\"btn m-r-5 delete\">删除</button>                  </td>              </tr>              ";
endforeach;
echo "              </tbody>          </table>      </div>  </div>  ";
}  public function struct_js (){
 echo "  <script src=\"/std/assets/common/js/pagination.js\"></script>  <script>  var ArticleList = function(){      this.click = function(){          $(\"#article_list\").find(\".create\").click(function(){              $(\"#aside-article\").find(\".create\").click();          });            $(\"#article_list\").find(\".edit\").click(function(e){              e.preventDefault();              var spa = new SPA();              spa.spaAction(this);          });            $(\"#article_list\").find(\".delete\").click(function(e){              e.preventDefault();              $.post($(this).attr(\"href\")                  , {}                  , function(data){                      data = eval(\"(\"+data+\")\");                      ajaxSubmitCallback(data);                  });          });          var ajaxSubmitCallback = function (data){              console.log(data);              if(data.res>0){                  console.log($(\"#aside-article\").find('.list'));                  $(\"#aside-article\").find('.list').click();              }          }      }  };    </script>  <script>      var pagination = new Pagination('.table-responsive');      pagination.config({          'pagination' : '.display',          'pagination_data' : '#display_data',          'pagination_position' : '#position',          'current_page'  : \"";
echo $this->parameters['page'];
echo "\",          'total_records' : '";
echo $this->parameters['cnt'];
echo "',          'records_per_page':10,          'url'       : \"";
echo path('article_list');
echo "\",          'byAjax'    : true      });        var articleList = new ArticleList();      articleList.click();    </script>  ";
}
}
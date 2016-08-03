<?php
namespace cache\chip;
class admin_category_index_chip  extends blank_chip {
    public function struct_alert (){
 echo "  ";
echo isset($_SESSION['success']) ? $_SESSION['success'] : "";unset($_SESSION['success']);
echo"  ";
}    public function struct_body (){
 echo "  <div id=\"category_list\" class=\"block-area\">      <h2 class=\"page-title\">";
echo $this->parameters['title'];
echo "</h2>      <h3 class=\"block-title\"><button class=\"btn m-r-5 create\">创建新栏目</button></h3>      <div class=\"table-responsive overflow\" style=\"overflow: hidden;\" tabindex=\"5003\">          <table class=\"table table-bordered table-hover tile\">              <thead>              <tr>                  <th>No.</th>                  <th>栏目名称</th>                  <th>栏目描述</th>                  <th>操作</th>              </tr>              </thead>              <tbody>              ";
foreach(isset($this->parameters['list']) ? $this->parameters['list'] : $list as $item):
echo"              <tr>                  <td>";
echo isset($item['id']) ? $item['id'] : $this->parameters['item']['id'];
echo"</td>                  <td>";
echo isset($item['title']) ? $item['title'] : $this->parameters['item']['title'];
echo"</td>                  <td>";
echo isset($item['descr']) ? $item['descr'] : $this->parameters['item']['descr'];
echo"</td>                  <td>                      <button href=\"";
echo path(['category_edit', ['id'=>$item['id']]]);
echo "\" class=\"btn m-r-5 edit\">修改</button>                      <button href=\"";
echo path(['category_delete', ['id'=>$item['id']]]);
echo "\" class=\"btn m-r-5 delete\">删除</button>                  </td>              </tr>              ";
endforeach;
echo "              </tbody>          </table>        </div>  </div>  ";
}  public function struct_js (){
 echo "  <script src=\"/std/assets/common/js/pagination.js\"></script>  <script>  var CategoryList = function(){      this.click = function(){          $(\"#category_list\").find(\".create\").click(function(){              $(\"#aside-category\").find(\".create\").click();          });            $(\"#category_list\").find(\".edit\").click(function(e){              e.preventDefault();              var spa = new SPA();              spa.spaAction(this);          });          $(\"#category_list\").find(\".delete\").click(function(e){              e.preventDefault();              $.post($(this).attr(\"href\")                  , {}                  , function(data){                      data = eval(\"(\"+data+\")\");                      ajaxSubmitCallback(data);                  });          });          var ajaxSubmitCallback = function (data){              if(data.res>0){                  $(\"#aside-category\").find('.list').click();              }          }      }  };  </script>  <script>      var pagination = new Pagination('.table-responsive');      pagination.config({          'pagination' : '.display',          'pagination_data' : '#display_data',          'pagination_position' : '#position',          'current_page'  : \"";
echo $this->parameters['page'];
echo "\",          'total_records' : '";
echo $this->parameters['cnt'];
echo "',          'records_per_page':10,          'url'       : \"";
echo path('category_list');
echo "\",          'byAjax'    : true      });        var categoryList = new CategoryList();      categoryList.click();  </script>      ";
}
}
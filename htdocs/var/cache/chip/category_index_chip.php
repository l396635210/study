<?php
namespace cache\chip;
class category_index_chip  extends base_chip {
  public function struct_body (){
 echo "  <div class=\"row\">";
echo isset($_SESSION['success']) ? $_SESSION['success'] : "";unset($_SESSION['success']);
echo"</div>  <div class=\"row\">   <div class=\"col-md-12\">   <div><a href=\"";
echo path('category_create');
echo "\" class=\"btn btn-info\">创建栏目</a></div>   <div class=\"table-responsive\">          <table class=\"table table-striped\">              <thead>              <tr>                  <th>#</th>                  <th>标题</th>      <th>描述</th>                  <th class=\"text-right\">操作</th>              </tr>              </thead>              <tbody>     ";
if(isset($this->parameters['list']) ? $this->parameters['list'] : $list ):
echo "              ";
foreach(isset($this->parameters['list']) ? $this->parameters['list'] : $list as $item):
echo"              <tr>                  <td>";
echo $item['id'];
echo"</td>                  <td>";
echo $item['title'];
echo"</td>      <td>";
echo $item['descr'];
echo"</td>                  <td class=\"text-right\">                      <!--<div data-url=\"";
echo path(['category_edit', ['id'=>$item['id']]]);
echo "\" class=\"btn btn-info\">修改</div>-->                      <a href=\"";
echo path(['category_edit', ['id'=>$item['id']]]);
echo "\" class=\"btn btn-info\">修改</a>                  </td>              </tr>              ";
endforeach;
echo "     ";
endif;
echo "              </tbody>          </table>      </div>   </div>  </div>  ";
}    
}
<?php
namespace cache\chip;
class admin_category_index_chip  extends blank_chip {
  public function struct_body (){
 echo "  <div class=\"block-area\" id=\"tableHover\">      <h2 class=\"page-title\">";
echo $this->parameters['title'];
echo "</h2>      <h3 class=\"block-title\"><button class=\"btn m-r-5\">创建新栏目</button></h3>      <div class=\"table-responsive overflow\" style=\"overflow: hidden;\" tabindex=\"5003\">          <table class=\"table table-bordered table-hover tile\">              <thead>              <tr>                  <th>No.</th>                  <th>栏目名称</th>                  <th>栏目描述</th>                  <th>操作</th>              </tr>              </thead>              <tbody>              ";
foreach(isset($this->parameters['list']) ? $this->parameters['list'] : $list as $item):
echo"              <tr>                  <td>";
echo $item['id'];
echo"</td>                  <td>";
echo $item['title'];
echo"</td>                  <td>";
echo $item['descr'];
echo"</td>                  <td>                      <button class=\"btn m-r-5\">修改</button>                      <button class=\"btn m-r-5\">删除</button>                  </td>              </tr>              ";
endforeach;
echo "              </tbody>          </table>      </div>  </div>  ";
}
}
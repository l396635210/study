<?php
namespace cache\chip;
class home_blog_index_chip  extends blank_chip {
    public function struct_body (){
 echo "  <div id=\"tm-main\" class=\"tm-main uk-block uk-block-default\">      <div class=\"uk-container uk-container-center\">          <div class=\"uk-grid\" data-uk-grid-match=\"\" data-uk-grid-margin=\"\">              <main id=\"list\" class=\"uk-width-1-1 uk-row-first\">                  <div class=\"tm-container-small\">                      ";
foreach(isset($this->parameters['list']) ? $this->parameters['list'] : $list as $item):
echo"                      <article class=\"uk-article\">                          <a class=\"uk-display-block\" href=\"";
echo path(['blog_show', ['id'=>$item['id']]]);
echo "\"><img src=\"/std/assets/home/images/examples/blog/blog-01.jpg\" alt=\"Designing for a cause\"></a>                          <h1 class=\"uk-article-title\"><a href=\"";
echo path(['blog_show', ['id'=>$item['id']]]);
echo "\">";
echo isset($item['title']) ? $item['title'] : $this->parameters['item']['title'];
echo"</a></h1>                          <p class=\"uk-article-meta\">                              发布于                              <time datetime=\"2015-08-24T16:43:00+00:00\">";
echo isset($item['pTime']) ? $item['pTime'] : $this->parameters['item']['pTime'];
echo"</time>                          </p>                          <div class=\"uk-margin\">                              <p> ";
echo isset($item['content']) ? $item['content'] : $this->parameters['item']['content'];
echo" </p>                          </div>                          <div class=\"uk-margin-large-top\">                              <ul class=\"uk-subnav uk-margin-bottom-remove\">                                  <li><a class=\"show\" href=\"";
echo path(['blog_show', ['id'=>$item['id']]]);
echo "\">Read more</a></li>                              </ul>                          </div>                      </article>                      ";
endforeach;
echo "                      <!--                      <ul class=\"uk-pagination\">                          <li class=\"uk-active\"><span>1</span></li>                          <li>                              <a href=\"http://pagekit.com/demo/theme-one/blog/page/2\">2</a>                          </li>                          <li>                          </li>                      </ul>                      -->                  </div>              </main>          </div>      </div>  </div>  ";
}    public function struct_js (){
 echo "  <script src=\"/std/assets/common/js/pagination.js\"></script>  <script>  var BlogAction = function(){      this.click = function(){          $(\"#list\").find(\".show\").click(function (e) {              e.preventDefault();              var spa = new SPA();              spa.spaAction(this);          });      }  }  </script>  <script>  var blogAction = new BlogAction();  blogAction.click();  var pagination = new Pagination('main');  pagination.config({  'pagination' : '.display',  'pagination_data' : '#display_data',  'pagination_position' : '#position',  'current_page'  : \"";
echo $this->parameters['page'];
echo "\",  'total_records' : '";
echo $this->parameters['cnt'];
echo "',  'records_per_page':10,  'url'       : \"";
echo path('blog_index');
echo "\",  'byAjax'    : true  });  </script>  ";
}    
}
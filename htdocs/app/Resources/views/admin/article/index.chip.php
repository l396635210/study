{@ extends 'blank.chip.php' @}

{% struct alert %}
{{ success('success') }}
{% endstruct %}

{% struct body %}
<div class="block-area" id="article_list">
    <h2 class="page-title">{{ title }}</h2>
    <h3 class="block-title"><button class="btn m-r-5 create">写文章</button></h3>
    <div class="table-responsive overflow" style="overflow: hidden;" tabindex="5003">
        <table class="table table-bordered table-hover tile">
            <thead>
            <tr>
                <th>No.</th>
                <th>所属栏目</th>
                <th>文章标题</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            {% foreach list as item %}
            <tr>
                <td>{{ item.id }}</td>
                <td>{{ item.cTitle }}</td>
                <td>{{ item.title }}</td>
                <td>
                    <button href="{{ path('article_edit', {'id':item.id}) }}" class="btn m-r-5 edit">修改</button>
                    <button href="{{ path('article_delete', {'id':item.id}) }}" class="btn m-r-5 delete">删除</button>
                </td>
            </tr>
            {% endforeach %}
            </tbody>
        </table>
    </div>
</div>
{% endstruct %}
{% struct js %}
<script src="{{ asset('common/js/pagination.js') }}"></script>
<script>
var ArticleList = function(){
    this.click = function(){
        $("#article_list").find(".create").click(function(){
            $("#aside-article").find(".create").click();
        });

        $("#article_list").find(".edit").click(function(e){
            e.preventDefault();
            var spa = new SPA();
            spa.spaAction(this);
        });

        $("#article_list").find(".delete").click(function(e){
            e.preventDefault();
            $.post($(this).attr("href")
                , {}
                , function(data){
                    data = eval("("+data+")");
                    ajaxSubmitCallback(data);
                });
        });
        var ajaxSubmitCallback = function (data){
            console.log(data);
            if(data.res>0){
                console.log($("#aside-article").find('.list'));
                $("#aside-article").find('.list').click();
            }
        }
    }
};

</script>
<script>
    var pagination = new Pagination('.table-responsive');
    pagination.config({
        'pagination' : '.display',
        'pagination_data' : '#display_data',
        'pagination_position' : '#position',
        'current_page'  : "{{ page }}",
        'total_records' : '{{ cnt }}',
        'records_per_page':10,
        'url'       : "{{ path('article_list') }}",
        'byAjax'    : true
    });

    var articleList = new ArticleList();
    articleList.click();

</script>
{% endstruct %}
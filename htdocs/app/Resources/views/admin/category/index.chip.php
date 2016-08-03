{@ extends 'blank.chip.php' @}

{% struct alert %}
{{ success('success') }}
{% endstruct %}

{% struct body %}
<div id="category_list" class="block-area">
    <h2 class="page-title">{{ title }}</h2>
    <h3 class="block-title"><button class="btn m-r-5 create">创建新栏目</button></h3>
    <div class="table-responsive overflow" style="overflow: hidden;" tabindex="5003">
        <table class="table table-bordered table-hover tile">
            <thead>
            <tr>
                <th>No.</th>
                <th>栏目名称</th>
                <th>栏目描述</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            {% foreach list as item %}
            <tr>
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                <td>{{ item.descr }}</td>
                <td>
                    <button href="{{ path('category_edit', {'id':item.id}) }}" class="btn m-r-5 edit">修改</button>
                    <button href="{{ path('category_delete', {'id':item.id}) }}" class="btn m-r-5 delete">删除</button>
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
var CategoryList = function(){
    this.click = function(){
        $("#category_list").find(".create").click(function(){
            $("#aside-category").find(".create").click();
        });

        $("#category_list").find(".edit").click(function(e){
            e.preventDefault();
            var spa = new SPA();
            spa.spaAction(this);
        });
        $("#category_list").find(".delete").click(function(e){
            e.preventDefault();
            $.post($(this).attr("href")
                , {}
                , function(data){
                    data = eval("("+data+")");
                    ajaxSubmitCallback(data);
                });
        });
        var ajaxSubmitCallback = function (data){
            if(data.res>0){
                $("#aside-category").find('.list').click();
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
        'url'       : "{{ path('category_list') }}",
        'byAjax'    : true
    });

    var categoryList = new CategoryList();
    categoryList.click();
</script>


{% endstruct %}
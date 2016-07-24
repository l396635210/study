{@ extends 'blank.chip.php' @}
{% struct body %}
<div class="block-area" id="tableHover">
    <h2 class="page-title">{{ title }}</h2>
    <h3 class="block-title"><button class="btn m-r-5">创建新栏目</button></h3>
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
                    <button class="btn m-r-5">修改</button>
                    <button class="btn m-r-5">删除</button>
                </td>
            </tr>
            {% endforeach %}
            </tbody>
        </table>
    </div>
</div>
{% endstruct %}
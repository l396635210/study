{@ extends 'base.chip.php' @}
{% struct body %}
<div class="row">{{ success('success') }}</div>
<div class="row">
	<div class="col-md-12">
	<div><a href="{{ path('category_create') }}" class="btn btn-info">创建栏目</a></div>
	<div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>标题</th>
				<th>描述</th>
                <th class="text-right">操作</th>
            </tr>
            </thead>
            <tbody>
			{% if list %}
            {% foreach list as item %}
            <tr>
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
				<td>{{ item.descr }}</td>
                <td class="text-right">
                    <!--<div data-url="{{ path('category_edit', {'id':item.id}) }}" class="btn btn-info">修改</div>-->
                    <a href="{{ path('category_edit', {'id':item.id}) }}" class="btn btn-info">修改</a>
                </td>
            </tr>
            {% endforeach %}
			{% endif %}
            </tbody>
        </table>
    </div>
	</div>
</div>
{% endstruct %}


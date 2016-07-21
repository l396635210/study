{@ extends 'base.chip.php' @}
{% struct body %}
<div class="row">
	<div class="col-md-12">
		{{ errors('all') }}
	</div>
	<div class="col-md-12">
		{{ form.start() }}
		<div class='form-group'>
		{{ form.row('title') }}
		</div>
		<div class='form-group'>
		{{ form.row('categoryId') }}
		</div>
		<div class='form-group'>
		{{ form.row('content') }}
		</div>
		<div class='form-group'>
		<button type="submit" class="btn btn-primary">提交</button>
		<button type="reset" class="btn">取消</button>
		</div>
		{{ form.end() }}
		<!--{% if list %}
			{% foreach list as item %}
				{{ item.id }} {{ item.title }}
			{% endforeach %}
		{% endif %}-->
	</div>
</div>
{% endstruct %}
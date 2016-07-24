{@ extends 'base.chip.php' @}
{% struct head %}
<script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>
{% endstruct %}

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
		{{ form.row('descr') }}
		</div>
		<div class='form-group'>
		<button type="submit" class="btn btn-primary">提交</button>
		<button type="reset" class="btn">取消</button>
		</div>
		{{ form.end() }}
	</div>
</div>
{% endstruct %}

{% struct script %}
<script>
	CKEDITOR.replace( 'category[descr]',{
		filebrowserImageUploadUrl : "{{ path('upload') }}"
	} );
</script>
{% endstruct %}
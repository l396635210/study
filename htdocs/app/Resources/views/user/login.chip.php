{@ extends 'user.chip.php' @}

{% struct body %}
<div class="row">
	<div class="col-md-12">
		{{ errors('all') }}
	</div>
</div>
<div class="row">
	<div class="auth-form">
		<div class="auth-form-header">
			<h1>登陆</h1>
		</div>

		<div class="auth-form-body">
		{{ form.start() }}
		<div class="form-group">
		{{ form.row('account') }}
		</div>
		<div class="form-group">
		{{ form.row('password') }}
		</div>
		<button type="submit" class="btn btn-primary btn-block"  value="submit" />提交</button>
		{{ form.end() }}
		</div>
	</div>
</div>	
{% endstruct %}
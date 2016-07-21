{@ extends 'base.chip.php' @}
{% struct body %}
	<div class="row">
	<div class="col-md-12">
		{{ success('success') }}
		{% if list %}
			{% foreach list as item %}
				{{ item.id }} {{ item.title }}
			{% endforeach %}
		{% endif %}
	</div>
	</div>
{% endstruct %}
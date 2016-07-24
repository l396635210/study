{@ extends 'user.chip.php' @}

{% struct body %}
<header>
	<h1>管理</h1>
	<p>{{ errors('all') }}</p>
</header>

<div class="clearfix"></div>

<!-- Login -->
{{ form.start( , class='box tile animated active' id='box-login') }}
<h2 class="m-t-0 m-b-15">Login</h2>
{{ form.row('account') }}
{{ form.row('password') }}
<div class="checkbox m-b-20">
</div>
<button class="btn btn-sm m-r-5">Sing In</button>
{{ form.end() }}
{% endstruct %}
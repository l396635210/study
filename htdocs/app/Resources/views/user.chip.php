<!DOCTYPE html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<meta name="format-detection" content="telephone=no">
	<meta charset="UTF-8">

	<meta name="description" content="Violate Responsive Admin Template">
	<meta name="keywords" content="Super Admin, Admin, Template, Bootstrap">

	<title>后台管理</title>
	<!-- CSS -->
	<link href="{{ asset('common/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/css/form.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/css/generics.css') }}" rel="stylesheet">
</head>
<body id="skin-blur-violate">
<section id="login">
	{% struct body %}{% endstruct %}
</section>

<!-- Javascript Libraries -->
<!-- jQuery -->
<script src="{{ asset('common/js/jquery.min.js') }}"></script> <!-- jQuery Library -->

<!-- Bootstrap -->
<script src="{{ asset('common/js/bootstrap.min.js') }}"></script>
<!--  Form Related -->
<script src="{{ asset('admin/js/icheck.js') }}"></script> <!-- Custom Checkbox + Radio -->
<!-- All JS functions -->
<script src="{{ asset('admin/js/functions.js') }}"></script>
</body>
</html>

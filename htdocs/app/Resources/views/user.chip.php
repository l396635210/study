<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8"/>
	<title>{% struct title %}{% endstruct %}</title>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link crossorigin="anonymous" href="https://assets-cdn.github.com/assets/github-5e4edcfc690fbfc4db1e4a54b57a1d37b3d02fe753300746845a9c204c1d0470.css" media="all" rel="stylesheet" />
	{% struct stylesheet %}{% endstruct %}
</head>
<body>
<div class="container">
	{% struct body %}{% endstruct %}
	<footer>{% struct foot %}{% endstruct %}</footer>
</div><!-- /.container -->

<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
{% struct script %}{% endstruct %}

</body>
</html>
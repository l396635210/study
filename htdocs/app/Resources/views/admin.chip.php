<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="format-detection" content="telephone=no">
    <meta charset="UTF-8">

    <meta name="description" content="Violate Responsive Admin Template">
    <meta name="keywords" content="Super Admin, Admin, Template, Bootstrap">

    <title>{{ title }}</title>

    <!-- CSS -->
    <link href="{{ asset('common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/form.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/generics.css') }}" rel="stylesheet">
</head>
<body id="skin-blur-violate">

<header id="header" class="media">
    <a href="" id="menu-toggle"></a>
    <a class="logo pull-left" href="#">后台管理</a>
    <div class="media-body">
        <div class="media" id="top-menu">
            <div id="time" class="pull-right">
                <span id="hours"></span>
                :
                <span id="min"></span>
                :
                <span id="sec"></span>
            </div>

            <div class="media-body">
                <input type="text" class="main-search">
            </div>
        </div>
    </div>
</header>

<div class="clearfix"></div>

<section id="main" class="p-relative" role="main">
    <!-- Sidebar -->
    <aside id="sidebar">

        <!-- Sidbar Widgets -->
        <div class="side-widgets overflow">
            <!-- Profile Menu -->
            <div class="text-center s-widget m-b-25 dropdown" id="profile-menu">
                <a href="#" data-toggle="dropdown">
                    <img class="profile-pic animated" src="{{ asset('admin/img/profile-pic.jpg') }}" alt="">
                </a>
                <ul class="dropdown-menu profile-menu">
                    <li><a href="">我的资料</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                    <li><a href="">退出</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                </ul>
                <h4 class="m-0">用户名</h4>
            </div>
            <!-- Calendar -->
            <div class="s-widget m-b-25">
                <div id="sidebar-calendar"></div>
            </div>
        </div>

        <!-- Side Menu -->
        <ul class="list-unstyled side-menu">
            <li class="active list-item">
                <a class="sa-side-home" href="{{ path('admin') }}">
                    <span class="menu-item">首页</span>
                </a>
            </li>
            <li class="dropdown list-item">
                <a class="sa-side-folder" href="{{ path('category_list',{page:1}) }}">
                    <span class="menu-item">栏目管理</span>
                </a>
                <ul class="list-unstyled menu-item" id="aside-category">
                    <li><a href="{{ path('category_list',{page:1}) }}" class="list">栏目列表</a></li>
                    <li><a href="{{ path('category_create') }}" class="create">添加栏目</a></li>
                </ul>
            </li>
            <li class="dropdown list-item" id="aside-article">
                <a class="sa-side-form" href="{{ path('article_list', {page:1}) }}">
                    <span class="menu-item">文章管理</span>
                </a>
                <ul class="list-unstyled menu-item">
                    <li><a href="{{ path('article_list', {page:1}) }}" class="list">文章列表</a></li>
                    <li><a href="{{ path('article_create') }}" class="create">发布文章</a></li>
                </ul>
            </li>
        </ul>

    </aside>

    <!-- Content -->
    <section id="content" class="container">
        <div id="body">
            {% struct body %}{% endstruct %}
        </div>
    </section>


</section>

<!-- Javascript Libraries -->
<!-- jQuery -->
<script src="{{ asset('common/js/jquery.min.js') }}"></script> <!-- jQuery Library -->
<script src="{{ asset('common/js/jquery-ui.min.js') }}"></script> <!-- jQuery Library -->
<script src="{{ asset('common/js/jquery.cookie.js') }}"></script> <!-- jQuery Library -->

<!-- underscore -->
<script src="{{ asset('common/js/underscore.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('common/js/bootstrap.min.js') }}"></script>
<!--  Form Related -->
<script src="{{ asset('admin/js/validation/validate.min.js') }}"></script> <!-- jQuery Form Validation Library -->
<script src="{{ asset('admin/js/validation/validationEngine.min.js') }}"></script> <!-- jQuery Form Validation Library - requirred with above js -->
<script src="{{ asset('admin/js/select.min.js') }}"></script> <!-- Custom Select -->
<script src="{{ asset('admin/js/chosen.min.js') }}"></script> <!-- Custom Multi Select -->
<script src="{{ asset('admin/js/datetimepicker.min.js') }}"></script> <!-- Date & Time Picker -->
<script src="{{ asset('admin/js/colorpicker.min.js') }}"></script> <!-- Color Picker -->
<script src="{{ asset('admin/js/icheck.js') }}"></script> <!-- Custom Checkbox + Radio -->
<script src="{{ asset('admin/js/autosize.min.js') }}"></script> <!-- Textare autosize -->
<script src="{{ asset('admin/js/toggler.min.js') }}"></script> <!-- Toggler -->
<script src="{{ asset('admin/js/input-mask.min.js') }}"></script> <!-- Input Mask -->
<script src="{{ asset('admin/js/spinner.min.js') }}"></script> <!-- Spinner -->
<script src="{{ asset('admin/js/slider.min.js') }}"></script> <!-- Input Slider -->
<script src="{{ asset('admin/js/fileupload.min.js') }}"></script> <!-- File Upload -->

<!-- UX -->
<script src="{{ asset('admin/js/scroll.min.js') }}"></script> <!-- Custom Scrollbar -->

<!-- Other -->
<script src="{{ asset('admin/js/calendar.min.js') }}"></script> <!-- Calendar -->
<script src="{{ asset('admin/js/feeds.min.js') }}"></script> <!-- News Feeds -->

<!-- All JS functions -->
<script src="{{ asset('admin/js/functions.js') }}"></script>
<script>

var SPA = function(){
    this.spaAction = function(obj){
        if($(obj).attr('href') && $(obj).attr('href')!=location.href){
            /*$.cookie('href', $(obj).attr('href'));*/
            $.post($(obj).attr('href')
                ,{}
                ,function(data){
                    $("#body").html(data);
                });
        }else{
            $("#alert").html("");
            $("#body").html("");
        }
    }
};

var spa = new SPA();
$(document).ready(function(){

    (function(){
        $('.side-menu').find('a').click(function(e){
            e.preventDefault();
            spa.spaAction(this);
            $('.side-menu').find('.list-item').removeClass('active');
            $(this).parents('.list-item').addClass('active');
        });
    })();

    /*$('.side-menu').find('a[href="'+$.cookie('href')+'"]').click();*/
});
</script>
{% struct js %}{% endstruct %}
</body>
</html>

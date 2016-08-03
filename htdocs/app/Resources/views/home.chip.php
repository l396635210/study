<!DOCTYPE html>
<html class="" lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Pagekit">
    <title>{% struct title %}{% endstruct %}</title>
    <link href="{{ asset('home/css/theme.css') }}" rel="stylesheet">

    <style>
        .cm-text-uppercase { text-transform: uppercase; }
        .tm-navbar{opacity:0.7}
    </style>
    {% struct style %}{% endstruct %}
</head>
<body>
<div class="uk-sticky-placeholder">
    <div class="tm-navbar tm-navbar-overlay" data-uk-sticky="{"media":767,"showup":true,"animation":"uk-animation-slide-top"}" style="margin: 0px;">
        <div class="uk-container uk-container-center">
            <nav class="uk-navbar">
                <a class="uk-navbar-brand" href="{{ path('home') }}">
                    <img class="tm-logo uk-responsive-height" src="/demo/theme-one/storage/pagekit-logo.svg" alt="">
                    <img class="tm-logo-contrast uk-responsive-height" src="/demo/theme-one/storage/pagekit-logo-contrast.svg" alt="">
                </a>
                <div class="uk-navbar-flip uk-hidden-small">
                    <ul class="uk-navbar-nav">
                        <li class=" uk-active">
                            <a href="{{ path('welcome') }}">Home</a>
                        </li>
                        <li class="">
                            <a href="/demo/theme-one/about">About</a>
                        </li>
                        <li class="">
                            <a href="{{ path('blog_index') }}">Blog</a>
                        </li>
                        <li class="">
                            <a href="/demo/theme-one/positions">Positions</a>
                        </li>
                    </ul>
                </div>
                <div class="uk-navbar-flip uk-visible-small">
                    <a href="#offcanvas" class="uk-navbar-toggle" data-uk-offcanvas=""></a>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- navbar end -->
<div id="body">
    {% struct body %}{% endstruct %}
</div>
<!-- foot start -->
<div id="tm-footer" class="tm-footer uk-block uk-block-secondary uk-contrast">
    <div class="uk-container uk-container-center">
        <section class="uk-grid uk-grid-match" data-uk-grid-margin>
            <div class="uk-width-medium-1-1">
                <div class="uk-panel   ">
                    <ul class="uk-grid uk-grid-medium uk-flex uk-flex-center">
                        <li><a href="#" class="uk-icon-hover uk-icon-small uk-icon-pinterest"></a></li>
                        <li><a href="#" class="uk-icon-hover uk-icon-small uk-icon-twitter"></a></li>
                        <li><a href="#" class="uk-icon-hover uk-icon-small uk-icon-behance "></a></li>
                    </ul>
                    <ul class="uk-subnav uk-margin uk-flex uk-flex-center">
                        <li><a href="#">Street, Country</a></li>
                        <li><a href="#">(123) 456-7899</a></li>
                        <li><a href="#">email@example.com</a></li>
                    </ul>
                </div>
            </div>
        </section>

    </div>
</div>

<div id="offcanvas" class="uk-offcanvas">
    <div class="uk-offcanvas-bar uk-offcanvas-bar-flip">
        <ul class="uk-nav uk-nav-offcanvas">
            <li class=""><a href="{{ path('home') }}">Home</a></li>
            <li class=""><a href="/demo/theme-one/about">About</a></li>
            <li class=""><a href="/demo/theme-one/blog">Blog</a></li>
            <li class=" uk-active"> <a href="/demo/theme-one/positions">Positions</a> </li>
        </ul>
    </div>
</div>
<!-- foot end -->
<script src="{{ asset('common/js/jquery.min.js') }}"></script>
<script src="{{ asset('common/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('home/js/uikit.min.js') }}"></script>
<script src="{{ asset('home/js/components/sticky.min.js') }}"></script>
<script src="{{ asset('home/js/components/lightbox.min.js') }}"></script>
<script src="{{ asset('home/js/components/parallax.min.js') }}"></script>
<script src="{{ asset('home/js/theme.js') }}"></script>
<script>

    var SPA = function(){
        this.spaAction = function(obj){
            if(!hrefIsNowPage($(obj).attr('href'))){
                $.post($(obj).attr('href')
                    ,{}
                    ,function(data){
                        if($("#body").html()!=data){
                            $("#body").html(data);
                        }
                    });
            }
        };

        var hrefIsNowPage = function(href){
            if(!$.cookie("page")){
                $.cookie("page",href);
            }else{
                if(href!=$.cookie("page")){
                    $.cookie("page", null);
                    $.cookie("page", href);
                    return false
                }
            }
            return true;
        }
    };

    var spa = new SPA();
    $(document).ready(function(){
        $.cookie("page",location.href);
        (function(){
            $('.uk-navbar-nav').find('a').click(function(e){
                e.preventDefault();
                spa.spaAction(this);
                $('.uk-navbar-nav').find('li').removeClass('uk-active');
                $(this).parents('li').addClass('uk-active');
            });
        })();

        /*$('.side-menu').find('a[href="'+$.cookie('href')+'"]').click();*/
    });
</script>
{% struct js %}{% endstruct %}
</body>
</html>

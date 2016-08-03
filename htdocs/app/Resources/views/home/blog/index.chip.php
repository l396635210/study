{@ extends 'blank.chip.php' @}

{% struct body %}
<div id="tm-main" class="tm-main uk-block uk-block-default">
    <div class="uk-container uk-container-center">
        <div class="uk-grid" data-uk-grid-match="" data-uk-grid-margin="">
            <main id="list" class="uk-width-1-1 uk-row-first">
                <div class="tm-container-small">
                    {% foreach list as item %}
                    <article class="uk-article">
                        <a class="uk-display-block" href="{{ path('blog_show', {'id':item.id}) }}"><img src="{{ asset('home/images/examples/blog/blog-01.jpg') }}" alt="Designing for a cause"></a>
                        <h1 class="uk-article-title"><a href="{{ path('blog_show', {'id':item.id}) }}">{{ item.title }}</a></h1>
                        <p class="uk-article-meta">
                            发布于
                            <time datetime="2015-08-24T16:43:00+00:00">{{ item.pTime }}</time>
                        </p>
                        <div class="uk-margin">
                            <p> {{ item.content }} </p>
                        </div>
                        <div class="uk-margin-large-top">
                            <ul class="uk-subnav uk-margin-bottom-remove">
                                <li><a class="show" href="{{ path('blog_show', {'id':item.id}) }}">Read more</a></li>
                            </ul>
                        </div>
                    </article>
                    {% endforeach %}
                    <!--
                    <ul class="uk-pagination">
                        <li class="uk-active"><span>1</span></li>
                        <li>
                            <a href="http://pagekit.com/demo/theme-one/blog/page/2">2</a>
                        </li>
                        <li>
                        </li>
                    </ul>
                    -->
                </div>
            </main>
        </div>
    </div>
</div>
{% endstruct %}

{% struct js %}
<script src="{{ asset('common/js/pagination.js') }}"></script>
<script>
var BlogAction = function(){
    this.click = function(){
        $("#list").find(".show").click(function (e) {
            e.preventDefault();
            var spa = new SPA();
            spa.spaAction(this);
        });
    }
}
</script>
<script>
var blogAction = new BlogAction();
blogAction.click();

var pagination = new Pagination('main');
pagination.config({
'pagination' : '.display',
'pagination_data' : '#display_data',
'pagination_position' : '#position',
'current_page'  : "{{ page }}",
'total_records' : '{{ cnt }}',
'records_per_page':10,
'url'       : "{{ path('blog_index') }}",
'byAjax'    : true
});
</script>
{% endstruct %}


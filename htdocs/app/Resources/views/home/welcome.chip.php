{@ extends 'blank.chip.php' @}

{% struct body %}
<!-- hero start -->
<div id="tm-hero" class="tm-hero uk-block uk-block-large uk-cover-background uk-flex uk-flex-middle uk-height-viewport uk-contrast" style="background-image: url('{{ asset('home/images/home-background.jpg') }}');">
    <div class="uk-container uk-container-center">
        <section class="uk-grid uk-grid-match" data-uk-grid-margin="">
            <div class="uk-width-medium-1-1 uk-row-first">
                <div class="uk-panel uk-text-center ">
                    <h1 class="uk-heading-large uk-margin-large-bottom">Hello, I'm Pagekit,<br class="uk-hidden-small">
                        your new favorite CMS.</h1>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- hero end -->
<div id="tm-main" class="tm-main uk-block uk-block-default">
    <div class="uk-container uk-container-center">
        <div class="uk-grid" data-uk-grid-match="" data-uk-grid-margin="">
            <main class="uk-width-1-1 uk-row-first">
                <article class="uk-article uk-text-center">
                    <div class="uk-width-medium-3-4 uk-container-center">
                        <h2 class="uk-h1 uk-margin-large-bottom">这里是欢迎页面的标题<br class="uk-hidden-small">
                            to create beautiful websites.</h2>
                        <p class="uk-width-medium-4-6 uk-container-center">
                            这里是欢迎页面的内容，纯文本
                            Donec id elit non
                            mi porta gravida at eget metus. Vivamus sagittis lacus vel augue
                            laoreet rutrum faucibus dolor auctor. Nullam quis risus eget urna mollis
                            ornare vel eu leo. Cras mattis consectetur purus sit amet fermentum.
                            Nulla vitae elit libero, a pharetra augue. Morbi leo risus, porta ac
                            consectetur ac, vestibulum at eros.
                        </p>
                        <p class="uk-margin-large">
                            <i>For more photography check our <a href="#">Instagram</a></i>
                        </p>
                    </div>
                    <div class="uk-grid uk-grid-width-medium-1-2 uk-grid-match" data-uk-grid-margin="">
                        <div class="uk-row-first">
                            <div class="uk-panel">
                                <div class="uk-margin-large">
                                    <img src="{{ asset('home/images/examples/home/home-01.jpg') }}" alt="home-01">
                                </div>
                                <h3 class="uk-h2">About Us</h3>
                                <p>这里是关于页面内容介绍
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque
                                    penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
                                    quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                                </p>
                                <p>
                                    <a href="#">Read more</a>
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="uk-panel">
                                <div class="uk-margin-large">
                                    <img src="{{ asset('home/images/examples/home/home-02.jpg') }}" alt="home-02">
                                </div>
                                <h3 class="uk-h2">What's New?</h3>
                                <p>这里是最新的文章内容
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                    Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque
                                    penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
                                    quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                                </p>
                                <p>
                                    <a href="#">Read more</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
            </main>
        </div>
    </div>
</div>
{% endstruct %}
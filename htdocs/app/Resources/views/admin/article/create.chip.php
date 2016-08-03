{@ extends 'blank.chip.php' @}

{% struct body %}

<div class="block-area">
{{ form.start() }}
<div class="block-area">
    {{ form.row('title') }}
</div>
<div class="block-area">
    {{ form.row('categoryId') }}
</div>
<div class="hidden">
    {{ form.row('content') }}
</div>
<div class="block-area">
    <div class="wysiwye-editor"></div>
</div>
<div class="hidden">
    {{ form.row('picture') }}
</div>
<div class="block-area block-image">
    <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-preview thumbnail form-control"></div>
        <div>
            <span class="btn btn-file btn-alt btn-sm">
                <span class="fileupload-new">选择图片</span>
                <span class="fileupload-exists">换一个</span>
                <input type="file" />
            </span>
            <a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">取消</a>
        </div>
    </div>
</div>

<div class="block-area">
    <button class="btn m-r-5 ajaxsubmit">提交</button>
</div>
{{ form.end() }}
</div>
{% endstruct %}
{% struct js %}
    <!-- Text Editor -->
<script src="{{ asset('admin/js/editor2.min.js') }}"></script> <!-- WYSIWYG Editor -->
<script src="{{ asset('admin/js/fileupload.min.js') }}"></script> <!-- File Upload -->
<script src="{{ asset('common/js/form-ajax.js') }}"></script> <!-- ajaxform module -->

<script>
new FormAjax({
    id        : "#{{ form.id() }}",
    action    : "{{ action }}",
    prepare   : function(){
        $("#article_picture").val($(".block-image").find('img').attr('src'));
    },
    ajaxSubmitCallback  : function(data){
        console.log(data);
        if(data.error){
            console.log(data.error);
            $("#alert").html(data.error.join("<br>"));
        }
        if(data.res>0){
            console.log($("#aside-article").find('.list'));
            $("#aside-article").find('.list').click();
        }
    }
});
</script>
{% endstruct %}
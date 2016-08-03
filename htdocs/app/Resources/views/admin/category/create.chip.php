{@ extends 'blank.chip.php' @}

{% struct body %}
<div class="block-area">
<h2 class="page-title">{{ title }}</h2>
{{ form.start() }}
<div class="block-area">
    {{ form.row('title') }}
</div>
<div class="hidden">
    {{ form.row('descr') }}
</div>
<div class="block-area">
    <div class="wysiwye-editor"></div>
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
        ajaxSubmitCallback  : function(data){
            console.log(data);
            if(data.error){
                console.log(data.error);
                $("#alert").html(data.error.join("<br>"));
            }
            if(data.res>0){
                console.log($("#aside-category").find('.list'));
                $("#aside-category").find('.list').click();
            }
        }
    });


</script>
{% endstruct %}
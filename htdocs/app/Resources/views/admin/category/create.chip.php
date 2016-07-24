{@ extends 'blank.chip.php' @}

{% struct head %}

{% endstruct %}

{% struct body %}
{{ form.start() }}
<div class="block-area">
    {{ form.row('title') }}
</div>
<div class="block-area">
    {{ form.row('descr') }}
</div>
<div class="block-area">
    <button class="btn m-r-5">提交</button>
</div>
{{ form.end() }}
{% endstruct %}
{% struct foot %}
<script src="{{ asset('admin/js/fileupload.min.js') }}"></script> <!-- File Upload -->
<script>
    CKEDITOR.replace( 'category[descr]', {
        filebrowserUploadUrl : "actions/ckeditorUpload"
    });
    var Category = function(){
        var submit = '';
    };
</script>
{% endstruct %}
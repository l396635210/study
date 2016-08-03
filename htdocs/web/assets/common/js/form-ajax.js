var FormAjax = function(conf){
    var config = {};
    this.submit = function(){
        $(config.id).find('.ajaxsubmit').click(function(e){
            e.preventDefault();
            $(config.id).find("textarea").val($(".note-editable").html());
            ajaxSubmit();
        });

        var ajaxSubmit = function(){
            config.prepare();
            $.post(config.action
                , $(config.id).serialize()
                , function(data){
                    data = eval("("+data+")");
                    config.ajaxSubmitCallback(data);
                });
        };

    };
    /* Spinners */
    var init = function(conf){
        if(!verifyConfig(conf)){
            return;
        }
        config = conf;
        if($(config.id).find('.wysiwye-editor')) {
            $('.wysiwye-editor').summernote({
                height: 200
            });
            $(".note-editable").html($(config.id).find("textarea").val());
        }
    };

    var verifyConfig = function(conf){
        if(!conf.id){
            console.log("config.id not configured...");
            return false;
        }
        if(!conf.action){
            console.log("config.action not configured...");
            return false;
        }
        if(!(typeof conf.ajaxSubmitCallback === "function")){
            console.log("config.ajaxSubmitCallback not a function...");
        }
        if(!conf.prepare){
            conf.prepare = function(){};
        }
        return true;
    };
    init(conf);
    this.submit();
};
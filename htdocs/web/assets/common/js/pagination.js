var Pagination = function (append) {
    /***pagination html***/
    var createHtml = function (append) {
        var html = "<div class='btn-group' style='margin-bottom: 10px;'>"
                 + "<div id='position'></div>"
                 + "<div id='display_data'></div>"
                 + "<div class='display'></div>"
                 + "</div>";
        $(append).append(html);
    };

    var pages = {};
    /**config**/
    this.config = function(data){
        /**
         {
         'pagination' : '.display',
         'pagination_data' : '#display_data',
         'pagination_position' : '#position',
         'total_records' : '{{ cnt }}',
         'records_per_page':2
         }
         */
        if(noException(data)){
            data['total_pages'] = totalPages(data);
            data['current_page'] = currentPage(data);
            data['byAjax'] = data['byAjax'] ? data['byAjax'] : false;
            pages = data;
            buildPagination();
        }
    };


    /**
     * 检验参数
     * @param data
     * @returns {boolean}
     */
    var noException = function(data){
        if(!data['total_records']){
            console.log('total_records not configured ...');
            return false;
        }

        if(!data['records_per_page']){
            console.log('records_per_page not configured ...');
            return false;
        }

        if(!data['pagination_position']){
            console.log('pagination_position not configured ...');
            return false;
        }

        if(!data['pagination']){
            console.log('pagination not configured ...');
            return false;
        }
        return true;
    };
    /**构建pagination**/
    var buildPagination = function(){

        $(pages.pagination_position).html(position());
        $(pages.pagination).html(paginationControls());
        $(".pagination").find('a').click(function(){
            pageClick($(this).attr('class'));
        });
        if(pages.byAjax){
            $(".pagination").find("a").click(function(e){
                e.preventDefault();
                var spa = new SPA();
                spa.spaAction(this);
            });
        }
    };

    var pageClick = function(className){
        className = '.' + className;
        switch(className){
            case '.link_active':    pages.current_page = $(className).html();
                break;

            case '.first':   pages.current_page = 1;
                break;

            case '.last':   pages.current_page = pages.total_pages;
                break;

            case '.previous': pages.current_page -= 1;
                break;

            case '.next': pages.current_page += 1;
                break;
        }
        buildPagination();
    };

    /**总页数**/
    var totalPages = function (data) {
        if(data['total_records']){
            var total_records = data['total_records'];
        }
        if(data['records_per_page']){
            var records_per_page = data['records_per_page'];
        }
        return Math.ceil(total_records/records_per_page);
    };

    /**当前页**/
    var currentPage = function(data){
        if(data['current_page']){
            var current_page = data['current_page'];
        }else {
            var current_page = '';
        }

        var total_pages = totalPages(data);

        if(current_page == '' || current_page<1 || current_page>total_pages){
            current_page = 1;
        }
        return parseInt(current_page);
    };

    var position = function () {
        /*return "<br/><span class='label label-success'>"+pages.current_page+"/"+pages.total_pages+"</span><br/>";*/
    };

    var paginationControls = function(){
        var previous = pages.current_page - 1;
        var next     = pages.current_page + 1;
        var page     = "<nav><ul class='pagination'>"
            +"<li><a href='"+pages.url.replace('{page}',1)+"' aria-label='Previous' class='first'><span aria-hidden='true'><<</span></a></li>";
        if(pages.current_page>=2){
            page += "<li><a href='"+pages.url.replace('{page}',pages.current_page-1)+"' aria-label='Previous' class='previous'><span aria-hidden='true'><</span></a></li>"
        }
        var start_page = 1;
        var end_page  = 1;

        if(pages.current_page <= pages.total_pages && pages.current_page>start_page+2){
            start_page = pages.current_page - 2;
        }
        if(pages.current_page<=pages.total_pages && pages.current_page<pages.total_pages-2){
            end_page = parseInt(pages.current_page) + 2;
        }else{
            end_page = pages.total_pages;
        }
        page += "&emsp;";
        for(start_page; start_page<=end_page; start_page++){
            if( pages.current_page==start_page ){
                page += "<li class='active link_disabled'><a class='btn' href='"+pages.url.replace('{page}',start_page)+"'>"+start_page+"<span class='sr-only'>(current)</span></a></li>";
            }else{
                page += "<li><a href='"+pages.url.replace('{page}',start_page)+"' class='link_active'>"+start_page+"</a></li>";
            }
            page += "&emsp;";
        }
        if(pages.current_page < pages.total_pages){
            page += "<li><a href='"+pages.url.replace('{page}',pages.current_page+1)+"' aria-label='Previous' class='next'><span aria-hidden='true'>></span></a></li>";
        }
        page += "&emsp;";
        page += "<li><a href='"+pages.url.replace('{page}',pages.total_pages)+"' aria-label='Previous' class='last'><span aria-hidden='true'>>></span></a></li>"
        page += "</ul></nav>";
        return page;
    };

    /**构造函数初始化**/
    var init = function (append) {
        createHtml(append);
    };
    init(append);
};
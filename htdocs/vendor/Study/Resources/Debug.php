<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/7/26
 * Time: 16:28
 */

namespace Study\Resources;


class Debug
{

    protected static $debugPackage;

    public static function addDebug($key, $val){
        self::$debugPackage[$key] = $val;
    }

    protected static $css = "<style>
    .sf-toolbarreset{background-color:#222;opacity:0.6;bottom:0;box-shadow:0 -1px 0 rgba(0,0,0,.2);color:#EEE;font:20px Arial,sans-serif;left:0;margin:0;padding:0 36px 0 0;position:fixed;right:0;text-align:left;text-transform:none;z-index:99999;-webkit-font-smoothing:subpixel-antialiased;-moz-osx-font-smoothing:auto}
    .sf-toolbar-info {
	background-color: #444;
	opacity:0.6;
	bottom: 16px;
	color: #F5F5F5;
	display: none;
	padding: 9px 0;
	position: absolute;
    }
    .sf-close {
    font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
	background: #444;
	display: block;
	position: fixed;
	bottom: 0;
	right: 5px;
	width: 168px;
	height: 28px;
	cursor: pointer;
	text-align: center;
	z-index:99999;
    }
    </style>";

    protected static $js = "<script>
    $('.sf-toolbarreset a').hover(function(){
        $(this).next().show();
    },function(){
        $('.sf-toolbar-info').hide();
    });
    $('.sf-close').click(function(){
        $(this).prev().hide();
        $(this).hide();
    });
    </script>";
    public static function load($startTime){
        self::addDebug('system_runtime', (int)((microtime(true) - $startTime)*1000));
        $runtime = self::debugRuntime();
        $route = self::debugRoute();
        $memory = self::debugMemory();
        $now = date('Y-m-d H:i:s');
        $close = "<button class='btn btn-sm pull-right sf-close'>{$now} | X</button>";
        echo self::$css.
            "<div class='sf-toolbarreset'><span>{$runtime} | {$route} | {$memory}</span></div>{$close}".
            self::$js;
    }

    protected static function debugMemory(){
        $memory_usage = round(memory_get_usage()/1024/1024,2)."MB";
        return "<a href=''> <i class='fa fa-gears'></i> $memory_usage</a>";
    }

    protected static function debugRuntime(){
        $system_runtime = isset(self::$debugPackage['system_runtime']) ? self::$debugPackage['system_runtime'] : "";
        $query_runtime = isset(self::$debugPackage['query_runtime']) ? self::$debugPackage['query_runtime'] : "";
        $build_runtime = isset(self::$debugPackage['build_runtime']) ? self::$debugPackage['build_runtime'] : "";
        return "<a href=''><i class='fa fa-clock-o'></i> {$system_runtime}毫秒</a><ul class='sf-toolbar-info'><li>query:{$query_runtime}</li><li>build:{$build_runtime}毫秒</li></ul>";
    }

    protected static function debugRoute(){
        if(isset(self::$debugPackage['route'])){
            $_route = self::$debugPackage['route'];
            return "<a href=''> @ {$_route['name']}</a><ul class='sf-toolbar-info'><li>url : {$_route['url']}</li><li>action : {$_route['action']}</li></ul>";
        }
        return false;
    }
}
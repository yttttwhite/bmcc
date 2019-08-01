<?php
/**
 * sample to test
 *
 * https://localhost/samples/www/index.php/zone/default/entry/a/b/c
 * https://localhost/samples/www/index.php/zone-default-entry-a-b-c.html
 *
 */
#xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
require_once("global.php");
define("ROOT_APP",			ROOT."/app");


#SlightPHP::setDebug(true);
SlightPHP::setAppDir(ROOT_APP);
SlightPHP::setDefaultZone("main");
SlightPHP::setDefaultPage("main");
SlightPHP::setDefaultEntry("entry");
SlightPHP::setSplitFlag("-_.");

//{{{
SRoute::setConfigFile(ROOT_CONFIG."/route_app.ini");
SDb::setConfigFile(ROOT_CONFIG. "/db.conf");
//}}}
if(($r=SlightPHP::run())===false){
	echo("404 error");
}elseif(is_object($r)){
	var_dump($r);
}else{
	echo($r);
}
#$xhprof_data = xhprof_disable();
#$xhprof_root = '/data/www/bcsvn/bs/www/xhprof-0.9.4';
#include_once $xhprof_root."xhprof_lib/utils/xhprof_lib.php";
#include_once $xhprof_root."xhprof_lib/utils/xhprof_runs.php";
#$xhprof_runs = new XHProfRuns_Default();
#$run_id = $xhprof_runs->save_run($xhprof_data, "hx");
#echo "\n";
#echo "\n";
#echo '<a href="https://admin.bcdata.com.cn/xhprof-0.9.4/xhprof_html/index.php?run='.$run_id.'&source=hx" target="_blank">统计查看</a>';

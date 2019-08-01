<?php
/**
 * sample to test
 *
 * https://localhost/samples/www/index.php/zone/default/entry/a/b/c
 * https://localhost/samples/www/index.php/zone-default-entry-a-b-c.html
 *
 */
if(isset($_GET['debug'])&&$_GET['debug']==2){
    $xhprof = 1;
}else{
    $xhprof = 0;
}
if($xhprof){
	xhprof_enable();
}
require_once("global.php");
ob_start();
define("ROOT_APP",			ROOT."/app_admin");

#SlightPHP::setDebug(true);
SlightPHP::setAppDir(ROOT_APP);
SlightPHP::setDefaultZone("main");
SlightPHP::setDefaultPage("main");
SlightPHP::setDefaultEntry("entry");
SlightPHP::setSplitFlag(".");

//{{{
SDb::setConfigFile(ROOT_CONFIG. "/db.conf");
//}}}
if(($r=SlightPHP::run())===false){
	echo("SlightPHP:404 error");
}elseif(is_object($r)){
	var_dump($r);
}else{
	echo($r);
	//记录系统日志
	$logConfig = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
	$logConfig['log'] = true;
	if($logConfig['log']){
//	    log_api::log();
	}
}
if($xhprof){
	$xhprof_data = xhprof_disable();
	$XHPROF_ROOT = '/data/www/bcsvn/bs_zj/www';
	include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
	include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";
	$xhprof_runs = new XHProfRuns_Default();
	$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");
	echo "<a href='/xhprof_html/index.php?run=$run_id&source=xhprof_foo' target='_blank' style='z-index: 1000; position: absolute; top: 0; right: 0;'>查看性能图示</a>";
}

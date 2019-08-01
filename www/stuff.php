<?php
/**
 * https://stuff.bcdata.com.cn/$FILEID
 *
 * 素材服务器
 */
require_once("global.php");

define("ROOT_APP",			ROOT."/app_stuff");

#SlightPHP::setDebug(true);
SlightPHP::setAppDir(ROOT_APP);
SlightPHP::setDefaultZone("main");
SlightPHP::setDefaultPage("main");
SlightPHP::setDefaultEntry("entry");
SlightPHP::setSplitFlag("-_.");

//{{{
SRoute::setConfigFile(ROOT_CONFIG."/route_stuff.ini");
//}}}
if(($r=SlightPHP::run())===false){
	echo("404 error");
}elseif(is_object($r)){
	var_dump($r);
}else{
	echo($r);
}

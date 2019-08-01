<?php
date_default_timezone_set("Asia/Shanghai");
ini_set("display_errors","Off");
ini_set("session.cookie_httpsonly", 1);
$_debug = 0;
$_dev = 0;
if($_debug == 1 || isset($_GET['debug'])){
    define("DEBUG",1);
    ini_set("display_errors","On");
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
}else{
    define("DEBUG",0);
}

define("ROOT",				dirname(dirname(__FILE__)));
define("ROOT_WWW",			ROOT."/www");
define("ROOT_DATA",			ROOT."/www/data");
define("ROOT_SLIGHTPHP",	ROOT."/framework");
define("ROOT_PLIGUNS",		ROOT."/framework/plugins");

$urlInfo = parse_url($_SERVER['HTTP_HOST']);
if(isset($urlInfo['host'])){
    $host = $urlInfo['host'];
}else{
    $host = $_SERVER['HTTP_HOST'];
}
switch ($host) {
    case '42.159.148.31':
        define("ROOT_CONFIG",ROOT."/config_bidder/taizhou");
        break;
        
    case '112.124.46.89':
        define("ROOT_CONFIG",ROOT."/config_test");
        break;

    default:
        define("ROOT_CONFIG",ROOT."/config");
        break;
}

require_once(ROOT_SLIGHTPHP."/SlightPHP.php");
require_once(ROOT."/libs/db/db.class.php");
function __autoload($class){
	if($class{0}=="S"){
		$file = ROOT_PLIGUNS."/$class.class.php";
	}else{
		$file = SlightPHP::$appDir."/".str_replace("_","/",$class).".class.php";
	}
	if(is_file($file)) return require_once($file);
}
spl_autoload_register('__autoload');
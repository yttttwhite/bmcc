<?php
class main_js extends STpl{
    public $config;
	function __construct(){
		$config= SConfig::getConfig(ROOT_CONFIG."/js.conf");
		$this->config = $config;
		$this->assign("config",$config);
		STpl::$left_delimiter ="{{{";
		STpl::$right_delimiter ="}}}";
		cache_page::set(60*60*24);
		header("content-type: application/x-javascript");

		//// 种cookie
		//$lifetime = 30 * 24 * 60 * 60; 
		//$cookie_key = "mkl_sid";
		//if (empty($_COOKIE[$cookie_key])) {
		//	    $cookie_value = md5(time() * 100000 + rand());
		//		setcookie($cookie_key, $cookie_value, time() + $lifetime, "/");
		//}

	}
	function pageEntry($inPath){
	    if(isset($_GET['bidder'])){
	        $bidder = $_GET['bidder'];
	    }else{
	        $bidder = 0;
	    }
	    if(isset($_GET['ver'])){
	        $version = $_GET['ver'];
	    }else{
	        $version = 0;
	    }
	    $time = time();
	    $this->assign('time',$time);
	    $this->assign('bidder',$bidder);
	    $this->assign('version',$version);
	    
	    if(isset($this->config->version->partner) && $this->config->version->partner === "zhejiang"){
	        return $this->render("main/js_entry.zj.html");
	    }else{
	        return $this->render("main/js_entry.html");
	    }
		
	}
	function pageOrgin($inPath){
		return $this->render("main/js_orgin.html");
	}
}

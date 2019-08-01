<?php
class public_lib extends STpl{
	function __construct(){
	    $jsConfig = array(
	        'neibu'=>ROOT_CONFIG."/js-neibu.conf"
	    );
	    
	    if(isset($_GET['type']) && isset($jsConfig[$_GET['type']])){
	        $config= SConfig::getConfig($jsConfig[$_GET['type']]);
	    }else{
	        echo "404 ERROR!";
	        exit();
	    }
		$this->assign("config",$config);
		STpl::$left_delimiter ="{{{";
		STpl::$right_delimiter ="}}}";
		cache_page::set(60*60*24);
		header("content-type: application/x-javascript");
	}
	function pageMain($inPath){
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
		return $this->render("main/js_entry.html");
	}
	function pageSsp($inPath){
		return $this->render("main/js_orgin.html");
	}
}

<?php
class ad_js extends STpl{
	function __construct(){
		$config= SConfig::getConfig(ROOT_CONFIG."/js.conf");
		$this->assign("config",$config);
		STpl::$left_delimiter ="{{{";
		STpl::$right_delimiter ="}}}";
	}
	function pageEntry($inPath){
		cache_page::set(60*60*24);
		header("content-type: application/x-javascript");
		$adid = $inPath[3];
		$sp = "";
		$adsl = "";
		$bidder = 0;
		if(!empty($_REQUEST['sp'])){ $sp=$_REQUEST['sp']; }
		if(!empty($_REQUEST['sda_man'])){ $adsl = $_REQUEST['sda_man']; }
		if(isset($_GET['bidder'])){$bidder = $_GET['bidder'];}
		$this->assign("adid",$adid);
		$this->assign("bidder", $bidder);
		$this->assign("sp",$sp);
		$this->assign("adsl", $adsl);
		$this->assign("get", $_GET);
		return $this->render("ad/js_entry.html");
	}
	function pageTest($inPath){
		echo '<html><head><script src="https://js.bcdata.com.cn/ad.1600.js"></script></head><body></body></html>';
	}
	function pageIframe($inPath){
		header("content-type: application/x-javascript");
		if(!empty($_GET['url'])){
			$this->assign("url",urlencode($_GET['url']));
			return $this->render("ad/js_iframe.html");
		}
	}
}
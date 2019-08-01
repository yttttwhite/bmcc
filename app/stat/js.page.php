<?php
header("content-type: application/x-javascript");
class stat_js extends STpl{
	function __construct(){
		$config= SConfig::getConfig(ROOT_CONFIG."/js.conf");
		$this->assign("config",$config);
		STpl::$left_delimiter ="{{{";
		STpl::$right_delimiter ="}}}";
		cache_page::set(60*60*24);
		header("content-type: application/x-javascript");
	}
	public function pageEntry(){
		return $this->render("stat/js_entry.html");
	}
}
?>

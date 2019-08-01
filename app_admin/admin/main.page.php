<?php
class admin_main extends STpl{
	public function __construct($inPath){
	}

	public function pageEntry($inPath){
		header("location:/baichuan_advertisement_manage/admin.user.list");
		//return $this->render("v2/gaoji/ggz.html");
	}
	public function pageNav($inPath){
		if(!empty($inPath[3])){
			$this->assign("nav",$inPath[3]);
		}
		if(!empty($inPath[4])){
			$this->assign("nav_sub",$inPath[4]);
		}
		return $this->render("admin/main_nav.html");
	}


}

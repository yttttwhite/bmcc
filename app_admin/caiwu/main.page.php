<?php
class caiwu_main extends STpl{
	public function __construct($inPath){
	    if(!user_api::auth("financial")){
	        $this->success("没有权限",'/baichuan_advertisement_manage/user',1);
	        exit();
	    }
	}
	public function pageEntry($inPath){
		$this->assign("user_info",user_api::info());
		return $this->render("v2/caiwu/index.html");
	}
}

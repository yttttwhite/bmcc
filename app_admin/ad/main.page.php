<?php
class ad_main extends STpl{
	public function __construct($inPath){
		if(user_api::id()==0){
			header("location:/baichuan_advertisement_manage/user");
		}
	}
	public function pageHeader($inPath){
		return $this->render("header.ad.part");
	}
	public function pageEntry($inPath){
		header("location:/baichuan_advertisement_manage/ad.plan");
	}
}

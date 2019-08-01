<?php
class dsp_main extends STpl{
	public function __construct($inPath){
		if(user_api::id()==0){
			header("location:/baichuan_advertisement_manage/user");
		}
	}
	public function pageEntry($inPath){
		return $this->pageList($inPath);
	}
	public function pageList($inPath){
		$dsps = dsp_db::listDSP(user_api::id());
		if(!empty($dsps)){ 
			$pager = pager_api::page($dsps,"?page=%p");
			$this->assign("pager",$pager);
		}
		$this->assign("dsps",$dsps);
		return $this->render("v2/dsp/dsp.html");
	}
	public function pageAdd($inPath){
		//$condi=array("uid"=>user_api::id());
		//{{{
		$dsp=array();
		$dsp_id=0;
		if(!empty($inPath[3])){
			$dsp_id=$inPath[3];
			$dsp= dsp_db::getDSP($dsp_id);
			if(empty($dsp) || $dsp['uid']!=user_api::id()){
				die("参数错误");
			}
		}
		if(!empty($_POST['dsp_name'])){//名称是必须的
			if(!empty($dsp)){//修改
				foreach($dsp as $k=>$v){
					if($k=="dsp_token")continue;
					if(isset($_POST[$k]))$dsp[$k]=$_POST[$k];
				}
				$r = dsp_db::updateDSP($dsp_id,$dsp);
				if($r!==false){
					$this->assign("result","修改成功");
				}else{
					$this->assign("result","修改失败");
				}
			}else{//新增
				$dsp=array(
						"dsp_name"=>"","dsp_token"=>"","dsp_cms_url"=>"","dsp_bid_url"=>"","dsp_notice_url"=>"","dsp_max_qps"=>"",
						"dsp_comment"=>"","status"=>"1","enabled"=>"0","contact_name"=>"","contact_email"=>"","contact_mobile"=>"",
						"contact_address"=>"",
						"contact_zipcode"=>"",
						"contact_company"=>"",
						"contact_website"=>"",
						"contact_comment"=>"",
						);
				foreach($dsp as $k=>$v){
					if(isset($_POST[$k]))$dsp[$k]=$_POST[$k];
				}
				$dsp['uid']=user_api::id();
				$dsp['_inserttime']=date("Y-m-d H:i:s");
				$dsp_id= dsp_db::addDsp($dsp);
				if($dsp_id){
					$dsp= dsp_db::getDSP($dsp_id);
					$this->assign("result","新增成功");
				}else{
					$this->assign("result","新增失败");
				}
			}
			dsp_db::updateDspCache($dsp_id);
		}
		if(empty($dsp['dsp_token'])){
			$dsp['dsp_token']=md5(time().":".rand(1,1000000));
		}
		$this->assign("dsp",$dsp);
		//}}}
		return $this->render("v2/dsp/dsp_new.html");
	}
	public function pageNav($inPath){
		if(!empty($inPath[3])){
			$this->assign("nav",$inPath[3]);
		}
		if(!empty($inPath[4])){
			$this->assign("nav_sub",$inPath[4]);
		}
		return $this->render("v2/dsp/nav.tpl");
	}
}

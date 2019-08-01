<?php
class media_website extends STpl{
    public function __construct(){
        if(!user_api::auth("media")){
            $this->success("没有权限",'/user',3);
            exit();
        }
    }
	public function pageEntry($inPath){
		$page=!empty($_REQUEST['page']) ? $_REQUEST['page'] :1 ;
		$cat =!empty($_REQUEST['cat']) ? $_REQUEST['cat'] :"" ;
		$s=!empty($_REQUEST['size']) ? $_REQUEST['size'] :"" ;
		$key=!empty($_REQUEST['key']) ? addslashes($_REQUEST['key']) :"" ;
		$condi=array("ssp_website.uid"=>user_api::id());
		$r= media_db::listWebSite($condi,$page);
		$pager = pager_api::page($r,"?page=%p&cat=$cat&size=$s");
		$this->assign("pager",$pager);
		$this->assign("websites",$r);
		return $this->render("v2/meiti/web.html");
	}
	public function pageAdd($inPath){
		$website=array();
		$website_id=0;
		if(!empty($inPath[3])){
			$website_id=$inPath[3];
			$website = media_db::getWebSite($website_id);
			if(empty($website) || $website['uid']!=user_api::id()){
				die("参数错误");
			}
		}
		if(!empty($_POST['website_name'])){//名称是必须的
			if(!empty($website)){//修改
				foreach($website as $k=>$v){
					if(isset($_POST[$k]))$website[$k]=$_POST[$k];
				}
				$r = media_db::updateWebSite($website_id,$website);
				if($r!==false){
					$this->assign("result","修改成功");
				}else{
					$this->assign("result","修改失败");
				}
			}else{//新增
				$website=array("website_id"=>0,"website_name"=>"","description"=>"","website_url"=>"");
				foreach($website as $k=>$v){
					if(isset($_POST[$k]))$website[$k]=$_POST[$k];
				}
				$website['uid']=user_api::id();
				$website['_inserttime']=date("Y-m-d H:i:s");
				$website_id = media_db::addWebSite($website);
				if($website_id){
					$website = media_db::getWebSite($website_id);
					$this->assign("result","新增成功");
				}else{
					$this->assign("result","新增失败");
				}
			}
		}
		//修改网站下的广告位数量
		media_db::updateWebSiteSlotCt($website_id);
		$this->assign("website",$website);
		return $this->render("v2/meiti/web_new.html");
	}
	public function pageNav($inPath){
		if(!empty($inPath[3])){
			$this->assign("nav",$inPath[3]);
		}
		if(!empty($inPath[4])){
			$this->assign("nav_sub",$inPath[4]);
		}
		return $this->render("v2/meiti/nav.tpl");
	}
}

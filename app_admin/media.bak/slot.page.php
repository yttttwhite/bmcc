<?php
class media_slot extends STpl{
    public function __construct(){
        if(!user_api::auth("media")){
            $this->success("没有权限",'/user',3);
            exit();
        }
    }
	public function pageEntry($inPath){
		$page=!empty($_REQUEST['page']) ? $_REQUEST['page'] :1 ;
		/*
		   $cat =!empty($_REQUEST['cat']) ? $_REQUEST['cat'] :"" ;
		   $s=!empty($_REQUEST['size']) ? $_REQUEST['size'] :"" ;
		   $key=!empty($_REQUEST['key']) ? addslashes($_REQUEST['key']) :"" ;
		   $condi=array("size"=>$s,"category"=>$cat);
		   if(!empty($key)){
		   $condi[]="web_name like '%$key%'";
		   }
		   $r= media_db::listMedia($condi,$page);
		   if(!empty($r)){
		//取出所有分类
		$cats=array();
		$type=array();
		$size=array();
		foreach($r->items as $item){
		$k=$item['category'];
		$cats[$k]="";
		$k=$item['size'];
		$size[$k]="";
		$k=$item['type'];
		$type[$k]="";
		}
		$pager = pager_api::page($r,"?page=%p&cat=$cat&size=$s");
		$this->assign("pager",$pager);
		}

		$this->assign("medias",$r);
		$this->assign("size",$size);
		$this->assign("key",$key);
		$this->assign("type",$type);
		$this->assign("cats",$cats);
		 */
		$condi=array("uid"=>user_api::id());
		$r= media_db::listSlot($condi,$page);
		$pager = pager_api::page($r,"?page=%p&cat=$cat&size=$s");
		$this->assign("pager",$pager);
		$this->assign("slots",$r);
		$config_js= SConfig::getConfig(ROOT_CONFIG."/js.conf");
		$this->assign("config_js",$config_js);
		return $this->render("v2/meiti/slot.html");
	}
	public function pageGet($inPath){
		$slot_id=$inPath[3];
		$slot= media_db::getSlotCache($slot_id);
	}
	public function pageAdd($inPath){
		$condi=array("uid"=>user_api::id());
		$r= media_db::listWebSite($condi,$page);
		$this->assign("websites",$r);
		//{{{
		$slot=array();
		$slot_id=0;
		if(!empty($inPath[3])){
			$slot_id=$inPath[3];
			$slot= media_db::getSlot($slot_id);
			if(empty($slot) || $slot['uid']!=user_api::id()){
				die("参数错误");
			}
		}
		if(!empty($_POST['slot_name'])){//名称是必须的
			if(!empty($slot)){//修改
				//重置变量
				if(!isset($_POST['creative_type'])) $_POST['creative_type']=0;
				foreach($slot as $k=>$v){
					if(isset($_POST[$k]))$slot[$k]=$_POST[$k];
				}
				$r = media_db::updateSlot($slot_id,$slot);
				media_db::updateSlotCache($slot_id);
				if($r!==false){
					$this->assign("result","修改成功");
				}else{
					$this->assign("result","修改失败");
				}
			}else{//新增
				$slot=array(
						"slot_name"=>"","website_id"=>"","width"=>"","height"=>"","style"=>"","url"=>"",
						"view_screen"=>"","min_price"=>"","priority"=>"","creative_type"=>"","adlist"=>"","status"=>"",
						"ad_type"=>"",
						);
				foreach($slot as $k=>$v){
					if(isset($_POST[$k]))$slot[$k]=$_POST[$k];
				}
				$slot['uid']=user_api::id();
				$slot['_inserttime']=date("Y-m-d H:i:s");
				$slot_id= media_db::addSlot($slot);
				if($slot_id){
					media_db::updateSlotCache($slot_id);
					//header("location:/baichuan_advertisement_manage/media.slot.add.$slot_id");
					$slot = media_db::getSlot($slot_id);
					$this->assign("result","新增成功");
				}else{
					$this->assign("result","新增失败");
				}
			}
		}
		//修改网站下的广告位数量
		if(!empty($slot['website_id'])){
			$website_id=$slot['website_id'];
			media_db::updateWebSiteSlotCt($website_id);
		}
		$this->assign("medias",$medias);
		$this->assign("slot",$slot);
		//}}}
		return $this->render("v2/meiti/slot_new.html");
	}
	public function pageAdNetwork($inPath){
		if(!empty($inPath[3])){
			$slot_id=$inPath[3];
			$slot= media_db::getSlot($slot_id);
		}
		if(empty($slot) || $slot['uid']!=user_api::id()){
			die("参数错误");
		}
		if(!empty($_POST['priority']) && isset($_POST['priority_ratio'])){
			if($_POST['priority_ratio']<0)$_POST['priority_ratio']=0;
			if($_POST['priority_ratio']>100)$_POST['priority_ratio']=100;
			$slot['priority']=$_POST['priority'];
			$slot['priority_ratio']=$_POST['priority_ratio'];
			media_db::updateSlot($slot['slot_id'],$slot);
			media_db::updateSlotCache($slot_id);
		}
		if(!empty($_POST['network_ratio'])){
			foreach($_POST['network_ratio'] as $network_id=>$network_ratio){
				if(isset($_POST['network_code'][$network_id])){
					$adnetwork=array();
					$adnetwork['slot_id']=$slot_id;
					$adnetwork['network_id']=$network_id;
					$adnetwork['network_ratio']=$network_ratio;
					$adnetwork['network_name']=media_network::$media[$network_id];
					$adnetwork['network_code']=$_POST['network_code'][$network_id];
					media_db::addSlotNetWork($adnetwork);
				}
			}
			media_db::updateSlotCache($slot_id);
		}
		$adnetwork_tanx = media_db::getSlotNetWork($slot_id,1);
		$adnetwork_google= media_db::getSlotNetWork($slot_id,2);
		$adnetwork_baidu= media_db::getSlotNetWork($slot_id,3);
		$this->assign("slot",$slot);
		$this->assign("adnetwork_tanx",$adnetwork_tanx);
		$this->assign("adnetwork_google",$adnetwork_google);
		$this->assign("adnetwork_baidu",$adnetwork_baidu);
		return $this->render("v2/meiti/liuliang-new.html");
	}
	/**
	  URL(网址控制，广告着陆页地址屏蔽)
	 */
	public function pageURL($inPath){
		if(!empty($inPath[3])){
			$slot_id=$inPath[3];
			$slot= media_db::getSlot($slot_id);
		}
		if(empty($slot) || $slot['uid']!=user_api::id()){
			die("参数错误");
		}
		//操作屏蔽-新增
		if(!empty($_POST['urls'])){

			if(filter_var("https://".$_POST['urls'],FILTER_VALIDATE_URL)===false){
				$this->assign("result",$_POST['urls']."不是有效果的URL");
			}else{
				//添加屏蔽
				media_db::addSlotBanURL($slot['slot_id'],"https://".$_POST['urls']);
			}
		}
		if(!empty($_GET['ban_url'])){
			if($_GET['flag']=='cancel'){
				//添加屏蔽
				media_db::delSlotBanURL($slot['slot_id'],urldecode($_GET['ban_url']));
			}
			media_db::updateSlotCache($slot['slot_id']);
		}
		//获取广告位的屏蔽信息
		$ban_urls = media_db::listSlotBanURL($slot['slot_id']);
		$this->assign("ban_urls",$ban_urls);

		$this->assign("slot",$slot);
		return $this->render("v2/meiti/slot-url.html");
	}
	/**
	  DSP控制
	 */
	public function pageDSP($inPath){
		if(!empty($inPath[3])){
			$slot_id=$inPath[3];
			$slot= media_db::getSlot($slot_id);
		}
		if(empty($slot) || $slot['uid']!=user_api::id()){
			die("参数错误");
		}
		//获取所有dsp信息
		$dsps = dsp_db::listDSP();
		$this->assign("dsps",$dsps);
		//操作屏蔽
		if(!empty($_GET['dsp_id'])){
			if($_GET['flag']=='set'){
				//添加屏蔽
				media_db::addSlotBanDSP($slot['slot_id'],$_GET['dsp_id']);
			}elseif($_GET['flag']=='cancel'){
				//取消屏蔽
				media_db::delSlotBanDSP($slot['slot_id'],$_GET['dsp_id']);
			}
			media_db::updateSlotCache($slot['slot_id']);
		}
		//获取广告位的屏蔽信息
		$ban_dsps= media_db::listSlotBanDSP($slot['slot_id']);
		$this->assign("ban_dsps",$ban_dsps);

		/*
		   if(!empty($_POST['priority']) && isset($_POST['priority_ratio'])){
		   if($_POST['priority_ratio']<0)$_POST['priority_ratio']=0;
		   if($_POST['priority_ratio']>100)$_POST['priority_ratio']=100;
		   $slot['priority']=$_POST['priority'];
		   $slot['priority_ratio']=$_POST['priority_ratio'];
		   media_db::updateSlot($slot['slot_id'],$slot);
		   media_db::updateSlotCache($slot_id);
		   }
		   if(!empty($_POST['network_ratio'])){
		   foreach($_POST['network_ratio'] as $network_id=>$network_ratio){
		   if(isset($_POST['network_code'][$network_id])){
		   $adnetwork=array();
		   $adnetwork['slot_id']=$slot_id;
		   $adnetwork['network_id']=$network_id;
		   $adnetwork['network_ratio']=$network_ratio;
		   $adnetwork['network_name']=media_network::$media[$network_id];
		   $adnetwork['network_code']=$_POST['network_code'][$network_id];
		   media_db::addSlotNetWork($adnetwork);
		   }
		   }
		   media_db::updateSlotCache($slot_id);
		   }
		   $adnetwork_tanx = media_db::getSlotNetWork($slot_id,1);
		   $adnetwork_google= media_db::getSlotNetWork($slot_id,2);
		   $adnetwork_baidu= media_db::getSlotNetWork($slot_id,3);
		   $this->assign("adnetwork_tanx",$adnetwork_tanx);
		   $this->assign("adnetwork_google",$adnetwork_google);
		   $this->assign("adnetwork_baidu",$adnetwork_baidu);
		 */
		$this->assign("slot",$slot);
		return $this->render("v2/meiti/slot-dsp.html");
	}
	/**
	  Trade(行业)控制
	 */
	public function pageCategory($inPath){
		if(!empty($inPath[3])){
			$slot_id=$inPath[3];
			$slot= media_db::getSlot($slot_id);
		}
		if(empty($slot) || $slot['uid']!=user_api::id()){
			die("参数错误");
		}
		//获取所有分类信息
		$cates = media_db::listAdCate();
		$this->assign("cates",$cates);
		//操作屏蔽
		if(!empty($_GET['cate_id'])){
			if($_GET['flag']=='set'){
				media_db::addSlotBanCategory($slot['slot_id'],$_GET['cate_id']);
			}else{
				media_db::delSlotBanCategory($slot['slot_id'],$_GET['cate_id']);
			}
		}
		if(!empty($_GET['cate'])){
			$cate = $_GET['cate'];
			if($_GET['flag']=='set'){
				//添加屏蔽
				if(!empty($cates[$cate])){
					foreach($cates[$cate] as $item){
						media_db::addSlotBanCategory($slot['slot_id'],$item['type_id']);
					}
				}
			}elseif($_GET['flag']=='cancel'){
				//取消屏蔽
				if(!empty($cates[$cate])){
					foreach($cates[$cate] as $item){
						media_db::delSlotBanCategory($slot['slot_id'],$item['type_id']);
					}
				}
			}
			media_db::updateSlotCache($slot['slot_id']);
		}
		//获取广告位的分类屏蔽信息
		$ban_cates= media_db::listSlotBanCategory($slot['slot_id']);
		$this->assign("ban_cates",$ban_cates);

		/*
		   if(!empty($_POST['priority']) && isset($_POST['priority_ratio'])){
		   if($_POST['priority_ratio']<0)$_POST['priority_ratio']=0;
		   if($_POST['priority_ratio']>100)$_POST['priority_ratio']=100;
		   $slot['priority']=$_POST['priority'];
		   $slot['priority_ratio']=$_POST['priority_ratio'];
		   media_db::updateSlot($slot['slot_id'],$slot);
		   media_db::updateSlotCache($slot_id);
		   }
		   if(!empty($_POST['network_ratio'])){
		   foreach($_POST['network_ratio'] as $network_id=>$network_ratio){
		   if(isset($_POST['network_code'][$network_id])){
		   $adnetwork=array();
		   $adnetwork['slot_id']=$slot_id;
		   $adnetwork['network_id']=$network_id;
		   $adnetwork['network_ratio']=$network_ratio;
		   $adnetwork['network_name']=media_network::$media[$network_id];
		   $adnetwork['network_code']=$_POST['network_code'][$network_id];
		   media_db::addSlotNetWork($adnetwork);
		   }
		   }
		   media_db::updateSlotCache($slot_id);
		   }
		   $adnetwork_tanx = media_db::getSlotNetWork($slot_id,1);
		   $adnetwork_google= media_db::getSlotNetWork($slot_id,2);
		   $adnetwork_baidu= media_db::getSlotNetWork($slot_id,3);
		   $this->assign("adnetwork_tanx",$adnetwork_tanx);
		   $this->assign("adnetwork_google",$adnetwork_google);
		   $this->assign("adnetwork_baidu",$adnetwork_baidu);
		 */
		$this->assign("slot",$slot);
		return $this->render("v2/meiti/slot-category.html");
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

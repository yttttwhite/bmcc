<?php
class media_position extends STpl{
    public function __construct($inPath){
	$exclude_arr = array("getwebsites","getpositions","getprice");
        if(!user_api::auth("media")&& !in_array($inPath[2],$exclude_arr)){
            $this->success("没有权限",'/user',3);
            exit();
        }
    }
	public function pageEntry($inPath){
	    $position_thrift = new thrift_admedia_main;
	    $medias = $position_thrift->getAllMedia();
	    $channels = $position_thrift->getAllChannel();
	    $user_thrift = new thrift_aduser_main;
	    $users = $user_thrift->getAdUsersByCid(-1,-1);
	    $id2name = array();
	    foreach ($users as $u){
	        if(!isset($id2name[$u->uid])){
	            $id2name[$u->uid] = $u->user_name;
	        }
	    }
	    $id2media = array();
	    foreach ($medias as $m){
	        if(!isset($id2media[$m->id])){
	            $id2media[$m->id] = $m;
	        }
	    }
	    $id2channel = array();
	    foreach ($channels as $ch){
	        if(!isset($id2channel[$ch->channel_id])){
	             $id2channel[$ch->channel_id] = $ch;
	        }
	    }
		$stuff_types=array("pic"=>"图片","video"=>"视频","pictxt"=>"图文","txt"=>"文字","others"=>"其他",);
		$all_positions = $position_thrift->getAllPo();
		if(isset($inPath[3])){
			foreach ($all_positions as $position) {
				$channel_id = $inPath[3];
				if ($channel_id == $position->channel_id) {
					$positions[] = $position;
				}
			}
		}else{
			$positions = $all_positions;
		}
		//过滤数据
		foreach ($positions as $key => $v) {
		    if (isset($_GET['position_name']) && strlen($_GET['position_name']) > 0 && stripos(trim($v->position_name), trim($_GET['position_name'])) === false) {
		        unset($positions[$key]);
		    }
		}
		// 分页处理
		$total = count($positions);
		if ($_GET['pageNum']) {
		    $pageNum = $_GET['pageNum'];
		} else {
		    $pageNum = 1;
		}
		$pageSize = 20;
		if ($pageNum * $pageSize - 1 <= $total) {
		    $start = ($pageNum - 1) * $pageSize;
		    $end = $pageNum * $pageSize - 1;
		} else {
		    $start = ($pageNum - 1) * $pageSize;
		    $end = $total - 1;
		}
		$positions = array_slice($positions, $start, $pageSize);
		$totalPage = ceil($total / $pageSize);
		$this->assign("totalPage", $totalPage);
		$this->assign("pageNum", $pageNum);
		$this->assign("positions",$positions);
		$config_js= SConfig::getConfig(ROOT_CONFIG."/js.conf");
		$this->assign("config_js",$config_js);
		$this->assign("medias",$medias);
		$this->assign("channels",$channels);
		$this->assign("id2media",$id2media);
		$this->assign("id2channel",$id2channel);
		$this->assign("stuff_types",$stuff_types);
		$this->assign("id2name",$id2name);
		return $this->render("v2/meiti/slot.html");
	}
	public function pageGet($inPath){
		$slot_id=$inPath[3];
		$slot= media_db::getSlotCache($slot_id);
	}
	public function pageAdd($inPath){
	    $position_thrift = new thrift_admedia_main;
	    $medias = $position_thrift->getAllMedia();
	    $channels = $position_thrift->getAllChannel();
	    $media2channel = array();
	    foreach ($channels as $k => $item){
	        $media2channel[$item->media_id][]=$item->channel_id;
	    }
		$position_id = 0;
		if(!empty($inPath[3])){
			$position_id = $inPath[3];
			$position = $position_thrift->getPoById($position_id);
			if(empty($position->position_name) || $position->creator_id != user_api::id()){
				die("参数错误");
			}
		}
		if(!empty($_POST['position_name'])&& !empty($_POST['channel_id'])){//名称,所属的频道是必须的
			if(!empty($position)){//修改
				foreach($position as $k=>$v){
					if(isset($_POST[$k]))
					    $position->$k=$_POST[$k];
				}
				$position_up = $position_thrift->updatePosition($position_id,$position);
				if($position_up >= 0){
					$this->assign("result","修改成功");
				}else{
					$this->assign("result","修改失败");
				}
			}else{//新增
			    $position =new AdPosition();
			    
				$position_info = array(
						"id"=>0,
						"media_id"=>"",
						"position_name"=>"",
						"position_identification"=>"",
						"channel_id"=>"",
						"width"=>"",
						"height"=>"",
						"first_screen"=>"",
						"stuff_type"=>"",
						"cpm"=>"",
						"cpc"=>"",
						"cpt"=>"",
						"status"=>"",
						"position_comment"=>"",
						);
				foreach($position_info as $k=>$v){
					if(isset($_POST[$k])){
					    $position->$k = $_POST[$k];
					}
				}
				$now = time();
				$position->creator_id  = user_api::id();
				$position->create_time = $now;
				$position->alter_time  = $now;
				$position->tag_identification = $_POST['tag_identification'];
				/***
				 * 选择 广告位标签，广告位写入cpc.cpt.cpm的价格
				 */
				/*$positionModel = new model_sspPosition();
				$conditionPrice= array();
				$conditionPrice['tag_identification'] = $_POST['tag_identification'];
				$dataPrice = array();
				$dataPrice  = $positionModel->getData($conditionPrice, 0,-1);
				if($dataPrice){
				    $cpmPrice = $dataPrice[0]['cpm_price'];
				    $cpcPrice = $dataPrice[0]['cpc_price'];
				    $cptPrice = $dataPrice[0]['cpt_price'];
				}*/
				/***************选择广告位标签写入价格*****************/
				$position_id = $position_thrift->addPosition($position);
				if($position_id >= 0){
					$position = $position_thrift->getPoById($position_id);
					$this->assign("result","新增成功");
				}else{
					$this->assign("result","新增失败");
				}
			}
		}
		//修改网站下的广告位数量
		if(isset($_GET['media_id']) && ($_GET['media_id'] >0)){
			$media_id = $_GET['media_id'];
		}
		if(isset($_GET['channel_id']) && ($_GET['channel_id'] >0)){
			$channel_id = $_GET['channel_id'];
		}
		$this->assign("media_id",$media_id);
		$this->assign("channel_id",$channel_id);
		$this->assign("medias",$medias);
		$this->assign("channels",$channels);
		$this->assign("position",$position);
		$this->assign("media2channel",$media2channel);
		return $this->render("v2/meiti/slot_new.html");
	}
      public function pageGetWebsites($inPath){
            $position_thrift = new thrift_admedia_main;
            $medias = $position_thrift->getAllMedia();
		  	$channels = $position_thrift->getAllChannel();
            foreach ($channels as $k => $item){
                $media2channel[$item->media_id][] = $item;
            }
	    if(isset($media2channel[$inPath[3]])){
	        $result = $media2channel[$inPath[3]];
	    }else{
		$result = array();
	    }
           return  SJson::encode($result);
        }
	
       public function pageGetPositions($inPath){
            $position_thrift = new thrift_admedia_main;
            $positions= $position_thrift->getAllPo();
            foreach ($positions as $k => $item){
                $web2position[$item->channel_id][] = $item;
            }
	    if(isset($web2position[$inPath[3]])){
	        $result = $web2position[$inPath[3]];
	    }else{
		$result = array();
	    }
            return  SJson::encode($result);
        }
        
     public function pageGetPrice($inPath){
            $position_thrift = new thrift_admedia_main;
            $positions= $position_thrift->getAllPo();
            foreach ($positions as $k => $item){
                $price[$item->id][] = $item;
            }
            $result = $price[$inPath[3]];
            return  SJson::encode($result);
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
	/**
	 * 获取广告位标签
	 */
	public function pageGetTagIdent($inPath){
	    $tagModel = new model_poTag();
	    $tags = $tagModel->getData();
	    return  SJson::encode($tags);
	}

	//获取广告位置信息详情
	public function pageDetail(){
		$position_id = $_GET['position_id'];
		$media_id = $_GET['media_id'];
		$channel_id = $_GET['channel_id'];
		$position_thrift = new thrift_admedia_main;
		if(isset($position_id) && $position_id >0){
			$position = $position_thrift->getPoById($position_id);
		}
		if(isset($media_id) && $media_id >0){
			$media = $position_thrift->getMediaById($media_id);
		}
		if(isset($channel_id) && $channel_id >0){
			$channel = $position_thrift->getChannelById($channel_id);
		}
		$stuff_types=array("pic"=>"图片","video"=>"视频","pictxt"=>"图文","txt"=>"文字","others"=>"其他",);
		$user = user_api::getUserById($position->creator_id);
		$this->assign("user",$user);
		$this->assign("media",$media);
		$this->assign("channel",$channel);
		$this->assign("position",$position);
		$this->assign("stuff_types",$stuff_types);
		return $this->render("v2/meiti/position_detail.html");

	}

}

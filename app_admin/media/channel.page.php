<?php
class media_channel extends STpl{
    public function __construct(){
        if(!user_api::auth("media")){
            $this->success("没有权限",'/user',3);
            exit();
        }
    }
	public function pageEntry($inPath){
	    /* 
	     * 获取所有用户的id和对应的名字 
	     */
	    $a = new thrift_aduser_main;
	    $users = $a->getAdUsersByCid(-1,-1);
	    $id2name = array();
	    foreach ($users as $u){
	        if(!isset($id2name[$u->uid])){
	            $id2name[$u->uid] = $u->user_name;
	        }
	    }
	    /* 
	     * 获取所有的频道信息 
	     */
	    $channel_thrift = new thrift_admedia_main;
		$all_channels= $channel_thrift->getAllChannel();
		if(isset($inPath[3])){
			foreach ($all_channels as $channel) {
				$media_id = $inPath[3];
				if ($media_id == $channel->media_id) {
					$channels[] = $channel;
				}
			}
		}else{
			$channels = $all_channels;
		}

		/* 
		 * 获取所有媒体信息，并转换成为媒体id对应媒体名称 
		 */
		$medias = $channel_thrift->getAllMedia();
		$id2media = array();
		foreach ($medias as $m){
		    if(!isset($id2media[$m->id])){
		        $id2media[$m->id]=$m;
		    }
		}
		 //过滤数据
		 foreach ($channels as $key => $v) {
		    if (isset($_GET['channel_name']) && strlen($_GET['channel_name']) > 0 && stripos($v->channel_name, $_GET['channel_name']) === false) {
		        unset($channels[$key]);
		    }
		}
		// 分页处理
		$total = count($channels);
		if ($_GET['pageNum']) {
		    $pageNum = $_GET['pageNum'];
		} else {
		    $pageNum = 1;
		}
		$pageSize = 30;
		if ($pageNum * $pageSize - 1 <= $total) {
		    $start = ($pageNum - 1) * $pageSize;
		    $end = $pageNum * $pageSize - 1;
		} else {
		    $start = ($pageNum - 1) * $pageSize;
		    $end = $total - 1;
		}
		$channels = array_slice($channels, $start, $pageSize);
		$totalPage = ceil($total / $pageSize);
		$this->assign("totalPage", $totalPage);
		$this->assign("pageNum", $pageNum);
		$this->assign("id2media",$id2media);
		$this->assign("channels",$channels);
		$web_types = array("website"=>"网站","app"=>"APP","adx"=>"ADX","inside"=>"内部","others"=>"其他");
		$m_status = array("0"=>"关闭","1"=>"开启");
		$this->assign("web_types",$web_types);
		$this->assign("m_status",$m_status);
		$this->assign("id2name",$id2name);
		return $this->render("v2/meiti/web.html");
	}
	public function pageAdd($inPath){
	    $channel_thrift = new thrift_admedia_main;
	    $channels = $channel_thrift->getAllMedia();
		$channel = new Channel();
		$channel_id = 0;
		$medias = $channel_thrift->getAllMedia();
		if(!empty($inPath[3])){
			$channel_id = $inPath[3];
			$channel = $channel_thrift->getChannelById($channel_id);
			if(empty($channel->channel_name) || $channel->creator_id != user_api::id()){
				die("参数错误");
			}
		}
		$channel_info = array("media_id"=>"","channel_name"=>"","channel_identification"=>"","channel_status"=>"","channel_comment"=>"");
		if(!empty($_POST['channel_name'])&& !empty($_POST['media_id'])){//名称是必须的
			if(!empty($channel->channel_id)){//修改
			    
				foreach($channel_info as $k=>$v){
					if(isset($_POST[$k])){
					    $channel->$k = $_POST[$k];
					}
				}
				$id = $channel->channel_id;
				unset($channel->channel_id);
				$now = time();
				$channel->alter_time = $now;
				$result_up = $channel_thrift->updateChannel($id,$channel);
				if($result_up >= 0){
					$this->assign("result","修改成功");
				}else{
					$this->assign("result","修改失败");
				}
			}else{//新增
				$channel_thrift  = new thrift_admedia_main;
				$channel_new = new Channel();
				foreach($channel_info as $k=>$v){
					if(isset($_POST[$k])){
					    $channel_new->$k = $_POST[$k];
					}
				}
				$now = time();
				$channel_new->creator_id  = user_api::id();
				$channel_new->create_time = $now;
				$channel_new->alter_time  = $now;
				$channel_id = $channel_thrift->addChannel($channel_new);
				if($channel_id >= 0){
					//$channel = $channel_thrift->getChannelById($channel_id);
					$this->assign("result","新增成功");
				}else{
					$this->assign("result","新增失败");
				}
			}
		}
		if(isset($_GET['media_id']) && ($_GET['media_id'] >0)){
			$media_id = $_GET['media_id'];
		}
		$this->assign("media_id",$media_id);
		$this->assign("channel",$channel);
		$this->assign("medias",$medias);
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

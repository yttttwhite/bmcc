<?php
class media_main extends STpl{
	public function __construct($inPath){
	    $info = user_api::info();
	    //方便广告主查看广告排期
	    /*if($info->role_id!=13){
	        if(!user_api::auth("media")){
	            $this->success("没有权限",'/user',3);
	            exit();
	        }
	     }*/
	  
       //行业类型，types用于列表页，plan_types用于添加媒体页面
       $plan_thrift = new thrift_adplan_main;
       $types_tmp = $plan_thrift->getAllAdPlanTypes();
       $types = array();
       $plan_types = array();
       foreach ($types_tmp as $key => $value){
           $types[$value->type_id] = $value;
           $plan_types[$value->cate_name][] = $value;
       }
       $this->assign("types",$types);
       $this->assign("plan_types",$plan_types);
	}
	public function pageEntry($inPath){
	    /* 
	     * 获取用户id和用户名的对应数组 
	     */
	    $user_thrift = new thrift_aduser_main;
	    $users = $user_thrift->getAdUsersByCid(-1,-1);//获取所有用户
	    $id2name = array();//提取用户信息，格式为id->name
	    foreach ($users as $u){
	        if(!isset($id2name[$u->uid])){
	            $id2name[$u->uid] = $u->user_name;
	        }
	    }
	    $this->assign("id2name",$id2name);
	    /* 
	     * 获取媒体信息 
	     */
	    $media_thrift = new thrift_admedia_main;
		$r= $media_thrift->getAllMedia();//所有媒体详细信息
		
        $web_types = array("website"=>"网站","app"=>"APP","adx"=>"ADX","inside"=>"内部","others"=>"其他");//媒体类型
        $m_status = array("0"=>"关闭","1"=>"开启");//媒体状态
        // 分页处理
        //过滤数据
        foreach ($r as $key => $v) {
            if (isset($_GET['media_name']) && strlen($_GET['media_name']) > 0 && stripos(trim($v->media_name), trim($_GET['media_name'])) === false) {
                unset($r[$key]);
            }
            if (isset($_GET['type']) && strlen($_GET['type']) > 0 && ($v->media_type!=$_GET['type'])) {
                unset($r[$key]);
            }
        }
        $total = count($r);
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
        $r = array_slice($r, $start, $pageSize);
        $totalPage = ceil($total / $pageSize);
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        $this->assign("medias",$r);//所有媒体详细信息
        $this->assign("web_types",$web_types);//媒体类型
        $this->assign("m_status",$m_status);//媒体状态
		
		return $this->render("v2/meiti/index.html");
	}
	public function pageAdd($inPath){
		$media_id=0;
		if(!empty($inPath[3])){//获取媒体信息
			$media_id = $inPath[3];
			$media_thrift = new thrift_admedia_main;
			$media = $media_thrift->getMediaById($media_id);
			if(empty($media->media_name) || $media->creator_id != user_api::id()){
				die("参数错误");
			}
		}
		$fields = array("id","media_name","identification","media_type","career_type","reference_addr","media_status","comment","media_account","public_key","private_key","contact_name","contact_mobile","contact_email","contact_address","contact_zipcode","contact_website","contact_comment","available_uid");
		$user_model = new model_userInfo();
		$all_users = $user_model->getData(array("account_status"=>1),0,-1);
		if(!empty($_POST['media_name']) && !empty($_POST['media_type']) && !empty($_POST['career_type'])){//名称，标识，行业类型是必须的
			if(!empty($media)){//修改
				foreach($media as $k=>$v){
				    if(in_array($k, $fields) && isset($_POST[$k])){
					       $media->$k=$_POST[$k];
				    }
				}
				$now = time();
				$media->alter_time = $now;
				$result = $media_thrift->updateMedia($media_id,$media);
				if($result >= 0){
					$this->assign("result","修改成功");
				}else{
					$this->assign("result","修改失败");
				}
			}else{//新增
			    $media_thrift = new thrift_admedia_main;
			    $media_new = new Media();
				foreach($_POST as $k=>$v){
				    if(in_array($k, $fields)){
				        $media_new->$k=$_POST[$k];
				    }
				}
				$now = time();
				$media_new->creator_id = user_api::id();
				$media_new->alter_time = $media_new->create_time= $now;
				$media_id = $media_thrift->addMedia($media_new);
				if($media_id > 0 ){
					$this->assign("result","新增成功");
					$media = $media_thrift->getMediaById($media_id);
				}else{
					$this->assign("result","新增失败");
				}
			}
		}
		$this->assign("media_id",$media_id);
		$this->assign("media",$media);
		$this->assign("all_users",$all_users);
		return $this->render("v2/meiti/mt_new.html");
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

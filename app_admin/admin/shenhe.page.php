<?php
class admin_shenhe extends STpl{
	public function __construct($inPath){
	    if(!user_api::auth("shenhe")){
	        $this->success("没有审核权限",'/user',3);
	        exit();
	    }
	}
	
	//生成消息文本
	private function generateMsgText($operate_num, $object_list) {
		if ($operate_num < 100)
			return;
		$subject = '广告审核结果';
		$num = count($object_list);
		$body = '有 '.$num.' 个';
		
		//十位数，原先的状态
		$code = substr($operate_num, 1, 1);
		if ( $code == '1') {
			$body .= '等待审核的';
		} else if ($code == '2') {
			$body .= '原先已审核通过的';
		} else if ($code == '3') {
			$body .= '原先已被拒绝的';
		}

		//百位数，操作对象的类型
		$code = substr($operate_num, 0, 1);
		if ( $code == '1') {
			$body .= '计划,';
		} else if ($code == '2') {
			$body .= '素材,';
		}

		//个位数，被操作之后的状态
		$code = substr($operate_num, 2, 1);
		if ( $code == '1') {
			$body .= '已经被置为等待审核的状态。';
		} else if ($code == '2') {
			$body .= '已经被置为审核通过。';
		} else if ($code == '3') {
			$body .= '已经被拒绝。';
		}

		$body .=  '被审核的内容如下：';
		foreach ($object_list as $obj) {
			$body .= $obj. ' ';
		}
		$msgText = array();
		$msgText['subject'] = $subject;
		$msgText['body'] = $body;
		return $msgText;
	}

	//发送email
	private function sendEmail($uid, $subject, $body) {
		//读取adp数据库用户表，获取email
		$adpDB = new SDb();
        $adpDB->useConfig("adp");
        $table = array('adp_user_info');
        $condition = array("uid"=>$uid);
        $userInfo = $adpDB->selectOne($table,$condition, $item='email');
		$emailAddr =  $userInfo['email'];
		//没有email address则退出
		if(!isset($emailAddr)) return;

        $html = "<html>" .
				"<head>" .
					"<meta https-equiv='Content-Type' content='text/html; charset=utf-8'>".
					"<title>{$subject}</title>".
				"</head>".
				"<body>".
					"<p>你好，你{$body}</p>".
					"<p>".
					"百川通联(北京)网络技术有限公司<br>".
					//"网址：www.bcdata.cn<br>". //有网址容易被当作垃圾邮箱
					"地址：武汉洪山区关山大道111号时代广场A座1510<br>".
					"邮编 :430074<br>".
					"Tel：13669011118<br>". 
					"</p>".
				"</body>".
				"</html>";
        $mail = new mail_main();
        $mail->Subject = $subject;
        $mail->MsgHTML($html);
        $mail->AddAddress($emailAddr);

        if(!$mail->Send()) {
        	return $mail->ErrorInfo;
		} else {
			return true;
		}
	}

	function pagePlanSet($inPath){

		if(isset($_GET['currentStatus']) && $_GET['currentStatus'] >0){
			$currentStatus = $_GET['currentStatus'];
		}
		if(empty($_REQUEST['type']) && empty($_REQUEST['data_list'])){
			return false;
		}
		$type = $_REQUEST['type'];
		if($type!=1 && $type !=2 && $type!=3){
			return false;
		}
		//初始化审核日志
		$log = new admin_logapi;
		//初始化系统消息类
		$message = new message_api; 
		//初始化 adplan
		$x = new thrift_adplan_main;
		$operator = user_api::name();
		$operate_uid = user_api::id();

		if($currentStatus ==1 && $type ==2){  //由待审核转为通过
			$operate_num = 112;
		}elseif($currentStatus ==1 && $type ==3){ //由待审核转为未通过
			$operate_num = 113;
		}elseif($currentStatus ==2 && $type ==3){
			$operate_num = 123;  //由已通过状态转为未通过
		}elseif($currentStatus ==3 && $type ==2){
			$operate_num = 132;  //由未通过状态转为已通过
		}else{
			$operate_num = 100;
		}
		//批量处理
		 foreach($_REQUEST['data_list'] as $uid => $plan_list){
			foreach($plan_list as $pid) {
			    $plan = $x->getAdPlanByPid($pid);
			   /* $plan->priority = $_POST['priority'];
			    $UpPlan = $x->updateAdPlan($plan);
			    if(!$UpPlan){
			        exit("更新广告优先级失败");
			    }*/
				//不显示已删除的，即status=4的
				$groupsTemp = ad_api::listGroupsReport($plan->plan_id);
				$groups = array();
					foreach ($groupsTemp as $groupTemp){
						if($groupTemp->enabled != 4 || user_api::auth("admin")){
							$groups[] = $groupTemp;
						}
					}

				$flag = 0;
				foreach($groups as $group){  //$plan->ctime =$plan->mtime 是为了控制修改广告计划或者广告组后再次审核通过时不重复扣款
					if($plan->ctime==$plan->mtime && $group->ctime==$group->mtime){
						$flag = 1;
					}
					if($type ==2 && $flag ==1){  //$type为2表示审核通过 $flag为1表示第一次提交后审核
						if($plan->contract_type == 2){ //合约制广告计划
							if($plan->billing_type ==2){ //cpm方式
								$plan_amount = $plan->total_cpm;
							}else{    //cpt方式
								$plan_amount = $plan->total_cpt;
							}
							$update = array();
							$unitModel = new model_contractUnit();
							$unit = $unitModel->getData(array("unit_id"=>$plan->unit_id),0,-1);
							$update['access_budget'] = $unit[0]['access_budget']-$plan_amount; //预扣除
							$update['used_buy_amount'] = $unit[0]['used_buy_amount']+$plan_amount;
							$unitModel->updateData($update,array("unit_id"=>$plan->unit_id));

						}else{ //竞价制广告计划
							$plan_budget = $plan->total_cpm*$plan->setting_price;  //预算总量乘以单价
							$contractModel = new model_contractInfo();
							$contractInfo= $contractModel->getData(array("contract_id"=>$plan->contract_id),0,-1);
							$update_bid = array();
							$update_bid['access_budget'] = $contractInfo[0]['access_budget']-$plan_budget;
							$update_bid['used_budget'] = $contractInfo[0]['used_budget']+$plan_budget;
							$contractModel->updateData($update_bid,array("contract_id"=>$plan->contract_id));
						}
					}

				}

				$r = $x->updateVerifiedStatus($pid,$type,$operator); //修改状态
//				$contractInfoModel = new model_contractInfo();
//				$contractUnitModel = new model_contractUnit();
//				if($plan->total_cpm=="-1"){
//				    $sqlUnit = "update adp_contract_unit  set  access_buy_amount= access_buy_amount -$plan->total_cpt where unit_id=$plan->unit_id";
//				    $usedMoney = ($plan->setting_price) *($plan->total_cpm);
//				    $sqlContract = "Update adp_contract_info  set used_budget =used_budget+$usedMoney  ,access_budget=access_budget-$usedMoney";
//				} else {
//				    $usedMoney = ($plan->setting_price) *($plan->total_cpt);
//				    $sqlContract = "Update adp_contract_info  set used_budget =used_budget+$usedMoney  ,access_budget=access_budget-$usedMoney";
//				    $sqlUnit = "update adp_contract_unit  set  access_buy_amount= access_buy_amount -$plan->total_cpm where unit_id=$plan->unit_id";
//				}
//				$re1 = $contractUnitModel->query($sqlUnit);
//				$re1 = $contractInfoModel->query($sqlContract);
			}
			 $msgText = $this->generateMsgText($operate_num, $plan_list); //生成文本信息

			$log->addLog($operate_uid, $uid, $operate_num, $plan_list, $msgText['body']);//日志生成
			 if($operate_uid != $uid) {
				$this->sendEmail($uid, $msgText['subject'], $msgText['body']); //发邮件
				$message->sendMsg($operate_uid, $uid, $msgText['subject'], $msgText['body']);//发送系统消息
			}
		}
		return true;
	}

	/**
	 * 设置广告计划的优先级
	 * @param unknown $inPath
	 * @return boolean
	 */
	function pageprioritySet($inPath){
	    if(empty($_REQUEST['data_list'])){
	        return false;
	    }
	    $releaseType = array();
	    $releaseType[101] = array(
	        "name"          =>  "内部支撑",
	        "priority"      =>  "1",
	    );
	    $releaseType[10] = array(
	        "name"          =>  "品牌类",
	        "priority"      =>  "2",
	    );
	    $releaseType[20] = array(
	        "name"          =>  "普通类",
	        "priority"      =>  "3",
	    );
	    $releaseType[30] = array(
	        "name"          =>  "财经类",
	        "priority"      =>  "3",
	    );
	    $releaseType[40] = array(
	        "name"          =>  "游戏类",
	        "priority"      =>  "3",
	    );
	    $releaseType[100] = array(
	        "name"          =>  "最低",
	        "priority"      =>  "5",
	    );
	    foreach($_REQUEST['data_list'] as $uid => $plan_list){
	        foreach($plan_list as $pid) {
	            $x = new thrift_adplan_main;
	            $plan = $x->getAdPlanByPid($pid);
	            $plan->release_type = $_POST['priority'];
	            if(isset($releaseType[$plan->release_type])){
	                $plan->priority = $releaseType[$plan->release_type]['priority'];
	            }else{
	                $plan->priority = 3;
	            }
	            foreach ($plan as $k=>$v){
	                if(!isset($v)){
	                    $plan->$k = '';
	                }
	            }
	             //var_dump($plan);
	           // exit;
	            $UpPlan = $x->updateAdPlan($plan);
	            if($UpPlan!=0){
	            exit("更新广告优先级失败");
	            }
	        }
	    }
	    return true;
	}
	/**
	 * 设置广告计划的点击率
	 * @param unknown $inPath
	 * @return boolean
	 */
	function pageclickrateSet($inPath){
	    if(empty($_REQUEST['data_list'])){
	        return false;
	    }
	     ($_POST['clickrate']);
	    foreach($_REQUEST['data_list'] as $uid => $plan_list){
	        foreach($plan_list as $pid) {
	            $x = new thrift_adplan_main;
	            $plan = $x->getAdPlanByPid($pid);
	            $plan->ctr_click_rate = $_POST['clickrate'];
	            $plan->total_cpc =  ($plan->total_cpm)*($plan->ctr_click_rate)*10;
	            foreach ($plan as $k=>$v){
	                if(!isset($v)){
	                    $plan->$k = '';
	                }
	            }
	            //var_dump($plan);
	            // exit;
	            $UpPlan = $x->updateAdPlan($plan);
	            if($UpPlan!=0){
	                exit("更新点击率失败");
	            }
	        }
	    }
	    return true;
	}

	function pagePlan($inPath){
		if(empty($_REQUEST['type'])){
			$type=1;
		}else{
			$type=$_REQUEST['type'];
		}
		$page = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
		$pageSize = !empty($_REQUEST['ps'])?$_REQUEST['ps']:100;
//		$x = new thrift_adplan_main;
//		$plans = $x->getGroupByStatus(array(),$type,$pageSize,$page);

		$adplans = new model_planInfo();
		$condition = array();
		//verified_or_not 为1 待审，2 通过，3 未通过
		$condition['verified_or_not'] = $type;
		$like = array();
		if (!empty($_GET['plan_name'])) {
			$plan_name = $_GET['plan_name'];
			$like['plan_name'] = "%".trim($_GET['plan_name'])."%";
		}
			$users_uid = array();
		if (!empty($_GET['ad_user_name'])) {
//			$like['ad_user_name'] = "%".trim($_GET['ad_user_name'])."%";
			$ad_user_name = $_GET['ad_user_name'];
			$user_model = new model_userInfo();
			$condition = array();
			$users = $user_model->getData($condition,0,-1);
			foreach ($users as $key => $user) {
				if (strlen($_GET['ad_user_name']) > 0 && stripos($user['user_name'], $_GET['ad_user_name']) === false) {
					unset($users[$key]);
				}
			}
			foreach($users as $_user){
					array_push($users_uid,$_user['uid']);
				}
		}
		$plan_list = $adplans->getDataLike($condition,$like,0,-1,"plan_id","desc");
		foreach($plan_list as $_plan){
			if(!empty($users_uid)){
				if(($_plan['enable'] !=4) && in_array($_plan['uid'],$users_uid)){
					$plans[] = $_plan;
				}
			}else{
				if(($_plan['enable'] !=4)){
					$plans[] = $_plan;
				}
			}
		}
		$plan_list = $plans;

		// 分页操作
		$total = count($plan_list);
		if ($_GET['pageNum']) {
			$pageNum = $_GET['pageNum'];
		} else {
			$pageNum = 1;
		}
		$pageSize = 15;
		if ($pageNum * $pageSize - 1 <= $total) {
			$start = ($pageNum - 1) * $pageSize;
			$end = $pageNum * $pageSize - 1;
		} else {
			$start = ($pageNum - 1) * $pageSize;
			$end = $total - 1;
		}
		$plan_list = array_slice($plan_list, $start, $pageSize);
		$plan_list = json_encode($plan_list);
		$plan_list = json_decode($plan_list);
		$adSopnsorArray = array();
		$adSopnsorList = array();
		foreach($plan_list as $plan){
			if (!isset($adSopnsorArray[$plan->bind_id])) {
				$adSopnsorList[$plan->bind_id] = user_api::getUserByID($plan->bind_id);
				$adSopnsorArray[$plan->bind_id] = $adSopnsorList[$plan->bind_id]->user_name;
			}
		}

		$totalPage = ceil($total / $pageSize);
		$this->assign("totalPage", $totalPage);
		$this->assign("pageNum", $pageNum);
		$pager = pager_api::page(pager_api::toData($plan_list),"?pageNum=%p&type=$type");
		$this->assign("pager",$pager);
		$this->assign('total', $total);

//		$pager = pager_api::page(pager_api::toData($plans),"?page=%p&type=$type");
//		$this->assign("pager",$pager);
		$this->assign("ad_user_name",$ad_user_name);
		$this->assign("plan_name",$plan_name);
		$this->assign("plans",$plan_list);
		$this->assign("nav","plan");
		$this->assign("nav_sub",$type);
		$this->assign("adSopnsorArray",$adSopnsorArray);
		$this->assign("adSopnsorList",$adSopnsorList);
		$this->assign("currentUserName",user_api::name());
		$this->assign("currentStatus",$type);
		return $this->render("admin/shenhe_dsh_plan.html");
	}
	
	function pageStuffSet($inPath){
		if(isset($_GET['currentStatus']) && $_GET['currentStatus'] >0){
			$currentStatus = $_GET['currentStatus'];
		}
		if(empty($_REQUEST['type']) && empty($_REQUEST['data_list'])){
			return false;
		}
		$type = $_REQUEST['type'];
		if($type!=1 && $type !=2 && $type!=3){
			return false;
		}
		
		$operator = user_api::name();
		//初始化审核日志
		$log = new admin_logapi;
		//初始化系统消息类
		$message = new message_api; 
		//初始化 adplan
		$x = new thrift_stuffinfo_main;

		$operate_uid = user_api::id();
//		if ($type == 2) {
//			$operate_num = 212; //操作代码，表示 2：素材 由1：等待审核 转为 2：审核通过
//		} else {
//			$operate_num = 213;	//操作代码，表示 2：素材 由1：等待审核 转为 2：审核被拒绝
//		}

		if($currentStatus ==1 && $type ==2){  //由待审核转为通过
			$operate_num = 212;
		}elseif($currentStatus ==1 && $type ==3){ //由待审核转为未通过
			$operate_num = 213;
		}elseif($currentStatus ==2 && $type ==3){
			$operate_num = 223;  //由已通过状态转为未通过
		}elseif($currentStatus ==3 && $type ==2){
			$operate_num = 232;  //由未通过状态转为已通过
		}else{
			$operate_num = 200;
		}

		//批量处理
		foreach($_REQUEST['data_list'] as $uid => $stuff_list){
			foreach($stuff_list as $sid) {
				$r = $x->updateVerifiedStatus($sid,$type,$operator); //修改状态	
			}
			$msgText = $this->generateMsgText($operate_num, $stuff_list); //生成文本信息
			$log->addLog($operate_uid, $uid, $operate_num, $stuff_list, $msgText['body']);//日志生成
			if($operate_uid != $uid) {
				$this->sendEmail($uid, $msgText['subject'], $msgText['body']); //发邮件
				$message->sendMsg($operate_uid, $uid, $msgText['subject'], $msgText['body']);//发送系统消息
			}
		}
		return true;
	}
	
    function pageStuff($inPath){
		$a=new thrift_adinfo_main;
		if(empty($_REQUEST['type'])){
			$type=1;
		}else{
			$type=$_REQUEST['type'];
		}
		$page = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
		$pageSize = !empty($_REQUEST['ps'])?$_REQUEST['ps']:100;
		
		
		$x = new thrift_stuffinfo_main;
		if (user_api::auth("shenhe")) {
			$stuffs = $x->getStuffByStatus(array(),$type,$pageSize,$page);
			$stuffs = $stuffs->data;
		}else{
			$planArray = ad_api::listPlans($type,user_api::id());
			$groupArray = array();
			foreach ($planArray as $plan){
				$groupArray = array_merge($groupArray, ad_api::listGroups($plan->plan_id,$type));
			}
			$groupIdArray = array();
			foreach ($groupArray as $group){
				$groupIdArray[] = $group->group_id;
			}
			$stuffs = $x->getStuffByStatus($groupIdArray,$type,$pageSize,$page);
			$stuffs = $stuffs->data;
			/*
			$plans = ad_api::listPlans($type,user_api::id());
			$adArray = array();
			$groupIdArray = array();
			foreach ($plans as $plan){
				$groupList = ad_api::listGroups($plan->plan_id);
				foreach($groupList as $group){
					$groupIdArray[] = $group->group_id;
					$adArray = array_merge($adArray,ad_api::listads($group->group_id));
				}
			}
			$stuffs = array();
			foreach($adArray as $ad){
				$stuffs = $x->getStuffsByAdid($ad->adid);
				//$stuffs = array_merge($stuffs, $x->getStuffsByAdid($ad->adid));
			}
			*/
		}
		
		foreach($stuffs as $stuff){
			if (!isset($adSopnsorArray[$stuff->uid])) {
				$adSopnsorArray[$stuff->uid] = user_api::getUserByID($stuff->uid)->user_name;
			}
			$stuff->userName = $adSopnsorArray[$stuff->uid];
			$ad = $a->getAdInfoById($stuff->adid);
			$stuff->adName = $ad->adname;
		}
		$typeList = array(1=>'图片',2=>'Flash',3=>'文字');
		$pager = pager_api::page(pager_api::toData($stuffs),"?page=%p&type=$type");
		$this->assign("pager",$pager);
		$this->assign("stuffs",$stuffs);
		$this->assign("nav","stuff");
		$this->assign("typeList",$typeList);
		$this->assign("nav_sub",$type);
		$this->assign("currentUserName",user_api::name());
		$this->assign("currentStatus",$type);
		$this->assign("adSopnsorArray",$adSopnsorArray);
		return $this->render("admin/shenhe_dsh.html");
	}

	/**
	 * @param $inPath
	 * @description 广告计划审核查看详情
	 */
    public	function pageDetail($inPath){
		$plan_id = $_GET['plan_id'];
		$plan_type = $_GET['type'];
		if(isset($plan_id) && $plan_id >0){
			$plan = new thrift_adplan_main;
			$planInfo = $plan->getAdPlanByPid($plan_id);
			if(empty($plan_type)){
				$type=1;
			}else{
				$type=$plan_type;
			}

			$a = new thrift_adplan_main;
			$types_tmp=$a->getAllAdPlanTypes();
			foreach($types_tmp as $_t){
				if($_t->type_id == $planInfo->type_id){
					$planInfo->type_name = $_t->type_name;
					$planInfo->cate_name = $_t->cate_name;
				}
			}

			$user = user_api::getUserById($planInfo->bind_id);
			$this->assign("aduser",$user);
			$this->assign("currentStatus",$type);
			$this->assign("plan",$planInfo);
		}

		return $this->render("admin/shenhe_dsh_plan_detail.html");
	}

	/**
	 * @param $inPath
	 * @description 广告素材审核查看详情
	 */
	public function pageStuffDetail($inPath){
		$stuff_id = $_GET['stuff_id'];
		$stuff_type = $_GET['type'];
		if(isset($stuff_id) && $stuff_id >0){
			$plan = new thrift_adplan_main;
			$group = new thrift_adgroup_main;
			$stuff =new thrift_adinfo_main;
			$b=new thrift_stuffinfo_main;

			$stuffInfo = $stuff->getAdInfoById($stuff_id);
			$planInfo = $plan->getAdPlanByPid($stuffInfo->plan_id);
			$groupInfo = $group->findAdGroupById($stuffInfo->group_id);
			$user = user_api::getUserById($stuffInfo->uid);
			$stuffInfo->plan_name = $planInfo->plan_name;
			$stuffInfo->group_name = $groupInfo->name;
			$stuffInfo->user_name = $user->user_name;
			$stuffType = $b->getStuffsByAdid($stuff_id);

			if($stuffType[0]->type ==1){
				$stuffInfo->type = "图片";
			}elseif($stuffType[0]->type ==2){
				$stuffInfo->type = "Flash";
			}else{
				$stuffInfo->type = "文字";
			}

			if(empty($stuff_type)){
				$type=1;
			}else{
				$type=$stuff_type;
			}

			$this->assign("currentStatus",$type);
			$this->assign("stuff",$stuffInfo);
		}

		return $this->render("admin/shenhe_dsh_stuff_detail.html");
	}

	/***
	 * 获取灵集广告审核结果
	 */
	public function pageAdxStuff($inPath){
		if(empty($_REQUEST['type'])){
			$type=1;
		}else{
			$type=$_REQUEST['type'];
		}
		$page = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
		$pageSize = !empty($_REQUEST['ps'])?$_REQUEST['ps']:100;
//		$x = new thrift_adplan_main;
//		$plans = $x->getGroupByStatus(array(),$type,$pageSize,$page);

		$x = new thrift_stuffinfo_main;
		if (user_api::auth("shenhe")) {
			$stuffs = $x->getStuffByStatus(array(),$type,$pageSize,$page);
			$stuffs = $stuffs->data;
		}else{
			$planArray = ad_api::listPlans($type,user_api::id());
			$groupArray = array();
			foreach ($planArray as $plan){
				$groupArray = array_merge($groupArray, ad_api::listGroups($plan->plan_id,$type));
			}
			$groupIdArray = array();
			foreach ($groupArray as $group){
				$groupIdArray[] = $group->group_id;
			}
			$stuffs = $x->getStuffByStatus($groupIdArray,$type,$pageSize,$page);
			$stuffs = $stuffs->data;
		}

		$adid = [];
		foreach($stuffs as $stuff){
			if($stuff->ad_stuff_platform ==1){
				$adid[] = (string)$stuff->adid;
			}
		}
		$adx_stu = array();
		$adx_stuff = array();
		if(!empty($adid)){
			$res = json_decode($this->getStuffStatus($adid)); //获取灵集素材审核结果
			$item = $res->message;
			if($item->total >0){
				$records = $item->records;
				foreach($records as $record){
					foreach($stuffs as $val){
						if($val->ad_stuff_platform ==1 && $val->adid == intval($record->creativeId)){
							$val->result = $record->result;
							$val->reason = $record->reason;
							$adx_stu[] = $val;
						}
					}
				}
			}
		}

		if($_REQUEST['status'] ==1){
			$status = "通过";
		}
		if($_REQUEST['status'] ==2){
			$status = "待审核";
		}
		if($_REQUEST['status'] ==3){
			$status = "不通过";
		}
		if(!empty($_REQUEST['status']) && strlen(trim($_REQUEST['stuff_name'])) ==0){
			foreach($adx_stu as $adx){
				if($adx->result == $status){
					$adx_stuff[] = $adx;
				}
			}
		}elseif(empty($_REQUEST['status']) && strlen(trim($_REQUEST['stuff_name'])) >0){
			foreach($adx_stu as $adx){
				if(strpos($adx->name,trim($_REQUEST['stuff_name'])) !== false){
					$adx_stuff[] = $adx;
				}
			}
		}elseif(!empty($_REQUEST['status']) && strlen(trim($_REQUEST['stuff_name'])) >0){
			foreach($adx_stu as $adx){
				if(strpos($adx->name,trim($_REQUEST['stuff_name'])) !== false && $adx->result == $status){
					$adx_stuff[] = $adx;
				}
			}
		}else{
			$adx_stuff = $adx_stu;
		}
//		var_dump($adx_stuff);

		// 分页操作
		$total = count($adx_stuff);
		if ($_GET['pageNum']) {
			$pageNum = $_GET['pageNum'];
		} else {
			$pageNum = 1;
		}
		$pageSize = 15;
		if ($pageNum * $pageSize - 1 <= $total) {
			$start = ($pageNum - 1) * $pageSize;
			$end = $pageNum * $pageSize - 1;
		} else {
			$start = ($pageNum - 1) * $pageSize;
			$end = $total - 1;
		}
		$adx_stuff = array_slice($adx_stuff, $start, $pageSize);
		$adx_stuff = json_encode($adx_stuff);
		$adx_stuff = json_decode($adx_stuff);
		$nav = "lj_stuff";
		$totalPage = ceil($total / $pageSize);
		$this->assign("totalPage", $totalPage);
		$this->assign("pageNum", $pageNum);
		$pager = pager_api::page(pager_api::toData($adx_stuff),"?pageNum=%p&type=$type");
		$this->assign("pager",$pager);
		$this->assign('total', $total);
		$this->assign("adx_stuff",$adx_stuff);
		$this->assign("nav",$nav);
		$this->assign("status",$_REQUEST['status']);
		$this->assign("nav_sub",$type);
		$this->assign("currentUserName",user_api::name());
		$this->assign("currentStatus",$type);
		return $this->render("admin/shenhe_lj_stuff.html");
	}

	/***
	 * @param $parameter
	 * @param int $timeout
	 * @param array $aHeader
	 * @return mixed|string
	 * 通过接口获取灵集素材审核结果
	 */
	private function getStuffStatus($parameter,$timeout = 40,$aHeader=array()){
		$curl_post = SConfig::getConfigArray(ROOT_CONFIG."/config.php","curl_post");
		$post_url = $curl_post['post_url']."/status";  //上传物料
		$adx_data = array();
		$adx_data['dspid'] = $curl_post['dspid'];
		$adx_data['token'] = $curl_post['token'];
		$adx_data['creativeIds'] = $parameter;
		$data_json = json_encode($adx_data,JSON_UNESCAPED_SLASHES);
//		var_dump($data_json);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch,CURLOPT_URL,$post_url);
		if( count($aHeader) >= 1 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8','Content-Length:'.strlen($data_json)));
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data_json);
		$result = curl_exec($ch);
		if($result){
			return $result;
		}else{
			return curl_error($ch);
		}
		curl_close($ch);
	}



}

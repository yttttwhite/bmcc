<?php
class ad_plan extends STpl{
    public $planInfoModel,$userInfoModel;
    public function __construct($inPath){
        $this->userInfoModel = new model_userInfo();
        if(!user_api::auth("ad")){
//	        $this->success("没有权限",'/user',3);
//	        exit();
            header("Location: /baichuan_advertisement_manage/dc.main.ad?nav=3&menu_left=1");
	    }
	    if(user_api::auth("adReadonly")){
	        $readonly = " disabled='disabled'  readonly='readonly' ";
	        $this->assign("readonly",$readonly);
	    }else{
	        $readonly = "";
	        $this->assign("readonly",$readonly);
	    }
	    
        $uid = user_api::id();
        $this->assign("uid",$uid);
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'version');
        $this->assign("config",$config);
    }
    public function pageEntry($inPath){
        $api = new ad_api;
        $info = user_api::info();
        $role_id = $info->role_id;
        if(!empty($_REQUEST['start'])){
            $start=date("Y-m-d",strtotime($_REQUEST['start']));
        }else{
            $start=date("Y-m-d",mktime(0,0,0,date('m'),1,date('Y')));//time()-30*24*3600);
        }
        if(!empty($_REQUEST['end'])){
            $end=date("Y-m-d",strtotime($_REQUEST['end']));
        }else{
            $end=date("Y-m-d",time());
        }
        
        $status=1;
        if(user_api::auth("admin")){
            $statusArray = array(0,1,2,3,4,5,6,7);
        }else{
            $statusArray = array(0,1,2,3,5,6,7);
        }
        
        if(isset($_REQUEST['status']) && in_array($_REQUEST['status'],$statusArray) ){
            $status=$_REQUEST['status'];
        }

        $userId = user_api::id();
        if(isset($_REQUEST['uid']) && user_api::auth('admin')){
            $userId = $_REQUEST['uid'];
        }

        $plans = array();
        $condition = array();
//        if($role_id == 1000 || $role_id==10000){//运营商，展示所有的广告计划
//            $userId = -1;
//        }
        if($role_id ==13){
            $userId = user_api::id();
        }else{
            $userId =-1;  //查询所有用户的广告计划信息
        }
//        $plansTemp = $api->listPlansBindReport($start,$end,$status,$userId);
        $allPlans = $api->listPlansBindReport($start,$end,$status,$userId);
        $userModel = new  model_userInfo();
        if($role_id ==12){  //客户经理
            $condition['role_id'] = 13;
            $condition['creator_id'] = $info->uid;
            $users = $userModel->getData($condition);
            $uids_list = array_column($users,"uid");
        }elseif($role_id ==18){ //子运营商
            $condition['creator_id'] = $info->uid;
            $condition['role_id'] = 12;
            $managerUsers = $userModel->getData($condition,0,-1);
            $manager_uids = array_column($managerUsers,"uid");
            $item = array();
            if(count($manager_uids) > 1){
                $uids_string = implode(",",$manager_uids);
                $item = " AND creator_id IN ($uids_string) AND role_id =13";
            }else{
                $item['role_id'] =13;
                $item['creator_id'] =$manager_uids[0];
            }
            $adUsers = $userModel->getData($item,0,-1);
            $uids_list = array_column($adUsers,"uid");
        }elseif($role_id == 1000 || $role_id==10000){
            $users = $userModel->getData($condition);
            $uids_list = array_column($users,"uid");
        }elseif($role_id ==13){
            $condition['uid'] = $info->uid;
            $condition['role_id'] = 13;
            $users = $userModel->getData($condition);
            $uids_list = array_column($users,"uid");
        }
        foreach($allPlans as $_plan){
            if(in_array($_plan->bind_id,$uids_list)){
                $plansTemp[] = $_plan;
            }
        }
       if($status == 0){
            foreach ($plansTemp as $planTemp){
                if($planTemp->enable != 4){
                    $plans[] = $planTemp;
                }
            }
        }else{
            $plans = $plansTemp;
        }
        
        if(isset($_GET['start'])){
            $startTime = date("Ymd",strtotime($_GET['start']));
        }else{
            $startTime = 0;
        }
        if(isset($_GET['end'])){
            $endTime = date("Ymd",strtotime($_GET['end']));
        }else{
            $endTime = 99991231;
        }
        
        foreach ($plans as $index => $plan){
            $planStartTime = date("Ymd",strtotime($plan->start_date));
            $planEndTime = date("Ymd",strtotime($plan->end_date));
            if($planEndTime < 20000101){
                if( $endTime < $planStartTime ){
                    unset($plans[$index]);
                }
            }else{
                if( ($endTime < $planStartTime) || ($startTime > $planEndTime) ){
                    unset($plans[$index]);
                }
            }
        }
          //查询创建者名称
        $user_model = new model_userInfo($table);
        $users = $user_model->getData();
        foreach ($plans  as $k1=>$v1){
            foreach ($users as $k2=>$v2){
                if($v1->uid ==$v2['uid']){
                     $plans[$k1]->creator_name = $v2['user_name'];
                }
                if($v1->bind_id ==$v2['uid']){
                    $plans[$k1]->user_name = $v2['user_name'];
                }
            }
        }
        $sort_desc = array_multisort($newArr,SORT_DESC,$plans); //对获取到的广告计划根据开始时间进行降序排序
        $pageNum = isset($_REQUEST['pageNum'])&&(int)$_REQUEST['pageNum']>0 ? (int)$_REQUEST['pageNum']:1;
        $pageSel = isset($_REQUEST['pageSel'])&&(int)$_REQUEST['pageSel']>0 ? (int)$_REQUEST['pageSel']:20;
        $maxPage=ceil(sizeof($plans)/$pageSel);
        $plans = array_slice($plans,($pageNum-1)*$pageSel,$pageSel);
        $this->assign("maxPage",$maxPage);
        $this->assign("pageSel",$pageSel);
        $this->assign("pageNum",$pageNum);
        $this->assign("currentUserName",user_api::name());
        $this->assign("plans2",$plans);
        $this->assign("start",$start);
        $this->assign("status",$status);
        $this->assign("end",$end);
        $this->assign("userId",$userId);
        $this->assign("role_id",$role_id);
        $this->assign("id",$_GET['uid']);
        /*
        foreach($plans as $plan){
            //$b = $a->GroupReportByPlanId($plan->plan_id,"20130801","20130901",array("22060000"));
            //print_R($b);
        }
        */
        return $this->render("v2/ad/adPlan.html");
    }
    public function pageAdd($inPath){
       /*
        require __DIR__ .'../../../tools/SensitiveWordFilter.php';
        $filter = new SensitiveWordFilter(__DIR__ . '../../../tools/dict.txt');
        $word = $_POST;
        if(!empty($_POST)){
            $word = $_POST;
            foreach ($word as $value) {
                $re = $filter->filter(trim($value), 0);
                if($re == false){
                    $this->success("您输入的有敏感词请检查后，再创建", "/ad.plan") ;
                    exit;
                }
               
            }
        
        }*/
        $releaseType = array();
        $releaseType[101] = array(
            "name"          =>  "内部支撑",
            "priority"      =>  "1",
        );
        $releaseType[10] = array(
            "name"          =>  "最高",
            "priority"      =>  "2",
        );
        $releaseType[20] = array(
            "name"          =>  "高",
            "priority"      =>  "3",
        );
        $releaseType[30] = array(
            "name"          =>  "中",
            "priority"      =>  "3",
        );
        $releaseType[40] = array(
            "name"          =>  "低",
            "priority"      =>  "3",
        );
        $releaseType[100] = array(
            "name"          =>  "最低",
            "priority"      =>  "5",
        );

        /**
         * 获取子运营商用户
         */
        $userId = user_api::id();//获取当前用户id
        $user = user_api::info();//获取当前用户信息；
        $roleId = $user->role_id;//当前用户角色id 10000：系统管理员，1000：运营商 18：子运营商，12：客户经理，13：广告主
        if($roleId == "1000"){//运营商，展示所有的广告计划
            $userId = 1;
        }
        if($roleId == "10000" || $roleId == "1000" ){
            $userRoleId = 18;//子运营商roleId
        }
        if($roleId == "18"){
            $userRoleId = 12;
        }
        if($roleId == "12" || $roleId == "13"){
            $userRoleId = 13;
        }
        $operateRole = $roleId;
        $carriersUser = $this->userInfoModel->getSubCarriers($userId,$userRoleId,$operateRole);
        $tags = $this->getTag();
        $mediaModel = new model_rmcbjMedia();
        $media_all = $mediaModel->getData();
        $media_list = array();
        foreach($media_all as $media){
            if(strlen($media['available_uid']) >0){
                $available_uid_array = explode(",",$media['available_uid']);
                if(!in_array($userId,$available_uid_array)){
                    unset($media);
                }
            }
            $media_list[] = $media;
        }
        $ms = array_filter($media_list);

        $position_thrift = new thrift_admedia_main;
        $arr_object = $position_thrift->getAllPo();
        $positions = array();
        foreach($arr_object as $pos){
            if($pos->plan_id == 0){
                $positions[] = $pos;
            }
        }

        $channels = $position_thrift->getAllChannel();
        /**添加合同列表**/
        $contractModel = new model_contractInfo();
        $contractInfo = $contractModel->getData(array(),0,-1);
        //广告来源
//        $this->assign("sourceInfo",$source);
        //合同列表
        $this->assign("contractInfo",$contractInfo);
        $this->assign("ms", $ms);
        $this->assign("positions",$positions);
        $this->assign("channels", $channels);
        $this->assign('tags', $tags);
        $this->assign('carriersUser',$carriersUser);
        $this->assign('roleId',$roleId);
        $this->assign('releaseType',$releaseType);
        
        $condi=array();
        //$r= media_db::listWebSite($condi,$page);
        //$ms = media_db::listMedia($condi,$page);
        
        $this->planInfoModel = new model_planInfo();
        
        $a = new thrift_adplan_main;
        if(!empty($_POST)){//添加数据开始
            //更改合同单价表，添加广告计划id
            $unitModel = new model_contractUnit();
            $contractModel = new model_contractInfo();
            $data=array();
            if($_POST['contract_type'] >0){
                $data['contract_type'] = $_POST['contract_type'];
            }
            //获取广告位置id判断
            if($_POST['addToSelf']=='on'){
               // if($_POST['bind_id']==user_api::id()){
                    $data['bind_id']= user_api::id();
               // } else{
                    //$data['bind_id']= $_POST['bind_id'];
               // }
                 
            } else {
                 $data['bind_id'] =$_POST['bind_id'];  //绑定广告主id
                 if($roleId == 13){
                     $data['bind_id'] = $userId;
                 }
               }

            if($_POST['billing_type'] == 2){ //CPM计费方式
                $data['billing_type'] =2;
                $data['total_cpm'] =$_POST['total_cpm'];   //计划预算量
                $data['budget'] =$_POST['budget'];  // 每日预算量
                $data['ctr_click_rate'] =$_POST['ctr_click_rate'];  //保底点击率
                $data['total_cpc'] = $_POST['total_cpc']; //保底点击量  CPC
                if(isset($_POST['contract_type']) && $_POST['contract_type'] ==1){ //竞价合同
                    $data['contract_id'] = $_POST['contract_id']; //保存合同id
                }else{
                    $data['unit_id'] = $_POST['price_id'];
                }
            }
            if($_POST['billing_type'] == 4){ // CPT计费方式
                $data['billing_type'] =4;
                $data['total_cpt'] =$_POST['total_cpt'];   //计划预算量 天数
                $data['budget'] =0;  // 每日预算量，0表示不做控制，默认值
                $data['unit_id'] =$_POST['price_id'];  // 对应单价unit_id
            }
            //$data['channel_id'] = $_POST['channel_id']; 频道id
            //$data['ad_pos_id'] = $_POST['ad_pos_id']; //广告位置id
            //广告位位置标签
            $data['tag_identification'] = $_POST['tag_identifications'];
            $data['setting_price'] = $_POST['setting_price'];
//            $data['platform'] = $_POST['platform'];
            $data['platform'] = $_POST['source_id2'];
            $data['ad_pos_id'] = $_POST['ad_pos_id'];
            $dateFlag = true;
            if(!empty($inPath[3])){
                $b=$a->getAdPlanByPid($inPath[3]);
                $adPlanUid = $b->bind_id;
//                if($b->bind_id!=user_api::id() && !user_api::auth('admin')){
//                    die("NOT ALLOWED!");
//                }
                if($b->start_date == strtotime($_POST['start_date'])){
                    $dateFlag = false;
                }
            }else{
                $b=new AdPlan;
            }
            foreach($b as $k=>$v){
                if(isset($_POST[$k])){
                    if($_POST['addToSelf']=='on'){
                        if($k=="bind_id"){
                            $b->$k= $b->$k;
                        }else{
                            $b->$k=$_POST[$k];
                        }
                    } else{
                        $b->$k=$_POST[$k];
                    }
                   
                }
            }
             $userInfo = user_api::info();
            if($userInfo->role_id==13){
                $b->bind_id =$userInfo->uid; 
            }
            if($b->platform == 1){
                $b->billing_type = 2;//TA隐藏结算类型选项，默认CPM
            }
            if(isset($_POST['frequency_control'])&&($_POST['frequency_control']>=0)){
                if(isset($_POST['control_method'])&&($_POST['control_method']==1)){
                    $b->time_interval=$_POST['time_interval_day'];
                    $b->day_num=1;
                    $b->show_num=$_POST['show_num_day'];
                }else if(isset($_POST['control_method'])&&($_POST['control_method']==2)){
                    $b->time_interval=$_POST['time_interval_week']*3600;
                    $b->day_num=7;
                    $b->show_num=$_POST['show_num_week'];
                }else if(isset($_POST['control_method'])&&($_POST['control_method']==3)){
                    $b->time_interval=$_POST['time_interval_month']*86400;
                    $b->day_num=30;
                    $b->show_num=$_POST['show_num_month'];
                }
            }else{
                $b->time_interval=$_POST['time_interval_day'];
                $b->day_num=1;
                $b->show_num=$_POST['show_num_day'];
            }
            if(isset($releaseType[$b->release_type])){
                $b->priority = $releaseType[$b->release_type]['priority'];
            }else{
                $b->priority = 3;
            }
           // if( isset($_POST['budget_total']) &&  $_POST['budget_total']>0 ){
                if( isset($_POST['total_cpm']) || isset($_POST['total_cpt'])){
                if($b->billing_type == 2){
                    $b->total_cpm = $_POST['total_cpm'];
                    $b->total_cpc = $_POST['total_cpc'];
                    $b->total_cpt = 0;
                    if(isset($_POST['contract_type']) && $_POST['contract_type'] ==1){ //竞价合同
                        $b->contract_id = $_POST['contract_id']; //保存合同id
                    }else{
                        $b->unit_id = $_POST['price_id'];
                    }
                }else{  //cpt计费方式时存对应的unit_id
                    $b->total_cpt = $_POST['total_cpt'];
                    $b->total_cpm = 0;
                    $b->total_cpc = 0;
                    $b->unit_id = $_POST['price_id'];
                }
            }else{
                $b->total_cpm = 0;
                $b->total_cpc = 0;
                $b->total_cpt = 0;
            }
            
        	if (isset($adPlanUid)) {
				$b->uid = $adPlanUid;
			}else{
				$b->uid = user_api::id();
			}
			$b->verified_or_not = 1;
            if(strtotime($b->start_date)){
                $b->start_date=strtotime($_REQUEST['start_date']);
            }else{
                $b->start_date=0;
            }
            $time = time();
            $current_day_time = $time - ($time % 86400) -(8 * 3600);
            if($dateFlag===true && strtotime($_REQUEST['start_date']) < $current_day_time){
                $error['date'] = "选择开始时间不能早于今天";
            } 

            if(strtotime($b->end_date)){
                $b->end_date=strtotime($_REQUEST['end_date']);
            }else{
                $b->end_date=0;
            }
            if($b->start_date>0 && $b->end_date>0 && $b->end_date<$b->start_date){
                $error['date']="结束时间不能小于开始时间";
            }
            if(empty($_REQUEST['plan_name'])){
                $error['plan_name']="计划名不能为空";
            }
            $operator = user_api::name();

            if(!empty($_REQUEST['tag_identifications'])){
                $b->tag_identification = $_REQUEST['tag_identifications']; //广告位分类
            }
            if(isset($_REQUEST['position_type']) && $_REQUEST['position_type'] ==2){  //广告类型为广告位
                unset($b->tag_identification);
            }

            if(empty($error)){
                if(!empty($b->plan_id)){
                    $plan_id = $b->plan_id;
                    $b->mtime=time();
                    $a->updateAdPlan($b);
                    $data['bind_id'] = $b->bind_id;
                    $this->planInfoModel->updateData($data, array("plan_id"=>$plan_id));
                    //修改时更新广告位关联的广告计划id
                    if($_POST['billing_type'] ==4){ //cpt计费方式时广告位独占
                        if($_POST['position_type'] ==1){
                            $tagModel = new model_poTag();
                            $item = array();
//                            $item['tag_ident'] = $_POST['tag_identification'];
                            $item['tag_ident'] = $_POST['tag_identifications'];
                            $tagModel->updateData(array("plan_id"=>$plan_id),$item);
                        }else{
                            $posit_thrift = new thrift_admedia_main;
                            $p = $posit_thrift->getPoById($data['ad_pos_id']);
                            $p->plan_id = $plan_id;
                            $posit_thrift->updatePosition($data['ad_pos_id'],$p);
                        }
                    }

                    if(!user_api::auth("admin")){
                        if(isset($_POST['submit_or_not']) && $_POST['submit_or_not'] == 1){
                            $a->updateVerifiedStatus($b->plan_id, 1, $operator);
                        }else{
                            $a->updateVerifiedStatus($b->plan_id, 0, $operator);
                        }
                    }else{
                        $a->updateVerifiedStatus($b->plan_id, 2, $operator);
                    }
                     header("location:/baichuan_advertisement_manage/ad.plan.list.$plan_id");
                }else{
                    $b->ctime=$b->mtime=time();
                    //新增采用默认值
                    $b->ctr_click_rate = 0;
                    $b->total_cpc = 0;
                    $plan_id = $a->addAdPlan($b);
                    $data['ctr_click_rate'] = 0;
                    $data['total_cpc'] = 0;
                    $this->planInfoModel->updateData($data, array("plan_id"=>$plan_id));
                    //添加时更新广告位关联的广告计划id
                    if($_POST['billing_type'] ==4){ //cpt计费方式时广告位独占
                        if($_POST['position_type'] ==1){
                            $tagModel = new model_poTag();
                            $item = array();
                            $item['tag_ident'] = $_POST['tag_identifications'];
                            $tagModel->updateData(array("plan_id"=>$plan_id),$item);
                        }else{
                            $posit_thrift = new thrift_admedia_main;
                            $p = $posit_thrift->getPoById($data['ad_pos_id']);
                            $p->plan_id = $plan_id;
                            $posit_thrift->updatePosition($data['ad_pos_id'],$p);
                        }
                    }

                    if(empty($plan_id)){
                        $error['msg']="建立失败";
                    }else{
                        $data =  array();
                       // $data['plan_id'] = $plan_id;
                        //$condition['unit_id'] = $_POST['unit_id'];
                       // $re = $contractModel->updateData($data,$condition);
                        if(!user_api::auth("admin")){
                            if(isset($_POST['submit_or_not']) && $_POST['submit_or_not'] == 1){
                                $a->updateVerifiedStatus($plan_id, 1, $operator);
                            }else{
                                $a->updateVerifiedStatus($b->plan_id, 0, $operator);
                            }
                        }else{
                            $a->updateVerifiedStatus($plan_id, 2, $operator);
                        } 
                      header("location:/baichuan_advertisement_manage/ad.group.add.$plan_id");
                    }
                }
            }else{
                $this->assign("error",$error);
            }
            if (! empty($b->start_date)) {
                $b->start_date = date("Y-m-d", $b->start_date);
            }
            if (! empty($b->end_date)) {
                $b->end_date = date("Y-m-d", $b->end_date);
            }
            
            $this->assign("plan",$b);
            $this->assign("plan_id",$plan_id);
            $status = $b->verified_or_not;
        }elseif(!empty($inPath[3])){//编辑开始
            $plan_id=$inPath[3];
            $plan=$a->getAdPlanByPid($plan_id);
//            if($plan->bind_id!=user_api::id() && !user_api::auth("admin") && !user_api::auth("adReadonly")){
//                die("NOT ALLOWED!");
//            }
            
            if(isset($plan->billing_type) && $plan->billing_type == 1){
                $plan->budget_total = $plan->total_cpc;
            }else{
                $plan->budget_total = $plan->total_cpm;
            }
            if(!empty($plan->start_date)) $plan->start_date=date("Y-m-d",$plan->start_date);
            if(!empty($plan->end_date))$plan->end_date=date("Y-m-d",$plan->end_date);
            $plan->intervals = trim($plan->intervals,";");
            $this->assign("plan_id",$plan_id);
            $checkUser = $this->getSelectUser($plan->bind_id,$plan->uid);
            $plan->is_own = $checkUser['is_own'];
            $plan->lowoperate = $checkUser['lowoperate'];
            $plan->manager = $checkUser['manager'];
            $plan->advertise = $checkUser['advertise'];
            $userModel = new model_userInfo();
            $condition['uid']= $plan->bind_id;
            /********获取广告位类型或者广告位，频道和媒体*****/
            $position_thrift = new thrift_admedia_main;
            $medias = $position_thrift->getAllMedia();
            $positions= $position_thrift->getAllPo();
            $channels = $position_thrift->getAllChannel();
            $positionId = $plan->ad_pos_id;
            foreach($positions  as $k1=>$v1){
                if($v1->id==$positionId){
                    $position = $v1;
                }
            }
            $channelId = $position->channel_id;
            foreach ($channels as $k2 =>$v2){
                if($v2->channel_id==$channelId ){
                    $channel = $v2;
                }
            }
            $mediaId = $channel->media_id;
            $plan->media_id = $mediaId;
            $plan->channel_id = $channelId;
            $plan->position_id = $positionId;
            /****************end****************/
            $userInfo = $userModel->getData($condition);
            $userInfo = $userInfo[0];
            $this->assign("userinfo",$userInfo);
//            $plan->contract_id =105;
//            $plan->unit_id = 4;
//            $plan->contract_type=2;
            $this->assign("plan",$plan);
            $status = $plan->verified_or_not;
        }elseif(!empty($_GET['loaded_id'])){
            $plan=$a->getAdPlanByPid($_GET['loaded_id']);
            if($plan->bind_id!=user_api::id()){
                die("NOT ALLOWED!");
            }
            
            if(isset($plan->billing_type) && $plan->billing_type == 1){
                $plan->budget_total = $plan->total_cpc;
            }else{
                $plan->budget_total = $plan->total_cpm;
            }
            
            if(!empty($plan->start_date)) $plan->start_date=date("Y-m-d",$plan->start_date);;
            if(!empty($plan->end_date))$plan->end_date=date("Y-m-d",$plan->end_date);;
            unset($plan->plan_id);
            $this->assign("loaded_id",$_GET['loaded_id']);
            $this->assign("plan",$plan);
           
            $status = $plan->verified_or_not;
        }
        //获取广告计划类型
        if(empty($status)){
            $status = 1;
        }
        $types_tmp=$a->getAllAdPlanTypes();
        $types=array();
        foreach($types_tmp as $_t){
            $_n = $_t->cate_name;
            if(!isset($types[$_n])){
                $types[$_n]=array();
            }
            $types[$_n][]=$_t;
        }
        $this->assign("plan_types",$types);


        /**
          * 获取广告计划
         */

        $api = new ad_api;
        $plans = $api->listPlans();
        if(empty($_POST['platform'])){
            $this->assign("default_platform",true);
        }else{
            $this->assign("default_platform",false);
        }
        $condition = array();
        $condition['plan_id'] = $inPath[3];
        $media_extra = $this->planInfoModel->getData($condition);
        $postionId = $media_extra[0]['ad_pos_id']; //广告位id
        $m = new thrift_admedia_main;
        $adpostion = $m->getPoById($postionId);
        $this->assign("adpostion",$adpostion);
        $this->assign("media_extra",$media_extra[0]);
        $this->assign("current_user", user_api::info());
        $this->assign("plans", $plans);
        $this->assign("status",$status);
        $this->assign("backgroup",$_GET['back']);
        $this->assign("backstaff",$_GET['backstaff']);
        $this->assign("ms",$ms);
        $this->assign("webs",$r);
        return $this->render("v2/ad/step_1.html");
    }
    public function pageStatus($inPath){
        if(!empty($_POST['plan_ids']) || !empty($_GET['plan_id'])){
            $p = new thrift_adplan_main;
            $a = new thrift_status_main;
            if($inPath[3]=="start"){
                foreach($_POST['plan_ids'] as $plan_id){
                    $plan = $p->getAdPlanByPid($plan_id);
                    if($plan->uid==user_api::id() ||  user_api::auth("admin")){
                        $result = $a->updateAdPlanStatus($plan_id,PlanStatus::RUNNING);
                        //echo $plan_id.":".$result."#";
                    }
                }
                return true;
            }elseif($inPath[3]=="stop"){
                if(count($_POST['plan_ids'])>0){
                    foreach($_POST['plan_ids'] as $plan_id){
                        $plan = $p->getAdPlanByPid($plan_id);
                        if($plan->uid==user_api::id() ||  user_api::auth("admin")){
                            $result = $a->updateAdPlanStatus($plan_id,PlanStatus::STOPPED);
                            //echo $plan_id.":".$result."#";
                        }
                    }
                    return true;
                }
            }elseif($inPath[3]=="del"){
                if($config['delete']==1 && !user_api::auth('admin')){
                    return false;
                }elseif($plan->uid == user_api::id() ||  user_api::auth("admin")){
                    foreach($_POST['plan_ids'] as $plan_id){
                        $plan = $p->getAdPlanByPid($plan_id);
                        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'config');
                        $a->updateAdPlanStatus($plan_id,PlanStatus::DELETED);
                    }
                    return true;
                }else{
                    return false;
                }
            }elseif($inPath[3]=="terminated"){ //停止 TERMINATED
                if(count($_POST['plan_ids'])>0){
                    foreach($_POST['plan_ids'] as $plan_id){
                        $plan = $p->getAdPlanByPid($plan_id);
                        if($plan->uid==user_api::id() ||  user_api::auth("admin")){
                            $result = $a->updateAdPlanStatus($plan_id,PlanStatus::TERMINATED);
                            //echo $plan_id.":".$result."#";
                        }
                    }
                    return true;
                }
            }


        }else{
            return false;
        }
    }
    public function pageSet($inPath){
        return $this->render("v2/ad/adPlan_set.html");
    }
    /**显示广告组**/
    public function pageList($inPath){
        if(!empty($inPath[3])){
            $plan_id = $inPath[3];
            $p = new thrift_adplan_main;
            $plan = $p->getAdPlanByPid($plan_id);
            $this->assign("user_id",$plan->uid);
            /*if($plan->uid!=user_api::id() && !user_api::auth("admin") && !user_api::auth("adReadonly")){
                die("NO PLAN");
            }*/
            /*if($plan->bind_id!=user_api::id()&& !user_api::auth("adReadonly")){
                die("NO PLAN");
            }*/
            if(!empty($_REQUEST['start'])){
                $start=date("Y-m-d",strtotime($_REQUEST['start']));
            }else{
                $start=date("Y-m-d",mktime(0,0,0,date('m'),1,date('Y')));//time()-30*24*3600);
            }
            if(!empty($_REQUEST['end'])){
                $end=date("Y-m-d",strtotime($_REQUEST['end']));
            }else{
                $end=date("Y-m-d",time());
            }
            $status=1;
            
            if(!user_api::auth("admin")){
                $statusArray = array(0,1,2,3,4,5,6);
            }else{
                $statusArray = array(0,1,2,3,5,6);
            }
            
            if(isset($_REQUEST['status']) && in_array($_REQUEST['status'],$statusArray) ){
                $status=$_REQUEST['status'];
            }
            $this->assign("start",$start);
            $this->assign("end",$end);
            $groupsTemp = ad_api::listGroupsReport($plan_id,$start,$end,$status);
            //不显示已删除的，即status=4的
            $groups = array();
            if($status == 0){
                foreach ($groupsTemp as $groupTemp){
                    if($groupTemp->enabled != 4 || user_api::auth("admin")){
                        $groups[] = $groupTemp;
                    }
                }
            }else{
                $groups = $groupsTemp;
            }

            //{{{
            //上面的接口没有返回全部的数据，比如bid_price
            //$b = new thrift_adgroup_main;
            //foreach($groups as $k=>&$group){
            //    $group=$b->findAdGroupById($group->group_id);
            //}
            //}}}
            $a = new thrift_adplan_main;
            $plan = $a->getAdPlanByPid($plan_id);
            //出价展示
            foreach ($groups as $k=>$v){
                $groups[$k]->setting_price = $plan->setting_price;
            }
            $this->assign("groups_2",$groups);
            $this->assign("plan",$plan);
            $this->assign("status",$status);
            $this->assign("plan_id",$plan_id);
            $this->assign("currentUserName",user_api::name());
            return $this->render("v2/ad/adGroup.html");
        }
    }
    public function pageListPart($inPath){
        $planThrift = new thrift_adplan_main;
        $userThrift = new thrift_aduser_main;
        $my = user_api::info();
		if(!empty($inPath[3])){
			$plan_id = $inPath[3];
			$this->assign("plan_id",$plan_id);
			
			$groups = ad_api::listGroups($plan_id,$status=1);
			$this->assign("groups",$groups);
		}
		 if(!empty($inPath[4])){
			$group_id= $inPath[4];
			$this->assign("group_id",$group_id);
		}
		if(isset($_GET['uid'])){
			$user_id = $_GET['uid'];
			$this->assign("user_id",$user_id);
		}
		
		$info = user_api::info();
		//筛选子运营商的管辖的用户
		if($info->role_id==18){
		    $conditionTemp = array();
		    // 1.先查询所属客户经理账号
		    $conditionTemp['role_id'] = 12;
		    $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为子运营账户的uid
		    $marketkey = array();
		    $user_model = new model_userInfo();
		    $marketUser = $user_model->getData($conditionTemp, 0, - 1);
		    if ($marketUser) {
		        foreach ($marketUser as $key => $v) {
		            array_push($marketkey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
		        }
		    }
		    foreach ($marketkey as $k => $uid) {
		        // 2.查询所属广告主的账号
		        $conditionTemp = array();
		        $conditionTemp['role_id'] = 13;
		        $conditionTemp['creator_id'] = $uid;
		        $advertiseKey = array();
		        $advertiseUser = $user_model->getData($conditionTemp, 0, - 1);
		        if ($advertiseUser) {
		            foreach ($advertiseUser as $key => $v) {
		                array_push($advertiseKey, $v['uid']);
		            }
		        }
		    }
		    $selectedKey = array_unique(array_merge($marketkey, $advertiseKey));
		}
		if($info->role_id==12){
		    $conditionTemp = array();
		    // 1.先查询所属客户经理账号
		    $user_model = new model_userInfo();
		    $conditionTemp['role_id'] = 13;
		    $conditionTemp['creator_id'] = $info->uid; // 当前登录用户为客户经理账户
		    $advertiseKey = array();
		    $advertiseUser = $user_model->getData($conditionTemp, 0, - 1);
		     if ($advertiseUser) {
		        foreach ($advertiseUser as $key => $v) {
		            array_push($advertiseKey, $v['uid']); // 所属客户经理的用户uid，查看所有广告主
                }
		    }
		    $selectedKey = $advertiseKey;
		}
//		if (user_api::auth("admin") || user_api::auth("adReadonly") || $info->role_id == 1000) {
		if (user_api::auth("admin") || in_array($info->role_id,array("18","12","1000"))) {
		    if(isset($_GET['status']) && $_GET['status']==="all"){
		        $status = AccountStatus::ALL;
		    }else{
		        $status = AccountStatus::NORMAL;
		    }
		     $users = $userThrift->getAdUsersByCid(-1,$status);
		    if($info->role_id==18 || $info->role_id==12){
		        //根据账户的归属关系筛选用户
		        foreach($users  as $k =>$v){
		            if(!in_array($v->uid,$selectedKey)){
		                unset($users[$k]);
		            }
		        }
		    }
		    $plans = $planThrift->getAdPlanByUserid(-1,1,-1,0);
		    //筛选相关用户的广告计划
		     $userPlans = array();
		    if(is_array($plans->data) && count($plans->data)>0){
		        foreach ($plans->data as $plan){
		             if(isset($plan->bind_id) && $plan->uid >0){
		                $userPlans[$plan->bind_id][] = $plan;
		            }
		        }
		    }
		    $this->assign('my',$my);
		    $this->assign('users',$users);
		    $this->assign('userPlans',$userPlans);
		    return $this->render("v2/ad/adPlanListPart.tpl");
		}else{
		    if(isset($_GET['status']) && $_GET['status']==="all"){
		        $status = AccountStatus::ALL;
		    }else{
		        $status = AccountStatus::NORMAL;
		    }
		    $user = $userThrift->getAdUserById($my->uid);
            $users[] = $user;
            $userPlans = array();
            $plans = ad_api::listPlans(0,$my->uid);
            if(is_array($plans) && count($plans)>0){
                foreach ($plans as $plan){
                    if(isset($plan->bind_id) && $plan->bind_id >0){
                        $userPlans[$plan->bind_id][] = $plan;
                    }
				}            
			}
		    $this->assign('my',$my);
		    $this->assign('users',$users);
		    $this->assign('userPlans',$userPlans);
		    return $this->render("v2/ad/adPlanListPart.tpl");
		}
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
	    $unit = $_POST['unit'];
	    $price = $_POST['price'];
	    $plan_id = $inPath[7];
	    $position_thrift = new thrift_admedia_main;
	    $positions= $position_thrift->getAllPo();
	    foreach ($positions as $k => $item){
            if($item->plan_id ==0 || $item->plan_id ==$plan_id) {
                $web2position[$item->channel_id][] = $item;
            }

	    }
	    if(isset($web2position[$inPath[3]])){
	        $result = $web2position[$inPath[3]];
	    }else{
	        $result = array();
	    }
	    return  SJson::encode($result);
	}
	
	/**
	 * 获取所有标签用于页面渲染
	 */
	public function getTag()
	{
	    $tagModel = new model_poTag();
	    $data = $tagModel->getData();
	    $tags = array();
	    if ($data) {
	        $tags = $data;
	    }
	
	    return $tags;
	}
	

	/**
	 * 广告主归属设置，编辑用
	 */
	
	public function  getSelectUser($bind_id,$uid){
	    $return =array(
	        'is_own'=>0,
	        'lowoperate'=>0,
	        'manager'=>0,
	        'advertise'=>0
	    );
	    if($bind_id == $uid && $bind_id == user_api::id()){
	        $is_own = 1;
	    }else{
	        $is_own = 0;
	    }
	   $user_model = new  model_userInfo();
	   $userCreates = $user_model->getData(array('uid'=>$uid));
	   $userOwns =  $user_model->getData(array('uid'=>$bind_id));
       $userCreate =  $userCreates[0];
	   $userOwn = $userOwns[0];

        if($userCreate['role_id'] == 13){ //创建者是广告主
            $lowoperate = 0;
            $manager = $userOwn['creator_id'];
            $advertise = $bind_id;
        }

        if($userCreate['role_id'] == 18){//创建者是子运营商
	       $lowoperate = 0;
	       $manager = $userOwn['creator_id'];
	       $advertise = $bind_id;
	   }

	   if($userCreate['role_id'] == 12){//创建者是客户经理
	       $lowoperate = 0;
	       $manager = 0;
	       $advertise = $bind_id;
	   }
	   if($userCreate['role_id'] ==1000||$userCreate['role_id']==10000){//创建者是管理员
	       $manager = $userOwn['creator_id'];
	       $advertise = $bind_id;
	       //查询子运营商的账户,
	       $userManaTemp_ = $user_model->getData(array('uid'=>$userOwn['creator_id']));
	       $user_ = $userManaTemp_[0];
	       $lowoperate = $user_ ['creator_id'];
	   }
	    $return =array(
	       'is_own'=>$is_own,
	       'lowoperate'=>$lowoperate,
	       'manager'=>$manager,
	       'advertise'=>$advertise
	   );
	   return  $return;
	}
	
	/**
	 * 选定合同类型之后，查询合同信息。
	 * @param unknown $inPath
	 * @return string
	 */
	public function pageGetContract($inPath){
	    $userInfo = user_api::info();
	    $contract_type = $_POST['contract_type'];
	    $condition = array();
	    $condition['contract_type'] = (int)$contract_type;
	    $condition['is_delete'] = 1;  //未删除的
	    $condition['verify_status'] = 2;  //审核通过的
        if(isset($_POST['uid']) && $_POST['uid']>0){
            $uid =  $_POST['uid'];
            $condition['create_uid'] = $uid;
            $contractModel = new model_contractInfo();
            $contractInfo = $contractModel->getData($condition ,0,-1);
        }else{
            $contractInfo = array(array());
        }
        $contract_bid = array();
        foreach($contractInfo as $contract){
//            if($contract['contract_type'] ==1 && $contract['access_budget']>0){ //竞价制
            if($contract['contract_type'] ==1){ //竞价制
                $contract_bid[]=$contract;
            }else{ //合约制
                $contract_data[]=$contract;
            }
        }
            $contract_list = array();
        if($contract_type ==1){ //竞价制
            unset($contract_data);
            $contract_list = $contract_bid;
        }elseif($contract_type ==2){ //合约制
            $unitModel = new model_contractUnit();
            $unit_list = $unitModel->getData(array("uid"=>$uid));
//            foreach($unit_list as $unit){
//                if($unit['access_budget'] >0){  //php加access_budget大于0的时候，若广告计划对应的量消耗完，编辑时会影响广告位单价显示
//                    $contract_list[] = $unit;
//                }
//            }
              //合约制广告按广告位单价为维度值
            $contract_list = $unit_list;
        }
//        var_dump(SJson::encode($contract_list));
//        die(qwerss);
	    echo  SJson::encode($contract_list);
	}
	/**
	 * 绑定合同之后修改合同信息，添加已经完成的投放计划
	 */
	private  function  updateContract($contractId,$usedbudget){
	    //合同id
	    $condition['contract_id'] = $contractId;
	    $data['verfiy_status'] = $type;
	    $sql  = "update  adp_contract_info  set total_budget= total_budget-$usedbudget";
	    $re = $contractModel->query($sql);
	    return $re;
	}
	/**
	 * 选择合同的单价之后，筛选广告位类型
	 */
	public function PageGetPositionType(){
	    $price = $_POST['price'];
	    $unit = $_POST['unit'];
	    if($unit ==2){
	        $where = "cpm_price <=$price";
	    }
	    if($unit==4){
	        $where = "cpt_price <=$price";
	    }
	    $tagModel = new model_poTag();
	    $sql = "  SELECT  *  from  adp_po_tag   WHERE  $where";
	    $data = $tagModel->fetch_all($sql);
	    echo  SJson::encode($data);
	    
	}
	/**
	 * 获取合同内容
	 */
	public  function  pageGet(){
	    $contract_id = $_REQUEST['contract_id'];
	    $condition['contract_id'] = $contract_id;
	    //$condition['is_delete'] = 0;
	    $unitModel = new model_contractUnit();
	    $contractModel = new model_contractInfo();
	    $re = $contractModel->getData($condition,0,-1);
	    $unit = $unitModel->getData(array("contract_id"=>$contract_id),0,-1);
	    foreach($unit as $key=>$val){
	        if($val['unit']==2){
	            $unit[$key]['unit'] = "cpm";
	        } else{
	            $unit[$key]['unit'] = "cpt";
	        }
	
	    }
	    if($re){
	        $re[0]['unit'] = $unit;
	    }
	    echo  SJson::encode($re);
	}
	/**
	 * 获取单价信息
	 */
	public  function  pageGetUnit(){
	    $unit_id = $_POST['unit_id'];
	    $unitModel = new model_contractUnit();
	    $condition['unit_id'] = $unit_id;
	    $re = $unitModel->getData($condition,0,-1);
	    /*  foreach($re  as $k=>$v){
	     if($v['unit']==1){
	     $re[$k]['unit'] = "cpm";
	     }
	     if($v['unit']==2){
	     $re[$k]['unit'] = "cpt";
	     }
	    }*/
	
	    echo  SJson::encode($re);
	}

}


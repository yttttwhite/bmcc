<?php
class ad_plan extends STpl{
    public function __construct($inPath){
        if(!user_api::auth("ad")){
	        $this->success("没有权限",'/user',3);
	        exit();
	    }
        $uid = user_api::id();
        $this->assign("uid",$uid);
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'version');
        $this->assign("config",$config);
    }
    public function pageEntry($inPath){
        //默认本月
        $api = new ad_api;
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
            $statusArray = array(0,1,2,3,4,5,6);
        }else{
            $statusArray = array(0,1,2,3,5,6);
        }
        
        if(isset($_REQUEST['status']) && in_array($_REQUEST['status'],$statusArray) ){
            $status=$_REQUEST['status'];
        }
        
        
        $userId = user_api::id();
        if(isset($_REQUEST['uid']) && user_api::auth('admin')){
            $userId = $_REQUEST['uid'];
        }
        
        $plans = array();
        $plansTemp = $api->listPlansReport($start,$end,$status,$userId);
        if($status == 0){
            foreach ($plansTemp as $planTemp){
                if($planTemp->enable != 4 || user_api::auth("admin")){
                    $plans[] = $planTemp;
                }
            };
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
                if( $startTime<$planStartTime && $endTime<$planStartTime ){
                    unset($plans[$index]);
                }
            }else{
                if( ($startTime<$planStartTime && $endTime<$planStartTime) && ($startTime>$planEndTime && $endTime>$planEndTime) ){
                    unset($plans[$index]);
                }
            }
        }
        $this->assign("currentUserName",user_api::name());
        $this->assign("plans2",$plans);
        $this->assign("start",$start);
        $this->assign("status",$status);
        $this->assign("end",$end);
        $this->assign("uid",$userId);
        foreach($plans as $plan){
            //$b = $a->GroupReportByPlanId($plan->plan_id,"20130801","20130901",array("22060000"));
            //print_R($b);
        }
        return $this->render("v2/ad/adPlan.html");
    }
    public function pageAdd($inPath){
        $a = new thrift_adplan_main;
        if(!empty($_POST)){
            if(!empty($inPath[3])){
                $b=$a->getAdPlanByPid($inPath[3]);
                $adPlanUid = $b->uid;
                if($b->uid!=user_api::id() && !user_api::auth('admin')){
                    die("NOT ALLOWED!");
                }
            }else{
                $b=new AdPlan;
            }
            foreach($b as $k=>$v){
                if(isset($_POST[$k])){
                    $b->$k=$_POST[$k];
                }
            }
            if( isset($_POST['budget_total']) &&  $_POST['budget_total']>0 ){
                if(isset($_POST['billing_type']) && $_POST['billing_type'] == 1){
                    $b->total_cpc = $_POST['budget_total'];
                    $b->total_cpm = -1;
                }else{
                    $b->total_cpm = $_POST['budget_total'];
                    $b->total_cpc = -1;
                }
            }else{
                $b->total_cpm = -1;
                $b->total_cpc = -1;
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
            if(empty($error)){
                if(!empty($b->plan_id)){
                    $plan_id = $b->plan_id;
                    $b->mtime=time();
                    $a->updateAdPlan($b); 
                    if(!user_api::auth("admin")){
                        $a->updateVerifiedStatus($b->plan_id, 1);
                    }else{
                        $a->updateVerifiedStatus($b->plan_id, 2);
                    }
                    header("location:/baichuan_advertisement_manage/ad.plan.list.$plan_id");
                }else{
                    //增加
                    $b->ctime=$b->mtime=time();
                    $plan_id = $a->addAdPlan($b);    
                    if(empty($plan_id)){
                        $error['msg']="建立失败";
                    }else{
                        header("location:/baichuan_advertisement_manage/ad.group.add.$plan_id");
                    }
                }
                if($plan_id>=0){
                }else{
                }
            }
            if(!empty($b->start_date))     $b->start_date=date("Y-m-d",$b->start_date);;
            if(!empty($b->end_date))    $b->end_date=date("Y-m-d",$b->end_date);;
            $this->assign("plan",$b);
            $this->assign("plan_id",$plan_id);
            if(!empty($error)){
                $this->assign("error",$error);
            }
        }elseif(!empty($inPath[3])){
            $plan_id=$inPath[3];
            $plan=$a->getAdPlanByPid($plan_id);
            if($plan->uid!=user_api::id() && !user_api::auth("admin")){
                die("NOT ALLOWED!");
            }
            
            if(isset($plan->billing_type) && $plan->billing_type == 1){
                $plan->budget_total = $plan->total_cpc;
            }else{
                $plan->budget_total = $plan->total_cpm;
            }
            
            if(!empty($plan->start_date)) $plan->start_date=date("Y-m-d",$plan->start_date);;
            if(!empty($plan->end_date))$plan->end_date=date("Y-m-d",$plan->end_date);
            $plan->intervals = trim($plan->intervals,";");
            $this->assign("plan_id",$plan_id);
            $this->assign("plan",$plan);
        }elseif(!empty($_GET['loaded_id'])){
            $plan=$a->getAdPlanByPid($_GET['loaded_id']);
            if($plan->uid!=user_api::id()){
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
        }
        //获取广告计划类型
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
        $this->assign("plans", $plans);
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
                        echo $plan_id.":".$result."#";
                    }
                }
            }elseif($inPath[3]=="stop"){
                if(count($_POST['plan_ids'])>0){
                    foreach($_POST['plan_ids'] as $plan_id){
                        $plan = $p->getAdPlanByPid($plan_id);
                        if($plan->uid==user_api::id() ||  user_api::auth("admin")){
                            $result = $a->updateAdPlanStatus($plan_id,PlanStatus::STOPPED);
                            echo $plan_id.":".$result."#";
                        }
                    }
                }
            }elseif($inPath[3]=="del"){
                foreach($_POST['plan_ids'] as $plan_id){
                    $plan = $p->getAdPlanByPid($plan_id);
                    
                    $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'config');
                    if($config['delete']==1 && !user_api::auth('admin')){
                        die("0");
                    }
                    
                    if($plan->uid==user_api::id() ||  user_api::auth("admin")){
                        $a->updateAdPlanStatus($plan_id,PlanStatus::DELETED);
                    }
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
            if($plan->uid!=user_api::id() && !user_api::auth("admin")){
                die("NO PLAN");
            }
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
            $this->assign("groups_2",$groups);
            $this->assign("plan",$plan);
            $this->assign("status",$status);
            $this->assign("plan_id",$plan_id);
            $this->assign("currentUserName",user_api::name());
            return $this->render("v2/ad/adGroup.html");
        }
    }
    public function pageListPart($inPath){
		if(!empty($inPath[3])){
			$plan_id = $inPath[3];
			$group_id= $inPath[4];
			$this->assign("plan_id",$plan_id);
			$this->assign("group_id",$group_id);
		}
		$api = new ad_api;
		
		if (user_api::auth("admin")) {
			$a = new thrift_aduser_main;
			//$users = $a->getAdUsersByCid(0,AccountStatus::ALL);
			
			//改成所有用户接口
			if(isset($_GET['status']) && $_GET['status']==="all"){
			    $status = AccountStatus::ALL;
			}else{
			    $status = AccountStatus::NORMAL;
			}
			if(user_api::auth("admin")){
			    //$users = $a->getAdUsersByCid(user_api::id(),$status);
			    $users = $a->getAdUsersByCid(1,$status);
			    foreach ($users as $temp){
			        if($temp->role_id >= 1000){
			            $users = array_merge($users, $a->getAdUsersByCid($temp->uid,$status));
			        }
			    }
			    $users = array_merge($users, $a->getAdUsersByCid(0,$status));
			}else{
			    $users = $a->getAdUsersByCid(user_api::id(),$status);
			}
			
			$planArray = array();
			$totalCost = 0;
			foreach($users as $user){
				$planArray[$user->uid] = $api->listPlans($status=1,$user->uid);
				//$totalCost += report_api::getCostToday($user->uid);
			}
			$this->assign("planArray",$planArray);
			//$this->assign("totalCost",$totalCost);
			$this->assign("users",$users);
			
			$plans = $api->listPlans($status=1);
			$c = new thrift_adgroup_main;
			//$groups = $c->findAdGroupByInt(array("plan_id"=>$plan_id));
			$groups = ad_api::listGroups($plan_id,$status=1);
			$this->assign("plans",$plans);
			$this->assign("plan_id",$plan_id);
			$this->assign("groups",$groups);
			$this->assign("user_info",user_api::info());
			//获取今日花费
			$this->assign("user_cost",report_api::getCostToday(user_api::id()));
			return $this->render("v2/ad/adPlanListPartAdmin.tpl");
		}else{
			$plans = $api->listPlans($status=1);
			$c = new thrift_adgroup_main;
			//$groups = $c->findAdGroupByInt(array("plan_id"=>$plan_id));
			$groups = ad_api::listGroups($plan_id,$status=1);
			$this->assign("plans",$plans);
			$this->assign("plan_id",$plan_id);
			$this->assign("groups",$groups);
			$this->assign("user_info",user_api::info());
			//获取今日花费
			$this->assign("user_cost",report_api::getCostToday(user_api::id()));
			return $this->render("v2/ad/adPlanListPart.tpl");
		}
	}
}

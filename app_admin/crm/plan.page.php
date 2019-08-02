<?php
class crm_plan extends STpl{
    public $planModel, $groupModel, $adModel, $creativeModel;
    public $uid;
    public function __construct($inPath){
        user_api::getUserByName(user_api::name());
        if(user_api::id()==0){
            header("location:/baichuan_advertisement_manage/user");
        }else{
            $this->uid = user_api::id();
        }
        $this->init();
    }
    public function init(){
        $this->planModel = new model_CrmPlanInfo();
        $this->groupModel = new model_CrmGroupInfo();
        $this->adModel = new model_CrmAdInfo();
        $this->creativeModel = new model_CrmCreativeInfo();
    }
    public function pageEntry($inPath){
    }
    public function pageList($inPath){
        $condition = array();
        $condition['uid'] = $this->uid;
        $list = $this->planModel->getData($condition,0,20,'plan_id');
        
        $userInfo = array();
        foreach ($list as $key=>$temp){
            if(!isset($userInfo[$temp['uid']])){
                $userInfo[$temp['uid']] = user_api::getUserByID($temp['uid']);
                $temp['user_name'] = $userInfo[$temp['uid']]->user_name;
                $list[$key] = $temp;
            }else{
                $temp['user_name'] = $userInfo[$temp['uid']]->user_name;
                $list[$key] = $temp;
            }
        }
        $this->assign('list',$list);
        return $this->render("crm/plan_list_2.html");
    }
    public function pageAdd($inPath){
        if(isset($_GET['plan_id'])){
            $condition = array();
            $condition['plan_id'] = $_GET['plan_id'];
            $plan = $this->planModel->getData($condition);
            if(isset($plan[0]['uid']) && $plan[0]['uid'] == user_api::id()){
                $plan = $plan[0];
            }
        }else{
            $plan = array();
        }
        $this->assign("plan",$plan);
        return $this->render("crm/plan_add.html");
    }
    public function pageSave(){
        if(!isset($_POST['plan_name']) || strlen($_POST['plan_name'])<1){
            $this->success("广告名称不能为空","/baichuan_advertisement_manage/crm.plan.list",3);
            exit();
        }
        
        $adTypeCode = array('sms'=>'sms_budget','mms'=>'mms_budget','email'=>'email_budget','call'=>'cc_budget');
        $data = array();
        
        //处理发送时间、循环类型
        $time = $_POST['ad_date']." ".$_POST['ad_hour'].":".$_POST['ad_minute'].":00";
        $time = strtotime($time);
        if(isset($_POST['repeat_type'])){
            if($_POST['repeat_type'] == 1){
                $sendType = "1:;";
            }elseif($_POST['repeat_type'] == 2){
                $sendType = "2:".date("w",$time).";";
            }elseif($_POST['repeat_type'] == 3){
                $sendType = "3:".date("d",$time).";";
            }else{
                $sendType = "0:".date("Ymd",$time).";";
            }
        }else{
            $sendType = "0:".date("Ymd",$time).";";
        }
        
        $data['adtime'] = date("H:i",$time);
        $data['sms_send_type'] = $sendType;
        
        $data['uid'] = $this->uid;
        $data['plan_name'] = $_POST['plan_name'];
        if(is_array($_POST['adType'])){
            $adType = $_POST['adType'];
            foreach ($adType as $type){
                if(isset($_POST[$type.'Budget']) && isset($adTypeCode[$type])){
                    $data[$adTypeCode[$type]] = $_POST[$type.'Budget'];
                }
            }
        }
        $data['start_date'] = strtotime($_POST['start_date']);
        $data['end_date'] = strtotime($_POST['end_date']);
        //$data['adtime'] = $_POST['intervals'];
        $data['ctime'] = time();
        $data['mtime'] = time();
        
        if(isset($_POST['plan_id']) && strlen($_POST['plan_id'])>0){
            $condition = array();
            $condition['plan_id'] = $_POST['plan_id'];
            $condition['uid'] = user_api::id();
            $id = $this->planModel->updateData($data,$condition);
            
            $this->resetStatus($_POST['plan_id'], 1,"广告被修改");
        }else{
            $id = $this->planModel->addData($data);
            $this->resetStatus($id, 1,"新建广告");
        }
        if($id > 0){
            $this->success("操作成功","/baichuan_advertisement_manage/crm.plan.list");
        }else{
            $this->success("写入数据失败","/baichuan_advertisement_manage/crm.plan.list",3);
        }
    }
    
    public function pageDetail(){
        $this->assign('get',$_GET);
        if(isset($_GET['plan_id'])){
            $planId = $_GET['plan_id'];
            $condition = array();
            $condition['plan_id'] = $planId;
            
            $planList = $this->planModel->getData($condition);
            $groupList = $this->groupModel->getData($condition);
            //$adList = $this->adModel->getAdInfo($condition);
            
            $planInfo = $planList[0];
            
            /*
            $adtime = $planInfo['adtime'];
            $adtime = explode(';', $adtime);
            $adtimeArray = array();
            foreach ($adtime as $temp){
                $tempArray = explode(":", $temp);
                $dayAdTime['day'] = $tempArray[0];
                $dayAdTime['hour'] = $tempArray[1];
                $adtimeArray[] = $dayAdTime;
            }
            $planInfo['adtime'] = $adtimeArray;
            */
            
            $repeatInfo = explode(":", $planInfo['sms_send_type']);
            $planInfo['repeat_type'] = $repeatInfo[0];
            $planInfo['repeat_value'] = str_replace(";", "", $repeatInfo[1]);
            
            $planInfo['start_date'] = date("Y-m-d",$planInfo['start_date']);
            $planInfo['end_date'] = date("Y-m-d",$planInfo['end_date']);
            $planInfo['ctime'] = date("Y-m-d H:i:s",$planInfo['ctime']);
            $planInfo['mtime'] = date("Y-m-d H:i:s",$planInfo['mtime']);
            
            $week = array(
                1=>'星期一',
                2=>'星期二',
                3=>'星期三',
                4=>'星期四',
                5=>'星期五',
                6=>'星期六',
                7=>'星期日'
            );
            $this->assign('week',$week);
            $this->assign('planInfo',$planInfo);
            $this->assign('groupList',$groupList);
            return $this->render("crm/plan_detail.html");
            
        }
    }
    
    public function pageDelete(){
        if(isset($_GET['plan_id'])){
            $condition = array();
            $condition['plan_id'] = $_GET['plan_id'];
            $condition['uid'] = user_api::id();
            $this->planModel->deleteData($condition);
            $this->groupModel->deleteData($condition);
            $this->adModel->deleteData($condition);
        }
    }
    
    public function pageLeft(){
        if(!empty($inPath[3])){
            $plan_id = $inPath[3];
        }elseif(isset($_GET['plan_id'])){
            $plan_id = $_GET['plan_id'];
        }else{
            $plan_id = 0;
        }
        
        if(!empty($inPath[4])){
            $group_id = $inPath[4];
        }elseif(isset($_GET['group_id'])){
            $group_id = $_GET['group_id'];
        }else{
            $group_id = 0;
        }
        
        if($plan_id == 0 && $group_id!=0){
            $groupCondition = array();
            $groupCondition['group_id'] = $group_id;
            $groups = $this->groupModel->getData($groupCondition);
            
            if(isset($groups[0]['plan_id'])){
                $plan_id = $groups[0]['plan_id'];
            }
        }
        
        if($plan_id!=0){
            $groupCondition = array();
            $groupCondition['plan_id'] = $plan_id;
            $groups = $this->groupModel->getData($groupCondition);
        }else{
            $groups = array();
        }
        
        $condition = array();
        $condition['uid'] = user_api::id();
        $planList = $this->planModel->getData($condition);

        $this->assign("group_id",$group_id);
        $this->assign("plan_id",$plan_id);
        $this->assign('planList',$planList);
        $this->assign('groups',$groups);
        return $this->render("crm/plan_left.html");
    }
    
    private function resetStatus($plan_id,$newStatus,$resetRemark = ""){
        $staus = array(0=>"未审核",1=>"等待审核",2=>"审核通过",3=>"审核未通过");
        
        $condition = array();
        $condition['plan_id'] = $plan_id;
        
        $data = array();
        $data['status'] = $newStatus;
        
        if(strlen($resetRemark)>0){
            $planInfo = $this->planModel->getData($condition);
            if(isset($planInfo['0']['remark']) && strlen($planInfo['0']['remark'])>0){
                $remark = json_decode($planInfo['0']['remark'],true);
                if(!is_array($remark)){
                    $remark = array();
                }
            }
            $newRemark = array();
            $newRemark['time'] = time();
            $newRemark['status'] = $staus[$newStatus];
            $newRemark['uid'] = user_api::id();
            $newRemark['uname'] = user_api::name();
            $newRemark['text'] = $resetRemark;
            $remark[] = $newRemark;
        
            $data['remark'] = json_encode($remark);
        }
        
        $this->planModel->updateData($data,$condition);
        unset($data['remark']);
        $this->adModel->updateData($data,$condition);
    }
}

<?php
class crm_shenhe extends STpl{
    public $planModel, $groupModel, $adModel, $creativeModel, $receiverModel, $numberModel;
    public $sendType, $week;
    public function __construct($inPath){
        if(!user_api::auth("shenhe")){
            $this->success("没有权限",'/baichuan_advertisement_manage/user',3);
            exit();
        }
        $this->init();
    }
    public function init(){
        $this->planModel = new model_CrmPlanInfo();
        $this->groupModel = new model_CrmGroupInfo();
        $this->adModel = new model_CrmAdInfo();
        $this->creativeModel = new model_CrmCreativeInfo();
        
        $this->receiverModel = new model_CrmReceiver();
        $this->numberModel = new model_CrmNumber();
        
        $this->sendType = array(0=>"单次",1=>"每天",2=>"每周",3=>"每月");
        $this->week = array(0=>"日",1=>"一",2=>"二",3=>"三",4=>"四",5=>"五",6=>"六");
    }
    public function pageEntry($inPath){
    }
    
    
    //号码库管理
    public function pageLeft(){
        $shenheStatus = array(1=>"等待审核",2=>"审核通过",3=>"审核失败");
        $completeStatus = array(0=>"不完整订单",1=>"完整订单");
        $this->assign("shenheStatus",$shenheStatus);
        $this->assign("completeStatus",$completeStatus);
        return $this->render("crm/shenhe_left.html");
    }
    public function pageList(){
        $staus = array(0=>"未审核",1=>"等待审核",2=>"审核通过",3=>"审核未通过");
        $send_status = array(0=>"未发送",2=>"已发送");
        $condition = array();
        if(isset($_GET['status']) && isset($staus[$_GET['status']])){
            $condition['status'] = $_GET['status'];
        }
        if(isset($_GET['send_status']) && isset($send_status[$_GET['send_status']])){
            $condition['sms_send_status'] = $_GET['send_status'];
        }
        
        if(isset($_GET['key'])){
            $key = $_GET['key'];
            $search = array("plan_id","uid","plan_name","user_name");
            if(isset($_GET['search']) && in_array($_GET['search'], $search)){
                if($_GET['search'] === "user_name"){
                    $user = user_api::getUserByName($key);
                    $condition['uid'] = $user->uid;
                }else{
                    $sql = " `".$_GET['search']."` LIKE '%".$key."%' ";
                }
            }else{
                $sql = " `plan_name` LIKE '%".$key."% ";
            }
        }else{$sql ="";}
        
        $list = $this->planModel->getDataBySql($condition,$sql);
        $planList = array();
        foreach ($list as $plan){
            $user = (array)user_api::getUserByID($plan['uid']);
            if(isset($user['user_name'])){
                $plan['uname'] = $user['user_name'];
            }
            $plan['sms_send_type'] = trim($plan['sms_send_type'],";"); 
            $repeatInfo = explode(":", $plan['sms_send_type']);
            $plan['repeat_type'] = $repeatInfo[0];
            $plan['repeat_value'] = $repeatInfo[1];
            $plan['shenhe'] = json_decode($plan['remark'],true);
            $planList[$plan['plan_id']]['plan'] = $plan;
            
            $groupCondition = array();
            $groupCondition['plan_id'] = $plan['plan_id'];
            $groupListTemp = $this->groupModel->getData($groupCondition);
            
            $planList[$plan['plan_id']]['complete'] = 0;
            
            if(count($groupListTemp)!=0){
                $groupList = array();
                foreach ($groupListTemp as $group){
                    $adCondition = array();
                    $adCondition['group_id'] = $group['group_id'];
                    $adList = $this->adModel->getAdInfo($adCondition);
                    
                    if(count($adList)!=0){
                        $group['number_group_info'] = json_decode($group['number_group'],true);
                        $groupList[$group['group_id']]['group'] = $group;
                        $groupList[$group['group_id']]['ad'] = $adList;
                        $planList[$plan['plan_id']]['complete'] = 1;
                    }
                }
                $planList[$plan['plan_id']]['group'] = $groupList;
            }
        }
        if(isset($_GET['complete'])){
            foreach ($planList as $key=>$plan){
                if($plan['complete'] !=$_GET['complete']){
                    unset($planList[$key]);
                }
            }
        }
        
        $url = array();
        $url['search'] = '/baichuan_advertisement_manage/crm.shenhe.list?complete=1';
        $this->assign("url",$url);
        $this->assign("get",$_GET);
        $this->assign("planList",$planList);
        $this->assign("week",$this->week);
        $this->assign("sendType",$this->sendType);
        $this->assign("send_status",$send_status);
        return $this->render("crm/shenhe_list.html");
    }
    
    public function pageShenheIframe(){
        $staus = array(1=>"等待审核",2=>"审核通过",3=>"驳回");
        $url['formAction'] = "/baichuan_advertisement_manage/crm.shenhe.ChangeStatus";
        $this->assign('url',$url);
        $this->assign('get',$_GET);
        $this->assign('post',$_POST);
        $this->assign('staus',$staus);
        return $this->render("/crm/shenhe_change_status.html");
    }
    
    public function pageChangeStatus(){
        $staus = array(0=>"未审核",1=>"等待审核",2=>"审核通过",3=>"审核未通过");
        if(isset($_POST['plan_id']) && isset($_POST['status']) && isset($staus[$_POST['status']])){
            $condition = array();
            $condition['plan_id'] = $_POST['plan_id'];

            $data = array();
            $data['status'] = $_POST['status'];
            
            if(isset($_POST['remark']) && strlen($_POST['remark'])>0){
                $planInfo = $this->planModel->getData($condition);
                if(isset($planInfo['0']['remark']) && strlen($planInfo['0']['remark'])>0){
                    $remark = json_decode($planInfo['0']['remark'],true);
                    if(!is_array($remark)){
                        $remark = array();
                    }
                }
                $newRemark = array();
                $newRemark['time'] = time();
                $newRemark['status'] = $staus[$_POST['status']];
                $newRemark['uid'] = user_api::id();
                $newRemark['uname'] = user_api::name();
                $newRemark['text'] = $_POST['remark'];
                $remark[] = $newRemark;
                
                $data['remark'] = json_encode($remark);
            }
            
            $this->planModel->updateData($data,$condition);
            unset($data['remark']);
            $this->adModel->updateData($data,$condition);
        }
        
        $this->parentReload("操作完成");
    }
    
    public function pageCheckBlack(){
        $condition = array();
        $condition['status'] = 0;
        $numberToCheck = $this->receiverModel->getData($condition);
        foreach ($numberToCheck as $receiver){
            $numberCondition = array();
            $numberCondition['number'] = $receiver['number'];
            $numberCondition['type'] = 3;
            
            $exist = $this->numberModel->getCount($numberCondition);
            
            $data = array();
            $condition = array();
            $condition['number'] = $receiver['number'];
            if($exist > 0){
                $data['status'] = 2;
            }else{
                $data['status'] = 1;
            }
            $this->receiverModel->updateData($data,$condition);
        }
    }
}

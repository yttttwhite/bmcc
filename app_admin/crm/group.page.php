<?php
class crm_group extends STpl{
    public $planModel, $groupModel, $adModel;
    public $uid;
    public $numberModel, $numberGroupModel, $numberAuthModel, $receiverModel;
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
        
        $this->numberModel = new model_CrmNumber();
        $this->numberGroupModel = new model_CrmNumberGroup();
        $this->numberAuthModel = new model_CrmNumberAuth();
        $this->receiverModel = new model_CrmReceiver();
    }
    public function pageEntry($inPath){
    }
    public function pageList($inPath){
        if(!isset($_GET['plan_id'])){
            exit("NEED PlanID");
        }
        $condition = array();
        $condition['uid'] = $this->uid;
        $condition['plan_id'] = (int)$_GET['plan_id'];
        $list = $this->groupModel->getData($condition,0,20,'group_id');

        
        $this->assign('list',$list);
        return $this->render("crm/group_list.html");
    }
    
    public function pageAdd($inPath){
        if(isset($_GET['plan_id'])){
            $plan_id = $_GET['plan_id'];
        }else{
            exit("You need plan_id");
        }
        
        $condition = array();
        $condition['type']=1;
        $groupList = $this->numberGroupModel->getData($condition);
        $condition = array();
        $condition['uid']=user_api::id();
        $authList = $this->numberAuthModel->getData($condition);

        $area_level = rmc_db::listAreaByLevel();
        $area_region = rmc_db::listAreaByRegion();
        $crowds = audient_db::listCrowd(user_api::id());
        $crowds_default = audient_db::listCrowdDefault();
        $user_tags = audient_db::get_user_tags();
        if(!is_array($user_tags)){
            $user_tags = 0;
        }
        
        $this->assign("plan_id",$plan_id);
        $this->assign("authList",$authList);
        $this->assign("area_level",$area_level);
        $this->assign("area_region",$area_region);
        $this->assign("crowds",$crowds);
        $this->assign("crowds_default",$crowds_default);
        $this->assign("user_tags", $user_tags);
        return $this->render("crm/group_add.html");
    }
    
    public function pageSave($inPath){
        
        if(empty($inPath[3])){
            $this->parentReload("请选择广告计划","/crm.plan.list",2);
            exit();
        }
        $plan_id = $inPath[3];
        
        $data = array();
        $data['plan_id'] = $plan_id;
        $data['uid'] = user_api::id();
        $data['group_name'] = $_POST['name'];
        $data['area_list'] = $_POST['area_value'];
        $data['area_label'] = $_POST['area_label'];
        $data['keyword_list'] = str_replace(array("\r\n","\r","\n"), ',', $_POST['keyword_list']);
        $data['include_host'] = str_replace(array("\r\n","\r","\n"), ',', $_POST['_include_host']);
        $data['exclude_host'] = str_replace(array("\r\n","\r","\n"), ',', $_POST['_exclude_host']);
        $data['ctime'] = time();
        $data['mtime'] = time();
        /*
        $data['area_label'] = $_POST['_include_ip'];
        $data['area_label'] = $_POST['_exclude_ip'];
        $data['area_label'] = $_POST['_include_adsl'];
        $data['area_label'] = $_POST['_exclude_adsl'];
        */
        $id = $this->groupModel->addData($data);
        if($id > 0){
            $this->resetStatus($plan_id, 1,"广告被修改:新增广告组");
            
            
            $condition = array();
            $condition['uid'] = user_api::id();
            $authList = $this->numberAuthModel->getData($condition);
            $authList = $this->array_column($authList, "gid");
            
            if(isset($_POST['number_group_id']) && is_array($_POST['number_group_id']) && count($_POST['number_group_id'])>0){
                $numberGroupIdArray = $_POST['number_group_id'];
                
                $receiverList = array();
                $existNumberArray = array();
                $condition = array();
                $condition['group_id'] = $id;
                $existNumberArray = $this->receiverModel->getData($condition);
                $existNumberArray = $this->array_column($existNumberArray, "number");
                $receiverRepeat = 0;
                
                $groupData = array();
                $groupCondition = array();
                $groupCondition['group_id'] = $id;
                $groupNumberGroup = array();
                foreach ($numberGroupIdArray as $numberGroupId){
                    if(in_array($numberGroupId, $authList)){
                        $condition = array();
                        $condition['id'] = $numberGroupId;
                        $numberGroupInfo = $this->numberGroupModel->getData($condition);
                        
                        if(is_array($numberGroupInfo) && isset($numberGroupInfo[0])){
                            $numberGroupInfo = $numberGroupInfo[0];
                            
                            //记录号码库信息
                            $temp = array();
                            $temp['id'] = $numberGroupId;
                            $temp['name'] = $numberGroupInfo['name'];
                            $groupNumberGroup[] = $temp;
                        
                            $condition = array();
                            $condition['number_group_id'] = $numberGroupId;
                            $numberList = $this->numberModel->getData($condition);
                            foreach ($numberList as $key => $numberInfo){
                                if(in_array($numberInfo['number'], $existNumberArray)){
                                    $receiverRepeat++;
                                }else{
                                    $receiverInfo = array();
                                    $receiverInfo['plan_id'] = $plan_id;
                                    $receiverInfo['group_id'] = $id;
                                    $receiverInfo['number'] = $numberInfo['number'];
                                    $receiverInfo['number_group_id'] = $numberInfo['number_group_id'];
                                    $receiverInfo['number_group_name'] = $numberGroupInfo['name'];
                        
                                    $receiverList[] = $receiverInfo;
                                    $existNumberArray[] = $numberInfo['number'];
                                }
                            }
                        }
                    }
                }
                foreach ($receiverList as $receiver){
                    $this->receiverModel->addData($receiver);
                }
                
                $groupData['number_group'] = json_encode($groupNumberGroup);
                $this->groupModel->updateData($groupData,$groupCondition);
            }
            $this->success("添加成功，所选号码库有： ".$receiverRepeat." 个联系人重复，已经去除","/crm.plan.detail?plan_id=".$plan_id,5);
        }else{
            $this->success("添加失败","/crm.plan.list");
        }
    }
    
    public function pageDetail(){
        if(isset($_GET['group_id'])){
            $group_id = $_GET['group_id'];
            $condition = array();
            $condition['group_id'] = $group_id;
            $groups = $this->groupModel->getData($condition);

            if(isset($groups[0]['plan_id'])){
                $groupInfo = $groups[0];
                $areaInfo = $groupInfo['area_label'];
                $province = explode(';', $areaInfo);
                $province = array_filter($province);
                $cityArray = array();
                foreach ($province as $temp){
                    $tempArray = explode(":", $temp);
                    $cityArray['province'] = $tempArray[0];
                    $cityArray['city'] = $tempArray[1];
                    $groupInfo['area_info'][] = $cityArray;
                }
                $groupInfo['ctime'] = date("Y-m-d H:i:s",$groupInfo['ctime']);
                $groupInfo['mtime'] = date("Y-m-d H:i:s",$groupInfo['mtime']);
                
                
                //处理Plan信息
                $plan_id = $groups[0]['plan_id'];
                $planCondition = array();
                $planCondition['plan_id'] = $plan_id;
                $plans = $this->planModel->getData($planCondition);
                if(isset($plans[0])&&is_array($plans[0])){
                    $planInfo = $plans[0];
                    
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
                    
                    $planInfo['start_date'] = date("Y-m-d",$planInfo['start_date']);
                    $planInfo['end_date'] = date("Y-m-d",$planInfo['end_date']);
                    $planInfo['ctime'] = date("Y-m-d H:i:s",$planInfo['ctime']);
                    $planInfo['mtime'] = date("Y-m-d H:i:s",$planInfo['mtime']);
                }else{
                    $planInfo = 0;
                }
            }else{
                $planInfo = 0;
                $groupInfo = 0;
            }

            $adList = $this->adModel->getAdInfo($condition);
            
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
            $this->assign('groupInfo',$groupInfo);
            
            $this->assign('adList',$adList);
            $this->assign('get',$_GET);
            return $this->render("crm/group_detail.html");
        }
    }
    
    public function pageDelete(){
        if (isset($_GET['group_id'])){
            $condition = array();
            $condition['group_id'] = $_GET['group_id'];
            $condition['uid'] = user_api::id();
            
            $this->adModel->deleteData($condition);
            $this->groupModel->deleteData($condition);
        }
    }
    
    public function pageNumberLeft(){
        $checkStatus = array(0=>"等待审核",1=>"审核通过",2=>"审核失败");
        $sentStatus = array(0=>"等待发送",2=>"发送成功",3=>"发送失败");
        $this->assign("checkStatus",$checkStatus);
        $this->assign("sentStatus",$sentStatus);
        return $this->render("crm/group_number_left.html");
    }
    public function pageNumberList(){
        $checkStatus = array(0=>"等待审核",1=>"审核通过",2=>"审核失败");
        $sentStatus = array(0=>"等待发送",2=>"发送成功",3=>"发送失败");
        
        $condition = array();
        $stat = array();
        if(isset($_GET['group_id'])){
            $condition['group_id'] = $_GET['group_id'];
        }elseif(isset($_GET['plan_id'])){
            $condition['plan_id'] = $_GET['plan_id'];
            
            $tempCondition = array();
            $tempCondition['plan_id'] = $_GET['plan_id'];
            $tempCondition['sms_sendstatus'] = 0;
            $temp = $this->receiverModel->getData($tempCondition);
            $stat['wait'] = count($temp);
            
            $tempCondition = array();
            $tempCondition['plan_id'] = $_GET['plan_id'];
            $tempCondition['sms_sendstatus'] = 1;
            $temp = $this->receiverModel->getData($tempCondition);
            $stat['sent'] = count($temp);
        }else{
            $this->success("参数错误");
            exit();
        }
        $this->assign("stat",$stat);
        
        if(isset($_GET['status'])){
            $condition['status'] = $_GET['status'];
        }
        if(isset($_GET['sent_status'])){
            $condition['sms_sendstatus'] = $_GET['sent_status'];
        }
        
        if(user_api::auth('admin')){
            $list = $this->receiverModel->getData($condition,0,0,'status','DESC');
            
            $this->assign("list",$list);
            $this->assign("get",$_GET);
            $this->assign("checkStatus",$checkStatus);
            $this->assign("sentStatus",$sentStatus);
            return $this->render("crm/group_number_list.html");
        }else{
            if(isset($_GET['group_id'])){
                $condition['group_id'] = $_GET['group_id'];
                $result = $this->groupModel->getData($condition);
            }elseif(isset($_GET['plan_id'])){
                $condition['plan_id'] = $_GET['plan_id'];
                $result = $this->planModel->getData($condition);
            }
            
            if(isset($result[0]['uid']) && $result[0]['uid']==user_api::id()){
                $list = $this->receiverModel->getData($condition,0,0,'status','DESC');
                
                $this->assign("list",$list);
                $this->assign("get",$_GET);
                $this->assign("checkStatus",$checkStatus);
                $this->assign("sentStatus",$sentStatus);
                return $this->render("crm/group_number_list.html");
            }else{
                $this->success("没有权限");
                exit();
            }
        }
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

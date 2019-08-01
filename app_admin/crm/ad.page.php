<?php
class crm_ad extends STpl{
    public $planModel, $groupModel, $adModel, $creativeModel;
    public $forbiddenWordModel;
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
        $this->forbiddenWordModel = new model_CrmForbiddenWord();
    }
    public function pageEntry($inPath){
    }
    public function pageList($inPath){
        if(!isset($_GET['pid'])){
            exit("NEED PlanID");
        }
        $condition = array();
        $condition['uid'] = $this->uid;
        $condition['plan_id'] = (int)$_GET['pid'];
        $list = $this->groupModel->getData($condition,0,20,'group_id');

        
        $this->assign('list',$list);
        return $this->render("crm/group_list.html");
    }
    
    public function pageAddIframe(){
        $group = array();
        if(isset($_GET['group_id'])){
            $group['group_id'] = $_GET['group_id'];
        }
        
        if(isset($_POST['group_id']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['type']) ){
            $creativeInfo = array();
            $creativeInfo['uid'] = user_api::id();
            $creativeInfo['type'] = $_POST['type'];
            $creativeInfo['name'] = $_POST['title'];
            $creativeInfo['text'] = $_POST['content'];
            $creativeInfo['ctime'] = time();
            $creativeInfo['mtime'] = time();
            
            if(strlen($creativeInfo['text'])>140 || strlen($creativeInfo['text'])<5){
                $this->parentReload("短信内容不能超过70个汉字或者140个字符，也不能小于5个汉字或者10个字符");
                exit();
            }
            $checkWord = $this->check($creativeInfo['text']);
            
            if(!$checkWord){
                $this->parentReload("短信内容包含敏感词，请修改");
                exit();
            }
            
            
            $creativeId = $this->creativeModel->addData($creativeInfo);
            
            if($creativeId > 0){
                $adInfo = array();
                
                $groupCondition = array();
                $groupCondition['group_id'] = $_POST['group_id'];
                $groupInfo = $this->groupModel->getData($groupCondition);
                if(is_array($groupInfo) && isset($groupInfo[0]['plan_id'])){
                    $adInfo['plan_id'] = $groupInfo[0]['plan_id'];
                    
                    $this->resetStatus($adInfo['plan_id'],1,"广告被修改：新增广告内容");
                }
                
                $adInfo['group_id'] = $_POST['group_id'];
                $adInfo['adname'] = $_POST['title'];
                $adInfo['adType'] = $_POST['adType'];
                $adInfo['creative_id'] = $creativeId;
                $adInfo['ctime'] = time();
                $adInfo['mtime'] = time();
                $adInfo['uid'] = user_api::id();
                $adId = $this->adModel->addData($adInfo);
                
                $this->parentReload("操作成功");
            }
        }else{
            $url['formAction'] = '/crm.ad.addIframe';
            $this->assign('group',$group);
            $this->assign('url',$url);
            $this->assign('get',$_GET);
            return $this->render("crm/iframe_add_creative.html");
        }
    }
    
    public function check($str){
        $wordList = $this->forbiddenWordModel->getData();
        $forbidden = array();
        foreach ($wordList as $word){
            if(stripos($str, $word['word'])!==false){
                $forbidden[] = $word['word'];
            }
        }
        if(count($forbidden)>0){
            return false;
        }else{
            return true;
        }
    }
    
    public function pageDelete(){
        if (isset($_GET['adid'])){
            $condition = array();
            $condition['adid'] = $_GET['adid'];
            $condition['uid'] = user_api::id();
            $this->adModel->deleteData($condition);
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

<?php
class admin_plan extends STpl{
    public $userInfoModel, $planInfoModel, $adInfoModel;
    public function __construct($inPath){
        if(!user_api::auth("admin")){
            die("权限拒绝");
        }
        $this->init();
    }
    
    public function init(){
        $this->userInfoModel = new model_userInfo();
        $this->planInfoModel = new model_planInfo();
        $this->adInfoModel   = new model_adInfo();
    }
    
    public function pageList(){
        $adTypeList = array(
            1=>"嵌入式",  
            2=>"浮窗",
            8=>"重定向",
            16=>"重定向(DPC)",
            32=>"底通",
            64=>"无线APP",
            128=>"无线浮标",
            3=>"嵌入式,浮窗",
        );
        $enableList = array(
            1=>"有效",
            2=>"无效",
            3=>"过期",
            4=>"删除",
            5=>"冻结",
            6=>"预算暂停"
        );
        $verifyList = array(
            1=>"待审核",
            2=>"审核通过",
            3=>"拒绝",
        );
        $condition = array();
        $like = array();
        
        if(isset($_GET['key'])){
            $like['plan_name'] = "%".$_GET['key']."%";
        }
        
        if(isset($_GET['uid'])){
            $condition['uid'] = $_GET['uid'];
        }
        
        if(isset($_GET['enable'])){
            $condition['enable'] = $_GET['enable'];
        }
        if(isset($_GET['verify'])){
            $condition['verified_or_not'] = $_GET['verify'];
        }
        
        if(count($like)>0){
            $list = $this->planInfoModel->getDataLike($condition,$like,0,100);
        }else{
            $list = $this->planInfoModel->getData($condition,0,100);
        }
        $planList = $list;
        
        $condition = array();
        $condition['uid'] = $_GET['uid'];
        $adList = $this->adInfoModel->getData($condition);
        
        $planAd = array();
        foreach ($adList as $adInfo){
            $planAd[$adInfo['plan_id']][] = $adInfo;
        }
        
        $this->assign("planList",$planList);
        $this->assign("adList",$adList);
        $this->assign("planAd",$planAd);
        $this->assign("verifyList",$verifyList);
        $this->assign("adTypeList",$adTypeList);
        $this->assign("enableList",$enableList);
        $this->assign("_GET",$_GET);
        return $this->render("admin/plan_list.html");
    }
}
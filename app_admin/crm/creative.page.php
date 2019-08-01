<?php
class crm_creative extends STpl{
    public $planModel, $groupModel, $creativeModel;
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
    
    public function pageAddIframe($inPath){
        return $this->render("crm/iframe_add_creative.html");
    }
}

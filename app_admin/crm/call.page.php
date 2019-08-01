<?php
class crm_call extends STpl{
    public $targetModel, $targetGroupModel;
    public $typeList;
    public function __construct($inPath){
        user_api::getUserByName(user_api::name());
        if(user_api::id()==0){
            header("location:/baichuan_advertisement_manage/user");
        }else{
        }
        $this->init();
    }
    public function init(){
        $this->targetModel = new model_CrmTarget();
        $this->targetGroupModel = new model_CrmTargetGroup();
        
        $this->typeList = array(1=>'ADSL');
    }
    public function pageEntry($inPath){
    }
    public function pageLeft(){
    }
    public function pageContact(){
        $groupInfoTemp = $this->targetGroupModel->getData();
        $groupInfoArray = array();
        foreach ($groupInfoTemp as $groupInfo){
            $groupInfoArray[$groupInfo['id']] = $groupInfo['name'];
        }
        
        $condition =  array();
        $condition['status'] = 1;
        $count = $this->targetModel->getCount($condition);
        $page = array();
        $page['perpage'] = 100;
        $page['count'] = ceil($count/$page['perpage']);
        $getArray = $this->unsetGet('page');
        $page['url'] = $this->setGet('/crm.target.list', $getArray);
        if(isset($_GET['page'])){
            $page['current'] = $_GET['page'];
        }else{
            $page['current'] = 1;
        }
        $list = $this->targetModel->getData($condition,$page['perpage']*($page['current']-1),$page['perpage']);
        
        $this->assign("list",$list);
        $this->assign("page",$page);
        $this->assign("groupInfoArray",$groupInfoArray);
        $this->assign("typeList",$this->typeList);
        return $this->render("/crm/call_list.html");
    }
}

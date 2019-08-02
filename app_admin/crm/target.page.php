<?php
class crm_target extends STpl{
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
    public function pageList(){
        $groupInfoTemp = $this->targetGroupModel->getData();
        $groupInfoArray = array();
        foreach ($groupInfoTemp as $groupInfo){
            $groupInfoArray[$groupInfo['id']] = $groupInfo['name'];
        }
        
        $condition =  array();
        $count = $this->targetModel->getCount($condition);
        $page = array();
        $page['perpage'] = 100;
        $page['count'] = ceil($count/$page['perpage']);
        $getArray = $this->unsetGet('page');
        $page['url'] = $this->setGet('/baichuan_advertisement_manage/crm.target.list', $getArray);
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
        return $this->render("/crm/target_list.html");
    }
    
    public function pageAdd(){
        $url['formAction'] = '/crm.target.save';
        $groupList = $this->targetGroupModel->getData();
        $this->assign("url",$url);
        $this->assign("groupList",$groupList);
        $this->assign("typeList",$this->typeList);
        return $this->render('crm/target_add.html');
    }
    public function pageImport(){
        $url['formAction'] = '/baichuan_advertisement_manage/crm.target.save';
        $groupList = $this->targetGroupModel->getData();
        $this->assign("url",$url);
        $this->assign("groupList",$groupList);
        $this->assign("typeList",$this->typeList);
        return $this->render('crm/target_import.html');
    }
    
    public function pageSave(){
        if(!isset($_POST['type']) || !isset($this->typeList[$_POST['type']])){
            $this->parentReload('请确认账号类型');
        }
        
        if(isset($_POST['group_id']) && is_numeric($_POST['group_id'])){
            $groupId = $_POST['group_id'];
        }else{
            $groupId = 0;
        }
        
        if(isset($_POST['accountStr']) && strlen($_POST['accountStr'])>0){
            $accountStr = $_POST['accountStr'];
        }elseif(in_array($_FILES["accountFile"]["type"], array("text/plain")) && ($_FILES["accountFile"]["size"] < 200000)){
            if ($_FILES["accountFile"]["error"] > 0){
                echo "Error: " . $_FILES["accountFile"]["error"] . "<br />";
                $this->parentReload("请检查文件","/",3);
            }else{
                $file = $_FILES["accountFile"]["tmp_name"];
                $accountStr = file_get_contents($file);
            }
        }else{
            $this->parentReload('请确认输入内容');
        }
        
        
        $accountStr = str_ireplace(array("\r\n","\r"), "\n", $accountStr);
        $accountArray = explode("\n", $accountStr);
        
        $data = array();
        $data['type'] = $_POST['type'];
        $data['ctime'] = time();
        $data['status'] = 1;
        $data['group_id'] = $groupId;
        
        $condition = array();
        $condition['group_id'] = $groupId;
        
        foreach ($accountArray as $account){
            $data['account'] = $account;
            $condition['account'] = $account;
            $id = $this->targetModel->addData($data,$condition);
            if($id > 0){
                $result['success'][] = $account;
            }else{
                $result['error'][] = $account;
            }
        }
        $this->assign('result',$result);
        return $this->render('public/result.html');
    }
    
    public function pageDelete(){
        if(isset($_GET['id']) && user_api::auth('admin')){
            $condition = array();
            $condition['id'] = $_GET['id'];
            $this->targetModel->deleteData($condition);
        }
    }
}

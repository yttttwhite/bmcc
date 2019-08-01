<?php
class crm_chudian extends STpl{
    public $chudianModel,$apiType;
    
    public function __construct($inPath){
        user_api::getUserByName(user_api::name());
        if(user_api::id()==0){
            header("location:/baichuan_advertisement_manage/user");
        }else{
        }
        $this->init();
    }
    public function init(){
        $this->apiType = array(1=>"短信",2=>"呼叫中心");
        $this->chudianModel = new model_CrmChudian();
    }
    public function pageList(){
        if(isset($_GET['uid'])){
            $user = user_api::getUserByID($_GET['uid']);
            if($user->uid > 0){
                $condition = array();
                $condition['uid'] = $user->uid;
                $list = $this->chudianModel->getData($condition);
                $this->assign("list",$list);
                $this->assign("apiType",$this->apiType);
                return $this->render("/crm/chudian_list_by_user.html");
            }else{
                $this->success("改用户不存在","/admin.user.list");
            }
        }else{
            $this->success("改用户不存在","/admin.user.list");
        }
    }
    public function pageMyList(){
        $user = user_api::getUserByID(user_api::id());
        if($user->uid > 0){
            $condition = array();
            $condition['uid'] = $user->uid;
            $list = $this->chudianModel->getData($condition);
            $this->assign("list",$list);
            $this->assign("apiType",$this->apiType);
            return $this->render("/crm/chudian_list_by_user.html");
        }else{
            $this->success("改用户不存在","/admin.user.list");
        }
    }
    public function pageAdd(){
        if(isset($_GET['id'])){
            $condition = array();
            $condition['id'] = $_GET['id'];
            $chudian = $this->chudianModel->getData($condition);
            if(isset($chudian[0])){
                $chudian = $chudian[0];
            }
        }else{
            $chudian = array();
        }

        $url['formAction'] = "/crm.chudian.Save";
        $this->assign('url',$url);
        
        if(isset($_GET['uid'])){
            $user = user_api::getUserByID($_GET['uid']);
            if($user->uid > 0){
                $this->assign("user",$user);
                $this->assign("chudian",$chudian);
                return $this->render("/crm/chudian_add_iframe.html");
            }else{
                $this->success("改用户不存在","/admin.user.list");
            }
        }else{
            $this->success("改用户不存在","/admin.user.list");
        }
    }
    
    public function pageSave(){
        if(isset($_POST['userId']) && isset($_POST['api_type']) && isset($this->apiType[$_POST['api_type']])){
            $user = user_api::getUserByID($_POST['userId']);
            if($user->uid >0){
                $data = array();
                $data['uid'] = $user->uid;
                $data['uname'] = $user->user_name;
                $data['api_type'] = $_POST['api_type'];
                $data['api_partner'] = $_POST['api_partner'];
                $data['api_key'] = $_POST['api_key'];
                $data['api_secret'] = $_POST['api_secret'];
                $data['api_address'] = $_POST['api_address'];
                $data['api_charge'] = $_POST['api_charge'];
                
                if(isset($_POST['id']) && strlen($_POST['id'])>0){
                    $condition = array();
                    $condition['id'] = $_POST['id'];
                    $id = $this->chudianModel->updateData($data,$condition);
                }else{
                    $id = $this->chudianModel->addData($data,$data);
                }
    
                if($id>0){
                    $this->parentReload("添加成功");
                }else{
                    $this->parentReload("添加失败，可能重复授权");
                }
            }else{
                $this->parentReload("用户或者号码库不存在");
            }
        }else{
            $this->parentReload("输入信息错误");
        }
    }
    
    public function pageDelete(){
        if(isset($_GET['id']) && strlen($_GET['id'])>0){
            $condition = array();
            $condition['id'] = $_GET['id'];
            
            $count = $this->chudianModel->deleteData($condition);
            if($count>0){
                echo "删除成功";
            }else{
                echo "删除成功";
            }
        }else{
            echo "删除失败";
        }
    }
}
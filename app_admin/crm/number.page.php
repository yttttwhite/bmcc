<?php
class crm_number extends STpl{
    public $numberModel, $numberGroupModel, $numberAuthModel;
    public function __construct($inPath){
        user_api::getUserByName(user_api::name());
        if(user_api::id()==0){
            header("location:/baichuan_advertisement_manage/user");
        }else{
        }
        $this->init();
    }
    public function init(){
        $this->numberModel = new model_CrmNumber();
        $this->numberGroupModel = new model_CrmNumberGroup();
        $this->numberAuthModel = new model_CrmNumberAuth();
    }
    public function pageEntry($inPath){
    }
    
    //号码库分组管理
    public function pageGroupLeft(){
        $typeArray = array(1=>"营销号码库",2=>"白名单",3=>"黑名单",0=>"无效号码库");
        $this->assign("typeArray",$typeArray);
        $this->assign("get",$_GET);
        $this->assign("post",$_POST);
        return $this->render("number/group_left.html");
    }
    public function pageGroupList(){
        $typeArray = array(1=>"营销号码库",2=>"白名单",3=>"黑名单",0=>"无效号码库");
        if(isset($_GET['type']) && isset($typeArray[$_GET['type']])){
            $condition = array();
            $condition['type'] = $_GET['type'];
            $list = $this->numberGroupModel->getData($condition);
        }else{
            $list = $this->numberGroupModel->getData();
        }
        $this->assign("list",$list);
        return $this->render("number/group_list.html");
    }
    public function pageGroupAddIframe(){
        if(isset($_GET['group_id'])){
            $condition = array();
            $condition['id'] = $_GET['group_id'];
            $group = $this->numberGroupModel->getData($condition);
            if(isset($group[0]['id']) && $group[0]['id']>0){
                $group = $group[0];
            }else{
                $group = array();
            }
        }else{
            $group = array();
        }
        $url['formAction'] = "/baichuan_advertisement_manage/crm.number.groupsave";
        $this->assign('group',$group);
        $this->assign('url',$url);
        return $this->render("/number/group_add_iframe.html");
    }
    public function pageGroupSave(){
        $typeArray = array(0=>"无效号码库",1=>"营销号码库",2=>"黑名单",3=>"白名单");
        if(isset($_POST['type']) && isset($typeArray[$_POST['type']]) && isset($_POST['name']) && strlen($_POST['name'])>0 ){
            $data = array();
            $data['type'] = $_POST['type'];
            if(strlen($_POST['name'])>50){
                $data['name'] = substr($_POST['name'], 0, 45)."…";
            }else{
                $data['name'] = $_POST['name'];
            }
            if(isset($_POST['remark'])){
                $data['remark'] = $_POST['remark'];
            }
            $data['creator_id'] = user_api::id();
            $data['creator_name'] = user_api::name();
            $data['mtime'] = time();
            if(isset($_POST['number_group_id']) && is_numeric($_POST['number_group_id'])){
                $condition = array();
                $condition['id'] = $_POST['number_group_id'];
                $this->numberGroupModel->updateData($data,$condition);
            }else{
                $data['ctime'] = time();
                $this->numberGroupModel->addData($data);
            }
            $this->parentReload("操作完成，即将刷新");
        }else{
            $this->parentReload("表单参数错误，即将刷新");
        }
    }
    public function pageGroupDelete(){
        if(isset($_GET['id']) && strlen($_GET['id'])>0){
            $condition = array();
            $condition['id'] = $_GET['id'];
            $count = $this->numberGroupModel->deleteData($condition);
            if($count > 0 || true){
                $condition = array();
                $condition['number_group_id'] = $_GET['id'];
                $this->numberModel->deleteData($condition);
                
                $condition = array();
                $condition['gid'] = $_GET['id'];
                $this->numberAuthModel->deleteData($condition);
            }
            if($count>0){
                echo "删除成功";
            }else{
                echo "删除失败";
            }
        }else{
            echo "删除失败";
        }
    }
    public function updateGroupCount($groupId){
        $condition = array();
        $condition['number_group_id'] = (int)$groupId;
        $count = $this->numberModel->getCount($condition);
        $data = array();
        $data['count'] = (int)$count;
        $condition = array();
        $condition['id'] = (int)$groupId;
        
        $this->numberGroupModel->updateData($data,$condition);
    }
    
    public function pageAuthList(){
        if(isset($_GET['uid'])){
            $user = user_api::getUserByID($_GET['uid']);
            if($user->uid > 0){
                $condition = array();
                $condition['uid'] = $user->uid;
                $authList = $this->numberAuthModel->getData($condition);
                $this->assign("authList",$authList);
                return $this->render("/number/auth_list_by_user.html");
            }else{
                $this->success("改用户不存在","/baichuan_advertisement_manage/admin.user.list");
            }
        }else{
            $this->success("改用户不存在","/baichuan_advertisement_manage/admin.user.list");
        }
    }
    public function pageMyAuthList(){
        $user = user_api::getUserByID(user_api::id);
        if($user->uid > 0){
            $condition = array();
            $condition['uid'] = $user->uid;
            $authList = $this->numberAuthModel->getData($condition);
            $this->assign("authList",$authList);
            return $this->render("/number/auth_list_by_user.html");
        }else{
            $this->success("改用户不存在","/baichuan_advertisement_manage/admin.user.list");
        }
    }
    public function pageAuthAdd(){
        $condition = array();
        $condition['type'] = 1;
        $groupList = $this->numberGroupModel->getData($condition);
        $url['formAction'] = "/baichuan_advertisement_manage/crm.number.AuthSave";
        $this->assign('url',$url);
        $this->assign('groupList',$groupList);
        
        if(isset($_GET['uid'])){
            $user = user_api::getUserByID($_GET['uid']);
            if($user->uid > 0){
                $this->assign("user",$user);
                return $this->render("/number/auth_add_iframe.html");
            }else{
                $this->success("改用户不存在","/baichuan_advertisement_manage/admin.user.list");
            }
        }else{
            $this->success("改用户不存在","/baichuan_advertisement_manage/admin.user.list");
        }
    }
    public function pageAuthDelete(){
        if(isset($_GET['id'])){
            $condition = array();
            $condition['id'] = $_GET['id'];
            $this->numberAuthModel->deleteData($condition);
        }
    }
    
    public function pageAuthSave(){
        if(isset($_POST['group_id']) && isset($_POST['userId'])){
            $condition = array();
            $condition['id'] = $_POST['group_id'];
            $group = $this->numberGroupModel->getData($condition);
            $user = user_api::getUserByID($_POST['userId']);
            if(isset($group[0]['id']) && $user->uid >0){
                $data = array();
                $data['uid'] = $user->uid;
                $data['uname'] = $user->user_name;
                $data['gid'] = $_POST['group_id'];
                $data['gname'] = $group[0]['name'];
                $data['creator_id'] = user_api::id();
                $data['creator_name'] = user_api::name();
                $data['ctime'] = time();
                $data['mtime'] = time();
                
                $existCondition = array();
                $existCondition['uid'] = $data['uid'];
                $existCondition['gid'] = $data['gid'];
                $id = $this->numberAuthModel->addData($data,$existCondition);
                if($id>0){
                    $this->parentReload("授权成功");
                }else{
                    $this->parentReload("授权失败，可能重复授权");
                }
            }else{
                $this->parentReload("用户或者号码库不存在");
            }
        }else{
            $this->parentReload("输入信息错误");
        }
    }
    
    //号码库管理
    public function pageLeft(){
        return $this->render("number/left.html");
    }
    public function pageList(){
        $typeArray = array(1=>"营销号码库",2=>"白名单",3=>"黑名单",0=>"无效号码库");
        
        $condition = array();
        if(isset($_GET['group_id'])){
            $condition['number_group_id'] = $_GET['group_id'];
            
            $groupCondition = array();
            $groupCondition['id'] = $_GET['group_id'];
            $groupInfo = $this->numberGroupModel->getData($groupCondition);
            if(isset($groupInfo[0]['type']) && isset($typeArray[$groupInfo[0]['type']])){
                $typeId = $groupInfo[0]['type'];
                $groupCondition = array();
                $groupCondition['type'] = $typeId;
                $groupList = $this->numberGroupModel->getData($groupCondition);
            }else{
                $groupList = array();
            }
        }
        if(isset($_GET['key']) && strlen($_GET['key'])>0){
            $condition['number'] = $_GET['key'];
        }
        
        if(count($condition)>0){
            $allGroup = $this->numberGroupModel->getData();
            $groupInfoArray = array();
            foreach ($allGroup as $key=>$value){
                $groupInfoArray[$value['id']] = $value;
            }
            
            $list = $this->numberModel->getData($condition);
            
            $this->assign("list",$list);
            $this->assign("typeArray",$typeArray);
            $this->assign("get",$_GET);
            $this->assign("groupList",$groupList);
            $this->assign("groupInfoArray",$groupInfoArray);
            return $this->render("number/number_list.html");
        }
        exit();
        
        if(isset($_GET['group_id'])){
            //获取号码库分组信息
            $groupCondition = array();
            $groupCondition['id'] = $_GET['group_id'];
            $groupInfo = $this->numberGroupModel->getData($groupCondition);
            if(isset($groupInfo[0]['type']) && isset($typeArray[$groupInfo[0]['type']])){
                $typeId = $groupInfo[0]['type'];
                $groupCondition = array();
                $groupCondition['type'] = $typeId;
                $groupList = $this->numberGroupModel->getData($groupCondition);
                
                $condition = array();
                $condition['number_group_id'] = $_GET['group_id'];
                if(isset($_GET['key']) && strlen($_GET['key'])>0){
                    $condition['number'] = $_GET['key'];
                }
                $list = $this->numberModel->getData($condition);
                
                $this->assign("list",$list);
                $this->assign("typeArray",$typeArray);
                $this->assign("get",$_GET);
                $this->assign("groupList",$groupList);
                return $this->render("number/number_list.html");
            }else{
                $this->success("没有找到该分组，即将返回分组列表","/baichuan_advertisement_manage/crm.number.grouplist");
            }
        }else{
            $this->success("请选择分组，即将返回分组列表","/baichuan_advertisement_manage/crm.number.grouplist");
        }
    }
    public function pageAddIframe(){
        if(isset($_GET['group_id'])){
            $url['formAction'] = "/baichuan_advertisement_manage/crm.number.save";
            $this->assign('url',$url);
            $this->assign('get',$_GET);
            return $this->render("/number/add_iframe.html");
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    public function pageImportIframe(){
        if(isset($_GET['group_id'])){
            $url['formAction'] = "/baichuan_advertisement_manage/crm.number.import";
            $this->assign('url',$url);
            $this->assign('get',$_GET);
            return $this->render("/number/import_iframe.html");
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    public function pageImport(){
        if (in_array($_FILES["numberList"]["type"], array("text/plain")) && ($_FILES["file"]["size"] < 200000)){
            if ($_FILES["numberList"]["error"] > 0){
                echo "Error: " . $_FILES["file"]["error"] . "<br />";
                $this->parentReload("请检查文件","/",3);
            }else{
                $file = $_FILES["numberList"]["tmp_name"];
                $numberStr = file_get_contents($file);
            
                $numberStr = str_ireplace(array("\r\n","\r"), "\n", $numberStr);
                $numberStr = str_ireplace(array("&","+86","+","-"," ","\t"), "", $numberStr);
                $numberList = explode("\n", $numberStr);
            
                $typeArray = array(1=>"营销号码库",2=>"白名单",3=>"黑名单",0=>"无效号码库");
                if(isset($_POST['group_id'])){
                    //获取号码库分组信息
                    $groupCondition = array();
                    $groupCondition['id'] = $_POST['group_id'];
                    $groupInfo = $this->numberGroupModel->getData($groupCondition);
                    if(isset($groupInfo[0]['type']) && isset($typeArray[$groupInfo[0]['type']])){
                        $addResult = array();
                        foreach ($numberList as $number){
                            if(strlen($number)>0){
                                $condition = array();
                                $data =array();
                                $data['number_group_id'] = $condition['number_group_id'] = $_POST['group_id'];
                                $data['number'] = $condition['number'] = $number;
                
                                $data['creator_id'] = user_api::id();
                                $data['creator_name'] = user_api::name();
                                $data['ctime'] = $data['mtime'] = time();
                                $data['type'] = $groupInfo[0]['type'];
                
                                $result = $this->numberModel->addData($data,$condition);
                                if($result < 0){
                                    $addResult['exist'][] = $data['number'];
                                }else{
                                    $addResult['success'][] = $data['number'];
                                }
                            }
                        }
                        $this->updateGroupCount($_POST['group_id']);
                        $this->assign('addResult',$addResult);
                        return $this->render("/number/add_result.html");
                    }else{
                        $this->parentReload("没有找到该分组，即将刷新");
                    }
                }else{
                    $this->parentReload("参数错误，即将刷新");
                }
            }
        }else{
            $this->parentReload("请检查文件，目前仅支持TXT类型");
        }
    }
    public function pageUpdateIframe(){
        if(isset($_GET['id'])){
            $url['formAction'] = "/baichuan_advertisement_manage/crm.number.updateSave";
            $this->assign('url',$url);
            $this->assign('get',$_GET);
            return $this->render("/number/update_iframe.html");
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    public function pageUpdateSave(){
        if(isset($_POST['id']) && isset($_POST['number'])){
            $condition = array();
            $condition['id'] = $_POST['id'];
            $date = array();
            $data['number'] = $_POST['number'];
            $this->numberModel->updateData($data,$condition);
            $this->parentReload("修改成功");
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    
    public function pageSave(){
        $typeArray = array(1=>"营销号码库",2=>"白名单",3=>"黑名单",0=>"无效号码库");
        if(isset($_POST['group_id'])){
            //获取号码库分组信息
            $groupCondition = array();
            $groupCondition['id'] = $_POST['group_id'];
            $groupInfo = $this->numberGroupModel->getData($groupCondition);
            if(isset($groupInfo[0]['type']) && isset($typeArray[$groupInfo[0]['type']])){
                $numberStr = $_POST['numberStr'];
                
                $numberStr = str_ireplace(array("\r\n","\r"), "\n", $numberStr);
                $numberStr = str_ireplace(array("&","+86","+","-"," ","\t"), "", $numberStr);
                $numberList = explode("\n", $numberStr);
                $addResult = array();
                foreach ($numberList as $number){
                    if(strlen($number)>0){
                        $condition = array();
                        $data =array();
                        $data['number_group_id'] = $condition['number_group_id'] = $_POST['group_id'];
                        $data['number'] = $condition['number'] = $number;
                
                        $data['creator_id'] = user_api::id();
                        $data['creator_name'] = user_api::name();
                        $data['ctime'] = $data['mtime'] = time();
                        $data['type'] = $groupInfo[0]['type'];
                        
                        $result = $this->numberModel->addData($data,$condition);
                        if($result < 0){
                            $addResult['exist'][] = $data['number'];
                        }else{
                            $addResult['success'][] = $data['number'];
                        }
                    }
                }
                $this->assign('addResult',$addResult);
                return $this->render("/number/add_result.html");
            }else{
                $this->parentReload("没有找到该分组，即将刷新");
            }
        }else{
            $this->parentReload("参数错误，即将刷新");
        }
    }
    
    public function pageDelete(){
        if(isset($_GET['id']) && strlen($_GET['id'])>0){
            $condition = array();
            $condition['id'] = $_GET['id'];
    
            $count = $this->numberModel->deleteData($condition);
            if($count>0){
                echo "删除成功";
            }else{
                echo "删除失败";
            }
        }else{
            echo "删除失败";
        }
    }
    
}

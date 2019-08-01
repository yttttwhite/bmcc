<?php
class admin_system extends STpl{
    public $userInfoModel, $planInfoModel, $adInfoModel, $stuffInfoModel;
    public $userTagModel;
    public $updateTypes;
    public function __construct($inPath){
        if(!user_api::auth("admin") && !user_api::auth("it")){
            die("权限拒绝");
        }
        $this->init();
    }
    
    public function init(){
        $this->assign("tagType",array(0=>"自定义标签",2=>"位置标签"));
        $this->userInfoModel    = new model_userInfo();
        $this->planInfoModel    = new model_planInfo();
        $this->adInfoModel      = new model_adInfo();
        $this->stuffInfoModel   = new model_stuffInfo();
        $this->userTagModel     = new model_userTag();
        $this->updateTypes = array(
            1=>"每天更新",
            2=>"间隔更新",
            3=>"只更新一次",
        );
    }
    
    public function pageLeft($inPath){
        return $this->render("admin/system_left.html");
    }
    
    public function pageTag(){
        $list = $this->userTagModel->getData(array("type"=>0));
        foreach ($list as $key=>$value){
            $feqInfo = explode(":", $value['feq']);
            $updateRule = "";
            if(count($feqInfo)==3){
                $updateRule .= $this->updateTypes[$feqInfo[0]];
                $updateRule .="";
                if($feqInfo[0] == 1){
                    $updateRule .= "：每天".$feqInfo[1]."点".$feqInfo[2]."分更新";
                }elseif($feqInfo[0] == 2){
                    $updateRule .= "：每隔".$feqInfo[1]."小时".$feqInfo[2]."分更新";
                }
            }
            if(strlen($updateRule)>0){
                $list[$key]['update_rule_alias'] = $updateRule;
            }else{
                $list[$key]['update_rule_alias'] = $value['feq'];
            }
        }
        foreach ($list as $key => $value) {
        	$id[$key] = $value['id'];
        	$creator_id[$key] = $value['creator_id'];
        }
        array_multisort($id,SORT_ASC,$creator_id,SORT_ASC,$list);
        $this->assign('tags',$list);
        return $this->render("admin/system_tag.html");
    }
    public function pageAddTag(){
        require __DIR__ .'../../../tools/SensitiveWordFilter.php';
        $filter = new SensitiveWordFilter(__DIR__ . '../../../tools/dict.txt');
        $word = $_POST;
        if(!empty($_POST)){
            $word = $_POST;
            foreach ($word as $value) {
                $re = $filter->filter(trim($value), 0);
                if($re == false){
                    $this->success("您输入的有敏感词请检查后，再创建", "/admin.system.tag") ;
                    exit;
                }
            }
        
        }
        $flag = 1;
        $data = array();
        $fields = array('name','type','coverage','sql_string','enabled');
        $fieldsRequired = array('name');
        if(isset($_POST['name'])){
            foreach ($fields as $field){
                if(isset($_POST[$field]) && strlen($_POST[$field])>0){
                    $data[$field] = $_POST[$field];
                }elseif(in_array($field, $fieldsRequired)){
                    $flag = 0;
                    break;
                }else{
                    $data[$field] = 0;
                }
            }
            
            if(isset($_POST['feq_type'])&&isset($_POST['feq_hour'])&&isset($_POST['feq_minute']) && strlen($_POST['feq_type'])>0&& strlen($_POST['feq_hour'])>0&& strlen($_POST['feq_minute'])>0){
                $data['feq'] = $_POST['feq_type'].":".$_POST['feq_hour'].":".$_POST['feq_minute'];
            }
            
            if($flag){
                if(isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id']>0){
                    $id = $this->userTagModel->updateData($data,array('id'=>$_POST['id']));
                    $data['id'] = $_POST['id'];
                }else{
                    $id = $this->userTagModel->addData($data);
                    if($id > 0){
                        $data['id'] = $id;
                    }
                }
                header("location:/baichuan_advertisement_manage/admin.system.tag");
            }
        }elseif(isset($_GET['id'])){
            $condition = array('id'=>$_GET['id']);
            $list = $this->userTagModel->getData($condition);
            if(isset($list[0]['name'])){
                $data = $list[0];
            }
        }
        
        if(isset($data['feq'])&&strlen($data['feq'])>0){
            $feqInfo = explode(":", $data['feq']);
            if(count($feqInfo)==3){
                $data['feq_type']=$feqInfo[0];
                $data['feq_hour']=$feqInfo[1];
                $data['feq_minute']=$feqInfo[2];
            }
        }
        $this->assign('tag',$data);
        return $this->render("admin/system_tag_add.html");
    }
}

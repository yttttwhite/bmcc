<?php
class tag_area extends STpl{
    public $userTagModel;
    public function __construct($inPath){
        if(!user_api::auth("area") && !user_api::auth("admin")){
            die("权限拒绝");
        }
        $this->init();
    }
    public function init(){
        $this->assign("tagType",array(0=>"自定义标签",2=>"位置标签"));
        $this->userTagModel = new model_userTag();
    }
    public function pageLeft($inPath){
        return $this->render("tag/area_left.html");
    }
    
    public function pageEntry(){
        $list = $this->userTagModel->getData(array("type"=>2));
        $this->assign('tags',$list);
        return $this->render("tag/area_entry.html");
    }
    public function pageEdit(){
        if(isset($_GET['id']) && $_GET['id']>0){
            $data = $this->userTagModel->getData(array('id'=>$_GET['id']));
            if(isset($data[0]['id'])&&$data[0]['id']>0){
                $areaTag = $data[0];
                $area_center = json_decode($areaTag['area_center'],true);
                if(! ( is_array($area_center) && isset($area_center['lng']) && isset($area_center['lat']) ) ){
                    unset($areaTag['area_center']);
                }
                $area_info = json_decode($areaTag['area_info'],true);
                if(! (is_array($area_info[0]) && isset($area_info[0]['type']))){
                    unset($areaTag['area_info']);
                }
                $this->assign("areaTag",$areaTag);
            }
        }
        //print_r($area_info);
        //print_r($areaTag);
        return $this->render("tag/area_edit.html");
    }
    public function pageSave(){
        $data = array();
        $response = array();
        if(isset($_POST['name']) && strlen($_POST['name'])>0){
            $data['creator_id'] = user_api::id();
            $data['mtime'] = time();
            $data['name'] = $_POST['name'];
            $data['type'] = 2;
            $data['area_center'] = $_POST['area_center'];
            $data['area_info'] = $_POST['area_info'];
            $data['area_valid_time'] = $_POST['area_valid_time'];
            
            if(isset($_POST['id']) && $_POST['id']>0){
                $result = $this->userTagModel->updateData($data,array("id"=>$_POST['id']));
                if($result > 0){
                    $response['status'] = 1;
                    $response['id'] = $_POST['id'];
                    $response['msg'] = "成功更新".$result."条信息";
                }else{
                    $response['status'] = 0;
                    $response['msg'] = "注意：没有数据被更新";
                }
            }else{
                $data['ctime'] = time();
                $result = $this->userTagModel->addData($data);
                if($result > 0){
                    $response['status'] = 1;
                    $response['id'] = $result;
                    $response['msg'] = "保存成功";
                }else{
                    $response['status'] = 0;
                    $response['msg'] = "失败：保存时出错";
                }
            }
            
        }else{
            $response['status'] = 0;
            $response['msg'] = "数据错误：请检查是否未填写名称";
        }
        echo json_encode($response);
    }
    public function pageMap(){
        return $this->render("tag/area_map.html");
    }
    public function pageMap2(){
        return $this->render("tag/area_map_2.html");
    }
}
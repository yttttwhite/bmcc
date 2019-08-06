<?php
class dpc_manage extends STpl{
    public static $conn;
    public static $db;
    public static $collection;
    public $mongoModel, $mongoName;

    function __construct($inPath){
        if(!user_api::auth("dpc") && !user_api::auth("dpcRule")){
            $this->success("没有权限",'/baichuan_advertisement_manage/user',3);
            exit();
        }
        
        $this->init();
    }
    
    public function init(){
        $this->mongoModel = new model_Mongo();
        $this->mongoName = 0;
        //获取MongoDB的名称，GET值优先
        if(isset($_GET['mongo'])){
            $this->mongoName = $_GET['mongo'];
        }elseif(isset($_GET['PATH_INFO'])){
            $mongoList = $this->mongoModel->getCollectionNames();
            $pathInfo = explode(".", $_GET['PATH_INFO']);
            foreach ($pathInfo as $param){
                if(in_array($param, $mongoList)){
                    $this->mongoName = $param;
                }
            }
        }
        if($this->mongoName===0){
            $this->pageMogoList();
        }else{
            $this->mongoModel->init($this->mongoName);
            $this->assign('get',$_GET);
            $this->assign('post',$_POST);
        }
    }
    
    public function pageEntry($inPath){
    }
    
    public function pageMogoList(){
        $mongoList = $this->mongoModel->getCollectionNames();
        
        $display = array();
        $display[] = 'zhejiang_telecom';
        $display[] = 'zhejiang_telecom_4g';
        if(count($display)>0 && strpos($_SERVER['HTTP_HOST'], '115.239.138.137')!==false){
            foreach ($mongoList as $key=>$value){
                if(!in_array($value, $display)){
                    unset($mongoList[$key]);
                }
            }
        }
        
        $this->assign("mongoList",$mongoList);
        return $this->render("/dpc/mongo_list.html");
    }
    
    public function pageLeft(){
        $this->mongoName;
        $this->assign('mongo',$this->mongoName);
        return $this->render("/dpc/manage_left.html");
    }
    
    public function pageAdslList(){
        $url = array();
        $get = parent::unsetGet(array('key','page'));
        $url['search'] = parent::setGet("/baichuan_advertisement_manage/dpc.manage.adsllist", $get);
        $exportGet = $get;
        $exportGet['export'] = 1;
        $url['export'] = parent::setGet("/baichuan_advertisement_manage/dpc.manage.adsllist", $exportGet);
        
        $condition = array();
        if( isset($_GET['key']) && strlen($_GET['key'])>0 ){
            $regex = new MongoRegex("/".$_GET['key']."/");
            $condition['keyword'] = $regex;
        }
        $condition['command'] = 'adsl_config';
        
        if(isset($_GET['type']) && $_GET['type']==1){
            $title="ADSL黑名单";
            $condition['value'] = '1';
        }elseif(isset($_GET['type']) && $_GET['type']==2){
            $title="ADSL白名单";
            $condition['value'] = '2';
        }else{
            $title="其它";
            $condition['value'] = $_GET['type'];
        }
        
        if(isset($_GET['export']) && strlen($_GET['export'])==1){
            $list = $this->mongoModel->getData($condition,0,0);
            
            $filename = $title;
            header("Content-type:application/octet-stream");
            header("Accept-Ranges:bytes");
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=".$filename.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            
            $outPut = "";
            //表头
            $outPut .= "ID\tADSL\t类型\t操作人\t操作时间\t\n";
            
            //表内容
            $lineId = 1;
            foreach ($list as $line){
                $temp = str_ireplace(array("\r\n","\n","\r"), "", $line['keyword']);
                $outPut .= $lineId."\t".$temp."\t".$line['value']."\t".$line['author']."\t".date('Y-m-d H:i:s',$line['uptime'])."\t\n";
                $lineId++;
            }
            echo $outPut;
        }else{
            //分页查询开始
            $page = array();
            $perpage = 50;
            $count = $this->mongoModel->getCount($condition);
            $page['count'] = ceil($count/$perpage);
            if(isset($_GET['page'])){
                $page['current'] = $_GET['page'];
            }else{
                $page['current'] = 1;
            }
            $get = parent::unsetGet('page');
            $page['url'] = parent::setGet("/baichuan_advertisement_manage/dpc.manage.adsllist", $get);
            
            $order = array("uptime"=>-1);
            $list = $this->mongoModel->getData($condition, ($page['current']-1)*$perpage,$perpage,$order);
            //分页查询结束
            $this->assign("collection",$_GET['mongo']);
            $this->assign('url',$url);
            $this->assign('page',$page);
            $this->assign('title',$title);
            $this->assign('list',$list);
            return $this->render("/dpc/adsl_list.html");
        } 
    }
    
    public function pageAdslAdd(){
        if(isset($_POST['type']) && isset($_POST['content'])){
            $content = $_POST['content'];
            $content = str_ireplace(array("\r\n","\r"), "\n", $content);
            $adslList = explode("\n", $content);
            
            $addResult = array();
            foreach ($adslList as $adsl){
                if(strlen($adsl)>0){
                    $condition = array();
                    $data = array();
                    
                    $data['command'] = $condition['command'] = 'adsl_config';
                    $data['keyword'] = $condition['keyword'] = $adsl;
                    
                    $data['value'] = $_POST['type'];
                    $data['uptime'] = time();
                    $data['author'] = user_api::name();
                    $result = $this->mongoModel->addData($data,$condition);
                    if($result < 0){
                        $addResult['exist'][] = $condition['keyword'];
                    }else{
                        $addResult['success'][] = $condition['keyword'];
                    }
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/adsl_add_result.html");
        }else{
            echo "没有请求数据";
        }
    }
    
    public function pageAdslAddIframe(){
        $url['formAction'] = "/baichuan_advertisement_manage/dpc.manage.Adsladd?mongo=".$this->mongoName;
        $this->assign('url',$url);
        return $this->render("/dpc/adsl_add_iframe.html");
    }
    
    public function pageJsList(){
        $url = array();
        $get = parent::unsetGet(array('key','page'));
        $url['search'] = parent::setGet("/baichuan_advertisement_manage/dpc.manage.jslist", $get);
        $title = "JS黑名单";
        $exportGet = $get;
        $exportGet['export'] = 1;
        $url['export'] = parent::setGet("/baichuan_advertisement_manage/dpc.manage.jslist", $exportGet);
    
        $condition = array();
        if( isset($_GET['key']) && strlen($_GET['key'])>0 ){
            $regex = new MongoRegex("/".$_GET['key']."/");
            $condition['keyword'] = $regex;
        }
        $condition['command'] = 'js_url_black';
    
        //分页查询开始
        $page = array();
        $perpage = 50;
        $count = $this->mongoModel->getCount($condition);
        $page['count'] = ceil($count/$perpage);
        if(isset($_GET['page'])){
            $page['current'] = $_GET['page'];
        }else{
            $page['current'] = 1;
        }
        $get = parent::unsetGet('page');
        $page['url'] = parent::setGet("/baichuan_advertisement_manage/dpc.manage.jslist", $get);

        $order = array("uptime"=>-1);
        $list = $this->mongoModel->getData($condition, ($page['current']-1)*$perpage,$perpage,$order);
        //分页查询结束
        $this->assign("collection",$_GET['mongo']);
        $this->assign('url',$url);
        $this->assign('page',$page);
        $this->assign('title',$title);
        $this->assign('list',$list);
        return $this->render("/dpc/js_list.html");
    }
    
    public function pageJsAddIframe(){
        $url['formAction'] = "/baichuan_advertisement_manage/dpc.manage.jsadd?mongo=".$this->mongoName;
        $this->assign('url',$url);
        return $this->render("/dpc/js_add_iframe.html");
    }
    
    public function pageJsAdd(){
        if(isset($_POST['content']) && strlen($_POST['content'])>0){
            $content = $_POST['content'];
            $content = str_ireplace(array("\r\n","\r"), "\n", $content);
            $jsList = explode("\n", $content);
    
            $addResult = array();
            foreach ($jsList as $js){
                if(strlen($js)>0){
                    $condition = array();
                    $data = array();
    
                    $data['command'] = $condition['command'] = 'js_url_black';
                    $data['keyword'] = $condition['keyword'] = $js;
    
                    $data['uptime'] = time();
                    $data['author'] = user_api::name();
                    $result = $this->mongoModel->addData($data,$condition);
                    if($result < 0){
                        $addResult['exist'][] = $condition['keyword'];
                    }else{
                        $addResult['success'][] = $condition['keyword'];
                    }
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/js_add_result.html");
        }else{
            echo "没有请求数据";
        }
    }
    
    function pageDelete(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $condition=array(
                '_id' => new MongoId($id),
            );
            $count = $this->mongoModel->getCount($condition);
            if($count > 0)
            {
                $result = $this->mongoModel->deleteData($condition);
                if($result > -1)
                {
                    echo "HOST数据删除成功";
                }
            }else{
                echo "没有请求数据";
            }
        }else{
            echo "参数不能为空";
        }
    }
    
    public function pageDomainGroup(){
        $condition = array();
        $condition['table'] = "domain_group";
        $list = $this->mongoModel->getData($condition);
        $this->assign('list',$list);
        $this->assign('mongo',$this->mongoName);
        return $this->render("/dpc/domain_group_list.html");
    }
    function pageDeleteDomainGroup(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $condition=array(
                'table'=>'domain_group',
                '_id' => new MongoId($id),
            );
            $count = $this->mongoModel->getCount($condition);
            if($count > 0)
            {
                $result = $this->mongoModel->deleteData($condition);
                if($result > -1)
                {
                    echo "HOST数据删除成功";
                }
            }else{
                echo "没有请求数据";
            }
            
            $condition = array(
                'table'=>'domain_rule',
                'group_id' => $id,
            );
            $result = $this->mongoModel->deleteData($condition);
        }else{
            echo "参数不能为空";
        }
    }
    public function pageAddDomainGroup(){
        $error="";
        if(isset($_POST['name'])){
            $condition = array();
            $condition['table'] = 'domain_group';
            $condition['name'] = $_POST['name'];
            $condition['uid'] = user_api::id();
            $count = $this->mongoModel->getCount($condition);
            if($count>0){
                $error = "名称已经存在，请修改.";
                $this->assign('post',$_POST);
                $this->assign('error',$error);
            }else{
                $data = array();
                $data['table'] = 'domain_group';
                $data['name'] = $_POST['name'];
                $data['status'] = $_POST['status'];
                $data['uid'] = user_api::id();
                $data['uname'] = user_api::name();
                $data['time'] = time();
                $this->mongoModel->addData($data);
                $this->parentReload();
                exit();
            }
        }
        $url['action'] = "/baichuan_advertisement_manage/dpc.manage.AddDomainGroup?mongo=".$this->mongoName;
        $this->assign('url',$url);
        return $this->render('/dpc/domain_group_add_iframe.html');
    }
    
    public function pageDomainRule(){
        $url = array();
        $get = parent::unsetGet(array('key','page'));
        $url['search'] = parent::setGet("/baichuan_advertisement_manage/dpc.manage.domainrule.".$this->mongoName, $get);
        
        if(isset($_GET['group_id'])){
            $condition = array();
            $condition['table'] = "domain_rule";
            $condition['group_id'] = $_GET['group_id'];
            
            if( isset($_GET['key']) && strlen($_GET['key'])>0 ){
                $regex = new MongoRegex("/".$_GET['key']."/");
                $condition['domain'] = $regex;
            }
            //分页查询开始
            $page = array();
            if(isset($_GET['perpage']) && is_numeric($_GET['perpage'])){
                $perpage = $_GET['perpage'];
            }else{
                $perpage = 50;
            }
            
            $count = $this->mongoModel->getCount($condition);
            $page['count'] = ceil($count/$perpage);
            if(isset($_GET['page'])){
                $page['current'] = $_GET['page'];
            }else{
                $page['current'] = 1;
            }
            $get = parent::unsetGet('page');
            $page['url'] = parent::setGet("/baichuan_advertisement_manage/dpc.manage.domainrule.".$this->mongoName, $get);
            
            $order = array("domain"=>1);
            $list = $this->mongoModel->getData($condition, ($page['current']-1)*$perpage,$perpage,$order);
            
            $this->assign('url',$url);
            $this->assign('page',$page);
            $this->assign('list',$list);
            $this->assign('mongo',$this->mongoName);
            return $this->render("/dpc/domain_rule_list.html");
        }
    }
    public function pageAddDomainRule(){
        $uid = user_api::id();
        if(isset($_POST['group']) && isset($_POST['rule'])){
            $ruleStr = $_POST['rule'];
            $ruleStr = str_ireplace(array("\r\n","<br>","</br>",","," "), "\n", $ruleStr);
            $rules = explode("\n", $ruleStr);
            
            foreach ($rules as $rule){
                $data = array();
                $data['table'] = "domain_rule";
                $data['group_id'] = $_POST['group'];
                $data['rule'] = $rule;
                $data['domain'] = model_lib::getDomain($rule);
                $this->mongoModel->addData($data,$data);
            }
            $this->parentReload();
            exit();
        }else{
            $condition = array();
            $condition['table'] = "domain_group";
            $groups = $this->mongoModel->getData($condition);
            $url['action'] = "/baichuan_advertisement_manage/dpc.manage.AddDomainRule?mongo=".$this->mongoName;
            $this->assign('url',$url);
            $this->assign('groups',$groups);
            return $this->render('/dpc/domain_rule_add_iframe.html');
        }
    }
}

/*
//ADSL黑白名单，1：黑名单；2：白名单
"command": "adsl_config",
"value": "1",
"keyword": "www.baidu.com",
"author": "admin",
"uptime": NumberLong(1429002782)
 */
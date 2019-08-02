<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/2
 * Time: 11:24
 */

class dpc_ip extends STpl{
    public static $conn;
    public static $db;
    public static $collection;
    public $mongoModel, $mogoName;

    function __construct(){
        $this->init();
    }

    public function init(){
        $this->mongoModel = new model_Mongo();
        $this->mogoName = 0;
        //获取MongoDB的名称，GET值优先
        if(isset($_GET['mongo'])){
            $this->mogoName = $_GET['mongo'];
        }elseif(isset($_GET['PATH_INFO'])){
            $mongoList = $this->mongoModel->getCollectionNames();
            $pathInfo = explode(".", $_GET['PATH_INFO']);
            foreach ($pathInfo as $param){
                if(in_array($param, $mongoList)){
                    $this->mogoName = $param;
                }
            }
        }
        if($this->mogoName===0){
            $this->pageMogoList();
        }else{
            $this->mongoModel->init($this->mogoName);
            $this->assign('get',$_GET);
            $this->assign('post',$_POST);
        }
    }

    //更新mongodb中对应信息
    public function UpdateData($condition,$newdata)
    {
        $Result = self::$collection->update($condition,array('$set'=>$newdata));
        $this->updateFlag(self::$collection);
        return $Result;
    }

    public function pageMogoList(){
        $mongoList = $this->mongoModel->getCollectionNames();

        $display = array('zhejiang_telecom');
        if(count($display)>0){
            foreach ($mongoList as $key=>$value){
                if(!in_array($value, $display)){
                    unset($mongoList[$key]);
                }
            }
        }

        $this->assign("mongoList",$mongoList);
        return $this->render("/dpc/mongo_list.html");
    }

    //IP分组列表
    public function pageIpGroupList(){
        $url = array();
        $get = parent::unsetGet(array('key','page'));
        $url['search'] = parent::setGet("/baichuan_advertisement_manage/dpc.ip.ipgrouplist", $get);

        $condition = array();
        if( isset($_GET['key']) && strlen($_GET['key'])>0 ){
            $regex = new MongoRegex("/".$_GET['key']."/");
            $condition['keyword'] = $regex;
        }
        $condition['command'] = 'ia_user_black';

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
        $page['url'] = parent::setGet("/baichuan_advertisement_manage/dpc.ip.ipgrouplist", $get);

        $order = array("uptime"=>-1);
        $list = $this->mongoModel->getData($condition, ($page['current']-1)*$perpage,$perpage,$order);
        //分页查询结束

        $this->assign('url',$url);
        $this->assign('page',$page);
        $this->assign('list',$list);
        return $this->render("/dpc/ip_group_list.html");
    }

    //添加分组
    public function pageIpGroupAdd(){
        if(isset($_POST['content'])){
            $content = trim($_POST['content']);
            $ipgroup = $content;

            $addResult = array();
            if(strlen($ipgroup)>0){
                $condition = array();
                $data = array();

                $data['command'] = $condition['command'] = 'ia_user_black';
                $data['keyword'] = $condition['keyword'] = $ipgroup;

               // $data['uptime'] = time();
                $result = $this->mongoModel->addData($data,$condition);
                if($result < 0){
                    $addResult['exist'][] = $condition['keyword'];
                }else{
                    $addResult['success'][] = $condition['keyword'];
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/ipgroup_add_result.html");
        }else{
            echo "没有请求数据";
        }
    }

    public function pageIpGroupAddIframe(){
        $url['formAction'] = "/baichuan_advertisement_manage/dpc.ip.IpGroupadd?mongo=".$this->mogoName;
        $this->assign('url',$url);
        return $this->render("/dpc/ipgroup_add_iframe.html");
    }

    //编辑分组
    public function pageIpGroupEdit(){
       /* if(isset($_POST['content']) && isset($_POST['groupid'])){
            $content = trim($_POST['content']);
            $ipgroup = $content;

            if(strlen($ipgroup)>0){
                $condition = array();
                $data = array();

                $condition['_id'] = new MongoId(trim($_POST['groupid']));
                $data['command'] = $condition['command'] = 'ia_user_black';
                $data['keyword'] = $ipgroup;

                $data['uptime'] = time();
                $result = $this->UpdateData($condition,$data);
                if($result < 0){
                    $addResult['exist'][] = $condition['keyword'];
                }else{
                    $addResult['success'][] = $condition['keyword'];
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/ipgroup_edit_result.html");
        }else{
            echo "没有请求数据";
        }*/
    }

    public function pageIpGroupEditIframe(){
       /* $url['formAction'] = "/dpc.ip.IpGroupedit?mongo=".$this->mogoName;
        $this->assign('url',$url);
        return $this->render("/dpc/ipgroup_edit_iframe.html");

        if(isset($_GET['id'])){
            $item['id'] = trim($_GET['id']);

            //获取原记录信息
            $condition=array(
                '_id' => new MongoId($item['id']),
            );
            $count = $this->mongoModel->getCount($condition);
            if($count > 0)
            {
                $result = $this->mongoModel->getData($condition,0,1,0);
                $item['text'] = $result[$item['id']]['keyword'];
                //记
                $url['formAction'] = "/dpc.ip.ipgroupedit?mongo=".$this->mogoName;
                $this->assign('url',$url);
                $this->assign('item',$item);
                return $this->render("/dpc/url_edit_iframe.html");
            }else{
                echo "没有请求数据";
            }
        }else{
            echo "参数不能为空";
        }*/
    }

    //delete host_black or host_white
    function pageIpGroupDel(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $condition=array(
                '_id' => new MongoId($id),
            );
            //$count = $this->mongoModel->getCount($condition);
            $gresult = $this->mongoModel->getData($condition,0,1,0);
            $count = count($gresult);
            if($count > 0)
            {
                //是否有对应IP黑名单
                $ipcondition['command'] = "region_ip";
                $regex = new MongoRegex("/".$gresult[$id]['gname']."$/");
                $ipcondition['keyword'] = $regex;
                $ipcount = $this->mongoModel->getCount($condition);
                if($ipcount > 0)
                {
                    echo "请先删除该组的IP黑名单";
                }else {
                    $result = $this->mongoModel->deleteData($condition);
                    if($result > -1)
                    {
                        echo "分组数据删除成功";
                    }
                }
            }else{
                echo "没有请求数据";
            }
        }else{
            echo "参数不能为空";
        }
    }

    //IP分组列表
    public function pageIpList(){
        $url = array();
        $get = parent::unsetGet(array('key','page'));
        $url['search'] = parent::setGet("/baichuan_advertisement_manage/dpc.ip.iplist", $get);

        $condition = array();
        if( isset($_GET['gid']) && strlen($_GET['gid'])>0 && isset($_GET['gname']) && strlen($_GET['gname'])>0){
            //获取对应的组信息
            $conditiong=array(
                '_id' => new MongoId($_GET['gid']),
            );
            $gcount = $this->mongoModel->getCount($conditiong);
            if($gcount>0)
            {
                $GData = $this->mongoModel->getData($conditiong,0,1);
                $gname = $GData[$_GET['gid']]['keyword'];
                
                if( isset($_GET['key']) && strlen($_GET['key'])>0 ){
                    $regex = new MongoRegex("/".$gname."$/");
                   // $regex2 = new MongoRegex("/".$_GET['key']."/");
                    $condition['keyword'] = $regex;
                   // $condition['keyword'] = $regex2;
                }else{
                    $regex = new MongoRegex("/ ".$gname."$/");
                    $condition['keyword'] = $regex;
                }
                $condition['command'] = 'region_ip';
    
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
                $page['url'] = parent::setGet("/baichuan_advertisement_manage/dpc.ip.iplist", $get);
                //分组名称
                $page['gname'] = $_GET['gname'];
                $url['gname'] = $gname;
                $url['gid'] = $_GET['gid'];
                
                $list = $this->mongoModel->getData($condition, ($page['current']-1)*$perpage,$perpage);
                
                //var_dump($list);
                //分页查询结束
                
    
                $this->assign('url',$url);
                $this->assign('page',$page);
                $this->assign('list',$list);
                return $this->render("/dpc/ip_black_list.html");
            }else{
                echo "请确认参数是否正确";
            }
        }else{
            echo "请确认参数是否正确";
        }
    }

    public function getIpGroupByGid($dbName = 0, $gid = 0, $limit = 50){
        if($gid === 0 || $dbName === 0){
            return 0;
        }else{
            $condition = array();
            $condition['command'] = 'website_group';

            if($gid !== "all"){
                $condition['group_id'] = (string)$gid;
            }

            self::$collection = self::$db->selectCollection($dbName);
            if($limit == 0){
                $result = self::$collection->find($condition);
            }else{
                $sort = array("group_id"=>1);
                $result = self::$collection->find($condition)->limit($limit)->sort($sort);
            }
            foreach ($result as $item){
                $arrayResult[$item['group_id']] = $item;
            }
            return $arrayResult;
        }
    }

    public function pageIpAdd(){
       // if(isset($_GET['gid']) && strlen($_GET['gid'])>0 && isset($_GET['gname']) && strlen($_GET['gname'])>0){
            if(isset($_POST['gid']) && isset($_POST['gname'])  && isset($_POST['content'])){
                $content = $_POST['content'];
                $gid = $_POST['gid'];
                $gname = base64_decode($_POST['gname']);

                //对应的组是否存在
                $gcondition['command'] = "ia_user_black";
                $gcondition['_id'] = new MongoId($gid);
                $gcondition['keyword'] = $gname;
                $gcount = $this->mongoModel->getCount($gcondition);
                if($gcount>0)
                {
                    $content = str_ireplace(array("\r\n","\r"), "\n", $content);
                    $ipList = explode("\n", $content);

                    $addResult = array();
                    foreach ($ipList as $ip){
                        if(strlen($ip)>0){
                            $condition = array();
                            $data = array();

                            $data['command'] = $condition['command'] = 'region_ip';
                            $data['keyword'] = $condition['keyword'] = $ip.' '.$gname;

                            $result = $this->mongoModel->addData($data,$condition);
                            if($result < 0){
                                $addResult['exist'][] = $condition['keyword'];
                            }else{
                                $addResult['success'][] = $condition['keyword'];
                            }
                        }
                    }
                    $this->assign('addResult',$addResult);
                    return $this->render("/dpc/ip_add_result.html");
                }else{
                    echo "请求数据不正确";
                }
            }else{
                echo "没有请求数据";
            }
    }

    public function pageIpAddIframe(){
        if(isset($_GET['gid']) && strlen($_GET['gid'])>0 && isset($_GET['gname']) && strlen($_GET['gname'])>0)
        {
            $url['formAction'] = "/baichuan_advertisement_manage/dpc.ip.Ipadd?mongo=".$this->mogoName;
            $url['gid'] = $_GET['gid'];
            $url['gname'] = $_GET['gname'];
            $this->assign('url',$url);
            return $this->render("/dpc/ip_add_iframe.html");
        }else{
            echo "请确认对应的参数是否正确";
        }
    }

    public function pageIpEdit(){
        if(isset($_POST['gname']) && isset($_POST['content']) && isset($_POST['id'])){
            $content = $_POST['content'];
            $content = str_ireplace(array("\r\n","\r"), "\n", $content);
            $ipList = explode("\n", $content);

            $addResult = array();
            if(count($ipList)>0)
            {
                //删除之前数据
                $conditiondel=array(
                    '_id' => new MongoId(trim($_POST['id'])),
                    'command' => 'region_ip',
                );
                $result = $this->mongoModel->deleteData($conditiondel);
            }
  
            foreach ($ipList as $ip){
                if(strlen($ip)>0){
                    $condition = array();
                    $data = array();

                    $data['command'] = $condition['command'] = 'region_ip';
                    $data['keyword'] = $condition['keyword'] = $ip.' '.base64_decode($_POST['gname']);

                    $result = $this->mongoModel->addData($data,$condition);
                    if($result < 0){
                        $addResult['exist'][] = $condition['keyword'];
                    }else{
                        $addResult['success'][] = $condition['keyword'];
                    }
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/ip_edit_result.html");
        }else{
            echo "没有请求数据";
        }
    }

    public function pageIpEditIframe(){
        //记录ID
        $id = "";
        if(isset($_GET['id'])){
            $item['id'] = trim($_GET['id']);

            //获取原记录信息
            $condition=array(
                '_id' => new MongoId($item['id']),
            );

            $result = $this->mongoModel->getData($condition,0,1,0);
            if(count($result) > 0)
            {
                $item['text'] = $result[$item['id']]['keyword'];
                $glen = strlen($item['text']);
                $gpos = strrpos($item['text']," ");
                $gname = substr($item['text'],($gpos+1),($glen-$gpos));
                $item['text'] = substr($item['text'], 0,$gpos);

                //获取对应分组信息
                $conditiong = array(
                    'command' => "ia_user_black",
                    'keyword' => $gname,
                );
                $GData = $this->mongoModel->getData($conditiong);
                if(count($GData)>0)
                {
                    $item['gname'] = base64_encode($gname);
                }
                $url['formAction'] = "/baichuan_advertisement_manage/dpc.ip.IpEdit?mongo=".$this->mogoName;
                $this->assign('url',$url);
                $this->assign('item',$item);
                return $this->render("/dpc/ip_edit_iframe.html");
            }else{
                echo "没有请求数据";
            }
        }else{
            echo "参数不能为空";
        }
    }

    //delete host_black or host_white
    function pageIpDel(){
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
                    echo "IP数据删除成功";
                }
            }else{
                echo "没有请求数据";
            }
        }else{
            echo "参数不能为空";
        }
    }
}
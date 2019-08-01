<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/22
 * Time: 10:15
 */
/*
//host黑白名单
"command": "host_black",黑名单;"host_white":白名单
"keyword": "www.baidu.com",
"uptime": NumberLong(1429002782)
 */
class dpc_host extends STpl {
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
    
    public function pageHostList(){
        $url = array();
        $get = parent::unsetGet(array('key','page'));
        $url['search'] = parent::setGet("/dpc.host.hostlist", $get);

        $condition = array();
        if( isset($_GET['key']) && strlen($_GET['key'])>0 ){
            $regex = new MongoRegex("/".$_GET['key']."/");
            $condition['keyword'] = $regex;
        }
        //$condition['command'] = 'host_config';

        if(isset($_GET['type']) && $_GET['type']==1){
            $title="Host黑名单";
            //$condition['value'] = '1';
            $condition['command'] = 'host_black';
        }else{
            $title="Host白名单";
            //$condition['value'] = '2';
            $condition['command'] = 'host_white';
        }

        if(isset($_GET['export']) && strlen($_GET['export'])==1){
            $condition['command'] = 'host_black';
            $list = $this->mongoModel->getData($condition,0,0);
            $condition['command'] = 'host_white';
            $list2 = $this->mongoModel->getData($condition,0,0);
            $list = array_merge($list,$list2);
            $filename = $title;
            header("Content-type:application/octet-stream");
            header("Accept-Ranges:bytes");
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=".$filename.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
        
            $outPut = "";
            //表头
            $outPut .= "ID\tHOST\t类型\t操作时间\t\n";
        
            //表内容
            $lineId = 1;
            foreach ($list as $line){
                $temp = str_ireplace(array("\r\n","\n","\r"), "", $line['keyword']);
                $outPut .= $lineId."\t".$temp."\t".$line['command']."\t".date('Y-m-d H:i:s',$line['uptime'])."\t\n";
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
            $page['url'] = parent::setGet("/dpc.host.hostlist", $get);
            
            $order = array("uptime"=>-1);
            $list = $this->mongoModel->getData($condition, ($page['current']-1)*$perpage,$perpage,$order);
            //分页查询结束
            
            $this->assign('url',$url);
            $this->assign('page',$page);
            $this->assign('title',$title);
            $this->assign('list',$list);
            return $this->render("/dpc/host_black_list.html");
        }
    }

    public function pageHostAdd(){
        if(isset($_POST['type']) && isset($_POST['content'])){
            $content = $_POST['content'];
            $content = str_ireplace(array("\r\n","\r"), "\n", $content);
            $hostList = explode("\n", $content);

            $addResult = array();
            $hosttype = ($_POST['type']=='1')?'host_black':'host_white';
            foreach ($hostList as $host){
                if(strlen($host)>0){
                    $condition = array();
                    $data = array();

                    $data['command'] = $condition['command'] = $hosttype;
                    $data['keyword'] = $condition['keyword'] = $host;

                    $data['uptime'] = time();
                    $result = $this->mongoModel->addData($data,$condition);
                    if($result < 0){
                        $addResult['exist'][] = $condition['keyword'];
                    }else{
                        $addResult['success'][] = $condition['keyword'];
                    }
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/host_add_result.html");
        }else{
            echo "没有请求数据";
        }
    }

    public function pageHostAddIframe(){
        $url['formAction'] = "/dpc.host.Hostadd?mongo=".$this->mogoName;
        $this->assign('url',$url);
        return $this->render("/dpc/host_add_iframe.html");
    }

    public function pageHostEditIframe(){
        //记录ID
        $id = "";
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
                $item['typetext'] = $result[$item['id']]['command']=='host_black'?'HOST黑名单':'HOST名白单';
                $item['type'] = $result[$item['id']]['command']=='host_black'?'1':'2';
                //记
                $url['formAction'] = "/dpc.host.Hostupdate?mongo=".$this->mogoName;
                $this->assign('url',$url);
                $this->assign('item',$item);
                return $this->render("/dpc/host_edit_iframe.html");
            }else{
                echo "没有请求数据";
            }
        }else{
            echo "参数不能为空";
        }
    }

    //update host_black or host_white
    function pageHostUpdate($command_name="host_black",$host=""){
        if(isset($_POST['type']) && isset($_POST['content']) && isset($_POST['id'])){
            $content = $_POST['content'];
            $content = str_ireplace(array("\r\n","\r"), "\n", $content);
            $hostList = explode("\n", $content);
			$oldtype = ($_POST['oldtype']=='1')?'host_black':'host_white';

            $addResult = array();
            $hosttype = ($_POST['type']=='1')?'host_black':'host_white';
            if(count($hostList)>0)
            {
                //删除之前数据
                $condition=array(
                    '_id' => new MongoId(trim($_POST['id'])),
                    'command' => $oldtype,
                );
                $result = $this->mongoModel->deleteData($condition);
            }
            foreach ($hostList as $host){
                if(strlen($host)>0){
                    $condition = array();
                    $data = array();

                    $data['command'] = $condition['command'] = $hosttype;
                    $data['keyword'] = $condition['keyword'] = $host;

                    $data['uptime'] = time();
                    $result = $this->mongoModel->addData($data,$condition);
                    if($result < 0){
                        $addResult['exist'][] = $condition['keyword'];
                    }else{
                        $addResult['success'][] = $condition['keyword'];
                    }
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/host_edit_result.html");
        }else{
            echo "没有请求数据";
        }
    }

    //delete host_black or host_white
    function pageHostDel(){
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
}
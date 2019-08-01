<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/26
 * Time: 0:00
 */
/*
//url黑白名单
"command": "url_black",黑名单;"url_white":白名单
"keyword": "www.baidu.com",
"uptime": NumberLong(1429002782)
 */

class dpc_url extends STpl {
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

    public function pageUrlList(){
        $url = array();
        $get = parent::unsetGet(array('key','page'));
        $url['search'] = parent::setGet("/dpc.url.urllist", $get);

        $condition = array();
        if( isset($_GET['key']) && strlen($_GET['key'])>0 ){
            $regex = new MongoRegex("/".$_GET['key']."/");
            $condition['keyword'] = $regex;
        }
        //$condition['command'] = 'host_config';

        if(isset($_GET['type']) && $_GET['type']==1){
            $title="URL黑名单";
            //$condition['value'] = '1';
            $condition['command'] = 'url_black';
        }else{
            $title="URL白名单";
            //$condition['value'] = '2';
            $condition['command'] = 'url_white';
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
            $outPut .= "ID\tURL\t\n";
        
            //表内容
            $lineId = 1;
            foreach ($list as $line){
                $temp = str_ireplace(array("\r\n","\n","\r"), "", $line['keyword']);
                $outPut .= $lineId."\t".$temp."\t\n";
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
            $page['url'] = parent::setGet("/dpc.url.urllist", $get);
            
            $order = array("_id"=>-1);
            $list = $this->mongoModel->getData($condition, ($page['current']-1)*$perpage,$perpage,$order);
            //分页查询结束
            
            $this->assign('url',$url);
            $this->assign('page',$page);
            $this->assign('title',$title);
            $this->assign('list',$list);
            return $this->render("/dpc/url_list.html");
        }
    }

    public function pageUrlAdd(){
        if(isset($_POST['type']) && isset($_POST['content'])){
            $content = $_POST['content'];
            $content = str_ireplace(array("\r\n","\r"), "\n", $content);
            $urlList = explode("\n", $content);

            $addResult = array();
            $urltype = ($_POST['type']=='1')?'url_black':'url_white';
            foreach ($urlList as $host){
                if(strlen($host)>0){
                    $condition = array();
                    $data = array();

                    $data['command'] = $condition['command'] = $urltype;
                    $data['keyword'] = $condition['keyword'] = $host;

                    //$data['uptime'] = time();
                    $result = $this->mongoModel->addData($data,$condition);
                    if($result < 0){
                        $addResult['exist'][] = $condition['keyword'];
                    }else{
                        $addResult['success'][] = $condition['keyword'];
                    }
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/url_add_result.html");
        }else{
            echo "没有请求数据";
        }
    }

    public function pageUrlAddIframe(){
        $url['formAction'] = "/dpc.url.Urladd?mongo=".$this->mogoName;
        $url['type'] = "";
        $this->assign('url',$url);
        return $this->render("/dpc/url_add_iframe.html");
    }

    public function pageUrlEditIframe(){
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
                $item['typetext'] = $result[$item['id']]['command']=='url_black'?'URL黑名单':'URL白名单';
                $item['type'] = $result[$item['id']]['command']=='url_black'?'1':'2';
                //记
                $url['formAction'] = "/dpc.url.Urlupdate?mongo=".$this->mogoName;
                $this->assign('url',$url);
                $this->assign('item',$item);
                return $this->render("/dpc/url_edit_iframe.html");
            }else{
                echo "没有请求数据";
            }
        }else{
            echo "参数不能为空";
        }
    }

    //update host_black or host_white
    function pageUrlUpdate($command_name="url_black",$host=""){
        if(isset($_POST['type']) && isset($_POST['content']) && isset($_POST['id'])){
            $content = $_POST['content'];
            $content = str_ireplace(array("\r\n","\r"), "\n", $content);
            $urlList = explode("\n", $content);
			$oldtype = ($_POST['oldtype']=='1')?'url_black':'url_white';

            $addResult = array();
            $urltype = ($_POST['type']=='1')?'url_black':'url_white';
            if(count($urlList)>0)
            {
                //删除之前数据
                $condition=array(
                    '_id' => new MongoId(trim($_POST['id'])),
                    'command' => $oldtype,
                );
                $result = $this->mongoModel->deleteData($condition);
            }
            foreach ($urlList as $host){
                if(strlen($host)>0){
                    $condition = array();
                    $data = array();

                    $data['command'] = $condition['command'] = $urltype;
                    $data['keyword'] = $condition['keyword'] = $host;

                   // $data['uptime'] = time();
                    $result = $this->mongoModel->addData($data,$condition);
                    if($result < 0){
                        $addResult['exist'][] = $condition['keyword'];
                    }else{
                        $addResult['success'][] = $condition['keyword'];
                    }
                }
            }
            $this->assign('addResult',$addResult);
            return $this->render("/dpc/url_edit_result.html");
        }else{
            echo "没有请求数据";
        }
    }

    //delete host_black or host_white
    function pageUrlDel(){
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
                    echo "URL数据删除成功";
                }
            }else{
                echo "没有请求数据";
            }
        }else{
            echo "参数不能为空";
        }
    }
}
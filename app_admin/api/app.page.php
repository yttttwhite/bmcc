<?php
class api_app extends STpl{
    private $bigData, $uid, $tag, $updateTime, $rootTags, $parentLeafCount;
    public function __construct($inPath){
        
        $this->init();
    }
    
    public function init(){
        $this->uid = user_api::id();
        $this->bigData = new bigdata_rmc();
        $this->tag = $this->bigData->getTagsByLevel("all",true);
        $this->rootTags = $this->bigData->getTagsByPid(0);
        $this->updateTime = $this->bigData->getLatestReportDate();
        $this->parentLeafCount = $this->getLeftCountArray();
    }
    //登录
    public function pageLogin(){
        $response = array();
        $response['status'] = 0;
        if(isset($_POST['userName']) && isset($_POST['passWord'])){
            $name = $_POST['userName'];
            $pass = $_POST['passWord'];
            $user = user_api::getUserByName($name);
            if($user->uid <= 0){
                $response['msg'] = "用户名或者密码错误";
            }else{
                if(md5($pass) === $user->passwd){
                    $response['status'] = 1;
                    $response['token'] = $this->createToke();
                    $response['msg'] = "登录成功";
                }else{
                    $response['msg'] = "用户名或者密码错误";
                }
            }
        }elseif(isset($_GET['userName'])){
            $response['msg'] = "你这是用GET方法发的请求吧？";
        }else{
            $response['msg'] = "请输入用户名及密码";
        }
        echo json_encode($response);
    }
    //创建TOKEN
    private function createToke(){
        $num =  rand(100000, 9990000);
        $str = sha1($num);
        $num =  rand(100000, 9990000);
        $str = $str.sha1($num);
        $strArray = str_split($str);
        $count = count($strArray);
        $token = '';
        for ($i=0;$i<20;$i++){
            $temp = rand(100,1000);
            $token .= $strArray[$temp%$count];
        }
        return sha1($token);
    }
    //通过父ID获取子标签
    public function pageGetTagByPid(){
        $response = array();
        $response['status'] = 1;
        
        if(isset($_REQUEST['pid'])){
            $pid = $_REQUEST['pid'];
        }else{
            $pid = 0;
        }
        if(isset($_REQUEST['relate'])){
            $relate = $_REQUEST['relate'];
        }else{
            $relate = 0;
        }
        $tag = $this->bigData->getTagsByPid($pid,$relate);
        
        $response['tags'] = $tag;
        
        echo json_encode($response);
    }
    
    //通过级别标签
    public function pageGetTagByLevel(){
        $response = array();
        $response['status'] = 1;
        
        if(isset($_REQUEST['level'])){
            $level = $_REQUEST['level'];
        }else{
            $level = 0;
        }
        if(isset($_REQUEST['relate'])){
            $relate = $_REQUEST['relate'];
        }else{
            $relate = 0;
        }
        $tag = $this->bigData->getTagsByLevel($level,$relate);
        $response['tags'] = $tag;
        
        echo json_encode($response);
    }
    
    //父标签及子标签数量
    public function getTopTagCountArray(){
        $response = array();
        $response['status'] = 1;
        
        $parentLeafCount = array();
        foreach ($this->tag as $temp){
            if($temp['pid'] > 0){
                if(isset($parentLeafCount[$temp['pid']])){
                    $parentLeafCount[$temp['pid']]++;
                }else{
                    $parentLeafCount[$temp['pid']] = 1;
                }
            }
        }
        
        $response['topTag'] = $parentLeafCount;
        
        echo json_encode($response);
    }
    //通过标签ID获取该标签人群统计
    public function pageGetSummaryByTid(){
        $response = array();
        $response['status'] = 0;
        
        
        if(isset($_REQUEST['tid'])){
            $tid = $_REQUEST['tid'];
            if(isset($_REQUEST['days'])){
                $days = $_REQUEST['days'];
            }else{
                $days = 1;
            }
            
            $report = $this->bigData->getSummaryByTag($tid,0,$days);
            $tagReport = $report[0];
            $tagReport['tname'] = $this->tag[$tagReport['tid']]['tname'];
            
            $interestInfo = explode(";", $report[0]['interest_info']);
            $interestInfo = array_filter($interestInfo);
            
            
            $response['status'] = 1;
            $response['summary'] = $interestInfo;
            $response['tname'] = $tagReport['tname'];
            
        }else{
            $response['msg'] = "请输入有效的标签ID";
        }
        
        echo json_encode($response);
    }
    
}
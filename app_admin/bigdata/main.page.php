<?php
class bigdata_main extends STpl{
    private $interestModel, $interestSummaryModel, $interestReportModel, $interestQueryModel;
    private $uid, $tag, $updateTime, $rootTags, $parentLeafCount;
    
    public function __construct($inPath){
        $this->init();
    }
    
    public function init(){
        $this->uid = user_api::id();
        
        $this->interestModel = new model_interest();
        $this->interestSummaryModel = new model_interestSummary();
        $this->interestReportModel = new model_interestReport();
        $this->interestQueryModel = new model_interestQuery();
        
        $this->tag = $this->interestModel->getTagsByLevel("all",true);
        $this->rootTags = $this->interestModel->getTagsByPid(0);
        $this->updateTime = $this->interestReportModel->getLatestReportDate();
        $this->parentLeafCount = $this->getTopTagCountArray();
        
        $color = array('3584BB','FF8C26','309F3B','C93337','8D6CBD','865D57','D47AC2','7B8286','B1B932','1DBACD');
        $this->assign('tag',$this->tag);
        $this->assign('rootTags',$this->rootTags);
        $this->assign('updateTime',$this->updateTime);
        $this->assign('chartColor',$color);
        $this->assign('get',$_GET);
        $this->assign('parentLeafCount',$this->parentLeafCount);
        
        $leafTagStruct = array();
        foreach ($this->rootTags as $pTag){
            $leafTag = $this->interestModel->getTagsByPid($pTag['tid'],true);
            if(is_array($leafTag) && count($leafTag)>0){
                $leafTagStruct[$pTag['tid']] = $leafTag;
            }
        }
        $this->assign('leafTagStruct',$leafTagStruct);
    }
    
    //获取所有有子标签的父标签
    public function getTopTagCountArray(){
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
        return $parentLeafCount;
    }
    
    public function pageEntry(){
        $this->createSummaryChart();
        $this->getTopTagsReport(24);
        //$this->createTopTenTagsReport(); //兴趣统计图，十分丑，禁用
        return $this->render("/bigdata/main.html");
    }
    
    //生成统计图表JS
    private function createSummaryChart(){
        $data1[] = 'data1';
        $data2[] = 'data2';
        $data3[] = 'data3';
        $data4[] = 'x';
        
        $summary = $this->interestSummaryModel->getSummary();
        foreach ($summary as $daySummary){
            $data1[] = $daySummary['count_user']/10000;
            $data2[] = $daySummary['count_user_tag']/10000;
            $data3[] = $daySummary['count_tag']/10000;
            $data4[] = $daySummary['uptime'];
        }
        $c3 = array();
        $c3['bindto'] = '#chartSummary';
        $c3['color']['pattern'] = array('#7AB1C6','#2FA22F','#D95F5F');
        $c3['data']['x'] = 'x';
        $c3['data']['columns'] = array($data1,$data2,$data3,$data4);
        $c3['data']['names'] = array('data1'=>'用户总数','data2'=>'命中标签用户数','data3'=>'命中标签次数');
        $c3['data']['types'] = array('data1'=>'area-spline','data2'=>'spline','data3'=>'spline');
        $c3['data']['axes'] = array('data1'=>'y','data2'=>'y','data3'=>'y2');
        $c3['axis']['y2'] = array('show','true');
        $c3['axis']['x']['type'] = 'timeseries';
        $c3['axis']['x']['tick'] = array('count'=>30, 'format'=>'%Y-%m-%d');
        $c3Srt = json_encode($c3);
        $this->assign('c3Srt',$c3Srt);
    }
    
    //获取标签报告数据
    private function getTopTagsReport($top = 20){
        $leftTag = $this->interestModel->getTagsByLevel('all',true);
        $report = $this->interestReportModel->getTopTagReport($top,$this->updateTime['tagReport']);
        foreach ($report as $index=>$item){
            $report[$index]['tname'] = $leftTag[$item['tid']]['tname'];
        }
        $this->assign('topTagsReport',$report);
    }
    
    //生成标签报告图表，图表很丑
    private function createTopTenTagsReport(){
        $leftTag = $this->interestModel->getTagsByLevel('all',true);
        $report = $this->interestReportModel->getTopTagReport(20);
        
        $c3 = array();
        foreach ($report as $item){
            $c3['data']['columns'][] = array($leftTag[$item['tid']]['tname'],$item['count']);
            //$c3['axis']['x']['categories'][] = $leftTag[$item['tid']]['tname'];
        }
        
        $c3['bindto'] = '#chartInterestRoot';
        $c3['axis']['x']['type'] = 'category';
        $c3['data']['type'] = 'bar';
        $c3['bar']['width'] = 40;
        //$c3['color']['pattern'] = array('#7AB1C6','#2FA22F','#D95F5F','#7AB1C6','#2FA22F','#D95F5F','#6ABB6A','#FECE9F','#FEA455','#C5D7EE','#619FC9','#FEB1AF','#DF9898');
        //$c3['color']['pattern'] = array('#7AB1C6');
        //$c3['axis']['rotated'] = true;
        
        $c3InterestRoot = json_encode($c3);
        $this->assign('c3InterestRoot',$c3InterestRoot);
        
        /*
         $randArray[] = '兴趣组一级标签';
         foreach ($report as $tagReport){
         $c3['axis']['x']['categories'][] = $leftTag[$tagReport['tid']]['tname'];
         $randArray[] = $tagReport['count'];
         }
         $c3['data']['columns'][] = $randArray;
         */
    }
    
    public function pageAdvancedQuery(){
        if(isset($_POST['queryType']) && in_array($_POST['queryType'], array(1,2,3))){
            $uid = user_api::id();
            $queryType = $_POST['queryType'];
            if(isset($_POST['queryName']) && strlen($_POST['queryName'])>0){
                $queryName = $_POST['queryName'];
                if(strlen($queryName)>100){
                    $queryName = substr($queryName, 0,90);
                }
            }else{
                $time = time();
                $queryName = $uid."-".$time;
            }
            
            $query = array();
            if(isset($_POST['tags'])){
                $tags = $_POST['tags'];
                $query['tags'] = $tags;
            }
            
            if(isset($_POST['key'])){
                $key = $_POST['key'];
                $key = str_replace("https://", "", $key);
                $key = str_replace("https://", "", $key);
                $key = str_replace("\r", "", $key);
                $keyArray = explode("\n", $key);
                
                $query['key'] = $keyArray;
            }
            if(isset($_POST['url'])){
                $url = $_POST['url'];
                $url = str_replace("https://", "", $url);
                $url = str_replace("https://", "", $url);
                $url = str_replace("\r", "", $url);
                $urlArray = explode("\n", $url);
                $query['url'] = $urlArray;
            }
            
            $data = array();
            $data['uid'] = $uid;
            $data['query_name'] = $queryName;
            $data['query'] = json_encode($query);
            $data['type'] = $queryType;
            
            if(isset($_POST['day']) && is_numeric($_POST['day']) && $_POST['day'] < 30){
                $data['day'] = $_POST['day'];
            }else{
                $data['day'] = 7;
            }
            $data['add_time'] = time();
            $queryId = $this->interestQueryModel->addInterestQuery($data);
        }else{
            if(isset($_GET['queryType'])){
                $queryType = $_GET['queryType'];
            }else{
                $queryType = 2;
            }
            
            if($queryType == 2 || $queryType == 3){
                $this->assign("queryType",$queryType);
                return $this->render("/bigdata/advancedKeyQuery.html");
            }else{
                $queryType = 1;
                $this->assign("queryType",$queryType);
                return $this->render("/bigdata/advancedTagQuery.html");
            }
        }
    }
    
    public function pageQueryList(){
       $queryList = $this->interestQueryModel->getQueryListByUid();
       $typeInfo = array(1=>'标签组合查询',2=>'关键字查询',3=>'URL查询');
       $statusInfo = array(0=>'处理中',1=>'已完成');
       $this->assign("typeInfo",$typeInfo);
       $this->assign("statusInfo",$statusInfo);
       $this->assign("queryList",$queryList);
       return $this->render("/bigdata/queryList.html");
    }
    
    public function pageQueryDetail(){
        if(isset($_GET['qid']) && is_numeric($_GET['qid'])){
            $typeInfo = array(1=>'标签组合查询',2=>'关键字查询',3=>'URL查询');
            $statusInfo = array(0=>'处理中',1=>'已完成');
            
            $queryInfo = $this->interestQueryModel->getQueryDetailById($_GET['qid']);
            $query = json_decode($queryInfo[0]['query'],true);
            
            $this->assign("typeInfo",$typeInfo);
            $this->assign("statusInfo",$statusInfo);
            $this->assign("queryInfo",$queryInfo[0]);
            $this->assign("query",$query);
            
            return $this->render("/bigdata/queryDetail.html");
        }else{
            
        }
    }
    
    //用于AJAX相应，用于返回指定标签的子标签
    public function pageShowSubTags(){
        if(isset($_GET['pid']) && is_numeric($_GET['pid'])){
            $tags = $this->interestModel->getTagsByPid($_GET['pid']);
            echo json_encode($tags);
        }
    }
    
    
    /*
     * 没有用的
     * */
    
    //随机添加统计
    public function addSummaryByRand(){
        exit();
        for($i = 0; $i <60; $i++){
            $currentTime = time();
            $uptime = $currentTime - ($i*60*60*24);
            $data = array();
            $data['count_user'] = rand(8000000, 12000000);
            $data['count_user_tag'] = (rand(20,80)/100)*$data['count_user'];
            $data['count_tag'] = rand(30000000, 80000000);
    
            $this->interestSummaryModel->addSummaryByDate($data,$uptime);
        }
    }
    
    //随机添加报告
    public function addReportByRand(){
        exit();
        set_time_limit(0);
        $leafTags = $this->interestModel->getTagsByLevel(2);
        for($i = 0; $i <60; $i++){
            $currentTime = time();
            $uptime = $currentTime - ($i*60*60*24);
    
            foreach ($leafTags as $tag){
                $data = array();
                $data['tid'] = $tag['tid'];
                $data['count'] = rand(100, 10000);
    
                $tempTags = $leafTags;
                $interestInfo = array();
                for ($j=0; $j<10; $j++){
                    $leafTagsCount = count($tempTags);
                    $tagIndex = rand(0, $leafTagsCount-1);
                    $tid = $tempTags[$tagIndex]['tid'];
                    unset($tempTags[$tagIndex]);
                    $count = floor($data['count']*rand(40, 100)/100);
                    $interestInfo[$tid] = $count;
                }
    
                arsort($interestInfo);
                $interestInfoStr = "";
                foreach ($interestInfo as $key=>$value){
                    $interestInfoStr .= $key.":".$value.";";
                }
    
                $data['interest_info'] = $interestInfoStr;
    
                $this->interestReportModel->addReport($data,$uptime);
            }
        }
        exit();
    }
}
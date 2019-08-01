<?php
class bigdata_tag extends STpl{
    private $interestModel, $interestSummaryModel, $interestReportModel, $interestQueryModel;
    private $bigData, $uid, $tag, $rootTags, $updateTime;
    
    public function __construct($inPath){
        $this->init();
        
        //$this->addSummaryByRand();
        //$this->addReportByRand();
        $this->getLeftCountArray();
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
    }
    
    public function pageEntry(){
        if(isset($_GET['tid']) && isset($this->tag[$_GET['tid']])){
            $tid = $_GET['tid'];
            $this->createSummaryChartByTag($tid);
            $this->getLastReportByTag($tid);
            
            $color = array('3584BB','FF8C26','309F3B','C93337','8D6CBD','865D57','D47AC2','7B8286','B1B932','1DBACD');
            $this->assign('chartColor',$color);
            
            $this->assign('rootTags',$this->rootTags);
            
            $this->assign('get',$_GET);
            $this->assign('tag',$this->tag);
            return $this->render("/bigdata/tag.html");
        }
    }
    
    //获取所有有子标签的父标签
    public function getLeftCountArray(){
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
        $this->assign('parentLeafCount',$parentLeafCount);
    }
    
    private function createSummaryChartByTag($tid = 0){
        $days = 30;
        
        $peopleSummary = $this->interestSummaryModel->getSummary();
        $propleStat = array();
        foreach ($peopleSummary as $temp){
            $propleStat[$temp['uptime']] = $temp['count_user'];
        }
        
        $summary = $this->interestReportModel->getSummaryByTag($tid,0,$days);
        
        $data1[] = $this->tag[$tid]['tname'];
        $data2[] = '网民总数';
        $dataX[] = 'x';
        foreach ($summary as $daySummary){
            $data1[] = $daySummary['count'];
            if(isset($propleStat[$daySummary['uptime']])){
                $data2[] = $propleStat[$daySummary['uptime']];
            }else{
                $data2[] = 0;
            }
            $dataX[] = $daySummary['uptime'];
        }
        $c3 = array();
        $c3['bindto'] = '#chartSummary';
        $c3['data']['x'] = 'x';
        $c3['data']['columns'] = array($data1,$data2,$dataX);
        //$c3['color']['pattern'] = array('#7AB1C6','#2FA22F','#D95F5F');
        
        //$c3['data']['type'] = 'area-spline';
        $c3['data']['types'] = array($data1[0]=>'spline',$data2[0]=>'area-spline');
        $c3['axis']['x']['type'] = 'timeseries';
        $c3['axis']['x']['tick'] = array('count'=>$days, 'format'=>'%Y-%m-%d');
        $c3['data']['axes'] = array($data1[0]=>'y',$data2[0]=>'y2');
        
        $tagSummaryJson = json_encode($c3);
        $this->assign('tagSummaryJson',$tagSummaryJson);
    }
    
    private function getLastReportByTag($tid=0){
        $report = $this->interestReportModel->getSummaryByTag($tid,$this->updateTime['tagReport']);
        $tagReport = $report[0];
        $tagReport['tname'] = $this->tag[$tagReport['tid']]['tname'];
        
        $interestInfo = explode(";", $report[0]['interest_info']);
        $interestInfo = array_filter($interestInfo);
        
        $relateTagArray = array();
        foreach ($interestInfo as $interest){
            $temp = explode(":", $interest);
            $relateInterest = array();
            $relateInterest['tid'] = $temp[0];
            $relateInterest['tname'] = $this->tag[$temp[0]]['tname'];
            $relateInterest['count'] = $temp[1];
            $relateInterest['rate'] = round($temp[1]/$report[0]['count'],2)*100;
            $relateTagArray[] = $relateInterest;
        }
        $this->assign('tagReport',$tagReport);
        $this->assign('relateTagArray',$relateTagArray);
    }
}
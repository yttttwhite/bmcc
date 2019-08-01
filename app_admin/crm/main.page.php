<?php
class crm_main extends STpl{
    private $crm, $tag;
    public $uid;
    public function __construct($inPath){
        $this->crm = new model_consumer();
        $this->tag = new crm_tag();
        $this->uid = user_api::id();
        if($this->uid == 0){
            exit("尚未登录");
        }
    }
    
    public function pageAddUserTag(){
        $tag = new model_interest();
        $tagArray = $tag->getTag();
        $tags = array();
        foreach ($tagArray as $tagInfo){
            $tags[] = $tagInfo;
        }
        $crm = new model_consumer();
        $consumers = $crm->getConsumers(0,200,5);
        $count = count($consumers);
        
        for($i = 0; $i<200; $i++){
            $setTagAmount = rand(1, 20);
            for($j=0; $j<$setTagAmount; $j++){
                $tagInfo = $this->getRandTag($tags);
                $user = $consumers[rand(0, $count-1)];
                $userTag = array();
                $userTag['uid'] = $user['mobile'];
                $userTag['tid'] = $tagInfo['tid'];
                $userTag['pid'] = $tagArray[$tagInfo['tid']]['pid'];
                $userTag['weight'] = rand(10, 90);
                $tag->addUserTag($userTag);
            }
        }
    }
    
    private function getRandTag($tags){
        $tagCount = count($tags);
        $pid = 0;
        while ($pid < 1000){
            $tag = $tags[rand(0, $tagCount-1)];
            $pid = $tag['pid'];
        }
        return $tag;
    }
    
    public function pageTagUsers($inPath){
        $uid = $this->uid;
        if(isset($inPath[3])){
            $tid = $inPath[3];
            $result = $this->tag->getUsersByTag($tid,$uid);
            print_r($result);
        }
    }
    
    public function pageTagStat(){
        $tag = $this->tag->getTag();
        
        $weightSum = $this->tag->getTagWeightSumByUid($this->uid,1);
        $baseReport = $this->tag->getTagReport($this->uid,1,'weight_sum');
        $baseReport = $this->completeReportTag($baseReport, $tag, $weightSum);
        
        $weightSum = $this->tag->getTagWeightSumByUid($this->uid);
        $tagReportSum = $this->tag->getTagReport($this->uid,2,'weight_sum',20);
        $tagReportSum = $this->completeReportTag($tagReportSum, $tag, $weightSum);
        
        $tagReportCount = $this->tag->getTagReport($this->uid,2,'count',20);
        $tagReportCount = $this->completeReportTag($tagReportCount, $tag);
        
        $this->assign("tag", $tag);
        $this->assign("baseReport", $baseReport);
        $this->assign("tagReportSum", $tagReportSum);
        $this->assign("tagReportCount", $tagReportCount);
        return $this->render("/crm/consumerTagReport.html");
    }
    
    public function pageCountTag($inPath){
        $tid = 0;
        if(isset($inPath['3']) && is_numeric($inPath['3'])){
            $tid = $inPath['3'];
        }else{
            if(isset($_POST['tid']) && is_array($_POST['tid'])){
                $tidArray = array();
                foreach ($_POST['tid'] as $tid){
                    if(is_numeric($tid)){
                        $tidArray[] = $tid;
                    }
                }
                if(count($tidArray)>0){
                    $tid = $tidArray;
                }
            }
        }
        
        if($tid != 0 || true){
            $count = $this->tag->countUserByTag(1,$tid,"and");
            print_r($count);
        }
    }
    
    private function completeReportTag($report,$tag,$weightSum=1){
        foreach ($report as $key => $item){
            $report[$key]['tname'] = $tag[$item['tid']]['tname'];
            $report[$key]['pid'] = $tag[$item['tid']]['pid'];
            $report[$key]['pname'] = $tag[$item['tid']]['pname'];
            $report[$key]['rid'] = $tag[$item['tid']]['rid'];
            $report[$key]['rname'] = $tag[$item['tid']]['rname'];
            $report[$key]['weight'] = (round(($report[$key]['weight_sum']/$weightSum),4)*100)."%";
        }
        return $report;
    }
    
    public function pageTag($inPath){
        $tid = 0;
        if(isset($inPath['3']) && is_numeric($inPath['3'])){
            $tid = $inPath['3'];
        }else{
            if(isset($_POST['tid']) && is_array($_POST['tid'])){
                $tidArray = array();
                foreach ($_POST['tid'] as $tid){
                    if(is_numeric($tid)){
                        $tidArray[] = $tid;
                    }
                }
                if(count($tidArray)>0){
                    $tid = $tidArray;
                }
            }
        }
        $tagCount = array();
        
        $tagCount['privateUser'] = $this->crm->countUser($this->uid);
        $tagCount['publicUser'] = $this->crm->countUser();
        
        if($tid != 0 || true){
            $count = $this->tag->countUserByTag(1,$tid,"and");
            $tagCount['privateUserTag'] = $count;
        }
        
        if($tid != 0 || true){
            $count = $this->tag->countUserByTag(0,$tid,"and");
            $tagCount['publicUserTag'] = $count;
        }
        print_r($tagCount);
    }
}
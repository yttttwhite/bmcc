<?php
class report_ad extends STpl{
    public $typeArray;
    public function __construct(){
        if(!user_api::auth("stat")){
            $this->success("没有权限",'/user',3);
            exit();
        }
        $this->init();
    }
    
    public function init(){
        $this->reportAdModel = new model_ReportAd();
        $this->assign('get',$_GET);
        $this->assign('post',$_POST);
        
        $this->typeArray = array(1=>"DPC引导的js流量",2=>"Bidder收到的js流量",3=>"Bidder投放量",4=>"DPC重定向流");
   
    }
    
    public function pageList()
    {
        $AdList = array();
        
        $date = date('Ymd',time());
        $this->typeArray = array(1=>"DPC引导的js流量",2=>"Bidder收到的js流量",3=>"Bidder投放量",4=>"DPC重定向流");
        
        $url = array();
        $url['this'] = parent::setGet("/report.ad.list",$_GET);
        $get = parent::unsetGet(array('adid','adname','page'));
        $url['date'] = parent::setGet("/report.ad.list",$get);
        
        $sql = " a.verified_or_not=2 ";
        $condition = array();
        //$condition['verified_or_not'] = '2';
        
        //广告ID
        if(isset($_GET['adid']) && strlen($_GET['adid'])>0){
            $sql .= " AND a.adid=".intval($_GET['adid'])." ";
        }
        
        //广告名称
        if(isset($_GET['adname']) && strlen($_GET['adname'])>0){
            $sql .= " AND a.`adname` LIKE '%".$_GET['adname']."%' ";
        }
        
        $order = 1;
        $title = "默认排序";
        $getAll = true;
        //总记录数
        $AllCount = $this->reportAdModel->getDataCount($condition,"adid","ASC",$sql);
        
        //分页查询
        $page = array();
        $perpage = 30;
        $count = $AllCount;
        $page['amount'] = $count;
        $page['count'] = ceil($count/$perpage);
        if(isset($_GET['page']))
        {
            $page['current'] = $_GET['page'];
        }else{
            $page['current'] = 1;
        }
        $get = parent::unsetGet('page');
        $page['url'] = parent::setGet("/report.ad.List",$page);
        
        $indexStart = ($page['current']-1)*$perpage;
        $indexEnd = ($page['current'])*$perpage;
        
        unset($PushList2);
        $PushList2 = array();
        //$PushList2 = array_slice($AdList,$indexStart,30);
        $PushList2 = $this->reportAdModel->getDataAll($condition,$indexStart,30,"adid","ASC",$sql);
        
        //分页查询结束
        $this->assign('stat',$PushList2);
        $this->assign("url",$url);
        $this->assign("page",$page);
        $this->assign("title",$title);
        $this->assign("typeArray",$this->typeArray);
        $this->assign("adid",$_GET['adid']);//广告ID
        $this->assign("adname",$_GET['adname']);//广告名称
        return $this->render("/report/ad_list_all.html");
    }
    
    public function pageDetail()
    {
        if(isset($_GET['adid']) && isset($_GET['planid']) && (strlen($_GET['adid'])>0) && (strlen($_GET['planid'])>0)){
            unset($AdItem);
            $AdItem = $this->reportAdModel->getAdDetail(intval($_GET['adid']),intval($_GET['planid']));
            if( count($AdItem)>0){
                
                //频次控制
                /*$Smooth_Control = $AdItem['smooth_control']=="1"?"匀速":"标准";
                $strAllDay = $AdItem['all_day_or_not']=="1"?"全天":"分时段";*/
                
                $this->assign("plan",$AdItem);
                return $this->render("/report/ad_detail.html");
            }else{
                $this->success("对应的详情信息不存在","/report.ad.list");
            }
        }else{
            $this->success("请输入有效广告ID","/report.ad.list");
        }
    }
    
    //获取实时走势图
    public function  pageChart()
    {
        $adid = 0;
        if(isset($_GET['adid']) && strlen($_GET['adid'])>0){
            $adid = intval($_GET['adid']);
        }
        $url = array();
        $url['formAction'] = "https://115.239.138.137:8000/chart";
        $this->assign("adid",$adid);
        $this->assign("searchdate", date('Ymd'));
        $this->assign("url",$url);
        $md5 = md5($adid);var_dump($md5);
        return $this->render("/report/ad_echart.html");
    } 
}
?>
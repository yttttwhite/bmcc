<?php
class report_hostwhite extends STpl{
    public $typeArray;
    public function __construct(){
        if(!user_api::auth("stat")){
            $this->success("没有权限",'/baichuan_advertisement_manage/user',3);
            exit();
        }
        $this->init();
    }
    
    public function init(){
        $this->reportHostWhite = new model_ReportHostWhite();
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
        $url['this'] = parent::setGet("/baichuan_advertisement_manage/report.hostwhite.list",$_GET);
        $get = parent::unsetGet(array('key','pushDate'));
        $url['date'] = parent::setGet("/baichuan_advertisement_manage/report.hostwhite.list",$get);
    
        $sql = "1=1";
        //$sql = " a.verified_or_not=2 ";
        $condition = array();
        //$condition['verified_or_not'] = '2';
        
        //域名
        if(isset($_GET['key']) && strlen($_GET['key'])>0){
            $sql .= " AND `HostWhite` LIKE '%".$_GET['key']."%' ";
        }
        $strhost = $_GET['key'];
        
        //时间
        $timePush = 0;
        if( isset($_GET['pushDate']) && strlen($_GET['pushDate'])>0 ){
            $timePush = strtotime($_GET['pushDate'].' 00:00:00');
        }else{
            $timePush = strtotime(date('Y-m-d',time()).' 00:00:00')-24*3600;
        }
        $datePush = date("Ymd",$timePush);
        $condition['PushDate'] = $datePush;
        unset($PushList);
        $PushList = $this->reportHostWhite->getDataBySql($condition,NULL,30,"ID","ASC",$sql);
   
        $order = 1;
        $title = "默认排序";
        $getAll = true;
    
        //分页查询
        $page = array();
        $perpage = 30;
        $count = count($PushList);
        $page['amount'] = $count;
        $page['count'] = ceil($count/$perpage);
        if(isset($_GET['page']))
        {
            $page['current'] = $_GET['page'];
        }else{
            $page['current'] = 1;
        }
        $get = parent::unsetGet('page');
        $page['url'] = parent::setGet("/baichuan_advertisement_manage/report.hostwhite.List",$page);
    
        $indexStart = ($page['current']-1)*$perpage;
        $indexEnd = ($page['current'])*$perpage;
    
        unset($PushList2);
        $PushList2 = array();
        if($count>0)
        {
            $PushList2 = array_slice($PushList,$indexStart,30);
            //处理需展示的记录信息
            /*foreach ($PushList2 as $key=>$value)
            {
                $ids = str_replace($value['Adpv'], "(");
                var_dump($ids);
            }*/
        }
    
        //分页查询结束
        $this->assign('stat',$PushList2);
        $this->assign("url",$url);
        $this->assign("page",$page);
        $this->assign("title",$title);
        $this->assign("typeArray",$this->typeArray);
        $this->assign("adkey",$strhost);//广告名称
        $this->assign("pushDate",date('Y-m-d',$timePush));
        return $this->render("/report/hostwhite_list.html");
    }
}

?>
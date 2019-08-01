<?php
class admin_complain extends STpl{
    public $adminComplainModel;
     
    function __construct($inPath){
        if(!user_api::auth("dpc")){
            $this->success("没有权限",'/user',3);
            exit();
        }
    
        $this->init();
    }

    public function init()
    {
        $this->adminComplainModel = new model_AdminComplain();
    }

    /**
     * 结果列表
     **/
    public function pageList(){
        $date = date('Ymd',time());

        $url = array();
        $url['this'] = parent::setGet("/admin.complain.list", $_GET);
        $get = parent::unsetGet(array('date','key','start_date','end_date','page'));
        $url['date'] = parent::setGet("/admin.complain.list", $get);
       /* $get = parent::unsetGet(array('order','orderType'));
        $url['order'] = parent::setGet("/admin.complain.list", $get);
        $get = parent::unsetGet(array('order','orderType','page','type'));*/

        $sql = " `Complaint_IP`<>'219.239.97.26' ";
        $condition = array();
        if( isset($_GET['start_date']) && isset($_GET['end_date']) && strlen($_GET['start_date'])>0 && strlen($_GET['end_date'])>0 ){
            $timeStart = strtotime($_GET['start_date'].' 00:00:00');
            //$dateStart = date("Y-m-d H:i:s",$timeStart);
            $dateStart = date("Ymd",$timeStart);
            $timeEnd = strtotime($_GET['end_date'].' 23:59:59');
            //$dateEnd = date("Y-m-d H:i:s",$timeEnd);
            $dateEnd = date("Ymd",$timeEnd);

            if($dateStart == $dateEnd){
                $condition['Complaint_Date'] = $dateStart;
                //$sql = " `time_stamp`>='$dateStart 00:00:00' AND `time_stamp`<='$dateEnd 23:59:59' ";
                $sql .= "";
            }else{
                $sql .= " AND `Complaint_Date`>='$dateStart' AND `Complaint_Date`<='$dateEnd' ";
            }
        }else{//默认为最近3天记录
            $sql .= "";
            $dateStart = date("Ymd",time()-60*60*24*4);
            $dateEnd = date("Ymd",time()-60*60*24);
            //$sql = " `time_stamp`>='$dateStart' ";

            $timeStart = strtotime($dateStart.' 00:00:00');
            $dateStart = date("Ymd",$timeStart);
            $timeEnd = strtotime($dateEnd.' 23:59:59');
            $dateEnd = date("Ymd",$timeEnd);

            $sql .= " AND `Complaint_Date`>='$dateStart' AND `Complaint_Date`<='$dateEnd' ";
        }
        
        $order = 1;
        $title="默认排序";
        $getAll = true;
        $Complainlist2 = array();
        
        //分页查询开始
        $page = array();
        $perpage = 30;
        if(isset($_GET['page'])){
            $page['current'] = $_GET['page'];
        }else{
            $page['current'] = 1;
        }
        
        if(isset($_GET['key']) && strlen($_GET['key'])>0){
            if(strlen($sql)>0){
                $sql .= " AND `Complaint_Ad` = '".$_GET['key']."' ";
            }else{
                $sql .= " `Complaint_Ad` = '".$_GET['key']."' ";
            }
            
            //总记录数
            $AllCount = $this->adminComplainModel->getDataCount($condition,"Complaint_Date","DESC",$sql);
            
            $count = $AllCount;
            $page['amount'] = $count;
            $page['count'] = ceil($count/$perpage);
            $indexStart = ($page['current']-1)*$perpage;
            $indexEnd   = ($page['current'])*$perpage;
            
            $Complainlist2 = $this->adminComplainModel->getDataBySql($condition,$indexStart,30,"Complaint_Date","DESC",$sql);
        }else{
            $count = 0;
            $page['amount'] = $count;
            $page['count'] = ceil($count/$perpage);
            $indexStart = ($page['current']-1)*$perpage;
            $indexEnd   = ($page['current'])*$perpage;
        }
        
        $get = parent::unsetGet('page');
        $page['url'] = parent::setGet("/admin.complain.List", $get);

        //$Complainlist2 = array();
        //$Complainlist2 = array_slice($Complainlist,$indexStart,30);

        //分页查询结束
        $this->assign('stat',$Complainlist2);
        $this->assign("url",$url);
        $this->assign('page',$page);
        $this->assign('title',$title);
        $this->assign("adkey",$_GET['key']);
        $this->assign("BDate",$_GET['start_date']);
        $this->assign("EDate",$_GET['end_date']);
        
        return $this->render("/admin/complain_list.html");
    }
    
    /**
     * 工信部投诉查询结果
     **/
    public function pageMIITList(){
        $date = date('Ymd',time());
    
        $url = array();
        $url['this'] = parent::setGet("/admin.complain.miitlist", $_GET);
        $get = parent::unsetGet(array('date','key','BDate','EDate','page'));
        $url['date'] = parent::setGet("/admin.complain.miitlist", $get);
    
        $sql = "";
        $condition = array();
        $condition['Complaint_IP'] = "219.239.97.26";
        if( isset($_GET['BDate']) && isset($_GET['EDate']) && strlen($_GET['BDate'])>0 && strlen($_GET['EDate'])>0 ){
            $timeStart = strtotime($_GET['BDate'].' 00:00:00');
            $dateStart = date("Ymd",$timeStart);
            $timeEnd = strtotime($_GET['EDate'].' 23:59:59');
            $dateEnd = date("Ymd",$timeEnd);
    
            if($dateStart == $dateEnd){
                $condition['Complaint_Date'] = $dateStart;
                //$sql = " `time_stamp`>='$dateStart 00:00:00' AND `time_stamp`<='$dateEnd 23:59:59' ";
                $sql = "";
            }else{
                $sql = " `Complaint_Date`>='$dateStart' AND `Complaint_Date`<='$dateEnd' ";
            }
        }else{//默认不限时间段
            $condition['Complaint_Date'] = date("Ymd",time());
            $sql = "";
        }
    
        $order = 1;
        $title="默认排序";
        //$getAll = true;
        if(isset($_GET['key']) && strlen($_GET['key'])>0){
            if(strlen($sql)>0){
                $sql .= " AND `Complaint_Ad` = '".$_GET['key']."' ";
            }else{
                $sql .= " `Complaint_Ad` = '".$_GET['key']."' ";
            }
        }
        /*}else{
            $Complainlist = array();
        }*/
        unset($Complainlist);
        $Complainlist = array();
        $Complainlist = $this->adminComplainModel->getMIITDataBySql($condition,NULL,30,"Complaint_Date","DESC",$sql);
        //分页查询开始
        $page = array();
        $perpage = 30;
        $count = count($Complainlist);
        $page['amount'] = $count;
        $page['count'] = ceil($count/$perpage);
        if(isset($_GET['page'])){
            $page['current'] = $_GET['page'];
        }else{
            $page['current'] = 1;
        }
        $get = parent::unsetGet('page');
        $page['url'] = parent::setGet("/admin.complain.MIITList", $get);
        
        $indexStart = ($page['current']-1)*$perpage;
        $indexEnd   = ($page['current'])*$perpage;
        
        unset($Complainlist2);
        $Complainlist2 = array();
        if($count>0)
        {
            $Complainlist2 = array_slice($Complainlist,$indexStart,30);
        }
    
        //分页查询结束
        $this->assign('stat',$Complainlist2);
        $this->assign("url",$url);
        $this->assign('page',$page);
        $this->assign('title',$title);
        $this->assign("adkey",$_GET['key']);
        $this->assign("BDate",$_GET['BDate']);
        $this->assign("EDate",$_GET['EDate']);
        return $this->render("/admin/miit_list.html");
    }
}
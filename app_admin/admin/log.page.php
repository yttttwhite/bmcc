<?php
class admin_log extends STpl{
    public $adminLogModel;
    public function __construct($inPath){
        if(!user_api::auth("system")){
            die("权限拒绝");
        }
        $this->init();
    }

    public function init(){
        $this->adminLogModel = new model_AdminLog();
    }

    public function pageList(){
        $date = date('Ymd',time());
        $url = array();
        $url['this'] = parent::setGet("/admin.log.list", $_GET);
        $get = parent::unsetGet(array('date','dateStart','dateEnd','page','nav'));
        $url['type'] = parent::setGet("/admin.log.list", $get);
        $get = parent::unsetGet(array('order','orderType'));
        $url['order'] = parent::setGet("/admin.log.list", $get);
        $get = parent::unsetGet(array('order','orderType','page','type'));
        $url['detail'] = parent::setGet("/admin.log.detail", $get);

        $sql = "";
        $condition = array();
        if( isset($_GET['dateStart']) && isset($_GET['dateEnd']) && strlen($_GET['dateStart'])>0 && strlen($_GET['dateEnd'])>0 ){
            $timeStart = strtotime($_GET['dateStart'].' 00:00:00');
            $dateStart = date("Y-m-d H:i:s",$timeStart);
            $timeEnd = strtotime($_GET['dateEnd'].' 23:59:59');
            $dateEnd = date("Y-m-d H:i:s",$timeEnd);

            if($dateStart == $dateEnd){
                $condition['time_stamp'] = $dateStart;
                //$sql = " `time_stamp`>='$dateStart 00:00:00' AND `time_stamp`<='$dateEnd 23:59:59' ";
                $sql = "";
            }else{
                $sql = " `time_stamp`>='$dateStart' AND `time_stamp`<='$dateEnd' ";
            }
        }else{
            $sql = "";
//            $dateStart = date("Y-m-d H:i:s",time()-60*60*24);
//            $dateEnd = date("Y-m-d H:i:s",time()-60*60*24);
            $nowStartDate = date("Y-m-d",time());
            $nowEndDate = date("Y-m-d",time());
            $nowTimeStart = strtotime($nowStartDate.' 00:00:00');
            $dateStart = date("Y-m-d H:i:s",$nowTimeStart);
            $nowTimeEnd = strtotime($nowEndDate.' 23:59:59');
            $dateEnd = date("Y-m-d H:i:s",$nowTimeEnd);
            $sql = " `time_stamp`>='$dateStart' AND `time_stamp`<='$dateEnd' ";
//            $sql = " `time_stamp`>='$dateStart' ";

        }

        if(isset($_GET['key']) && strlen($_GET['key'])>0 && strlen($sql)>0){
            $sql .= " AND `uname` LIKE '%".$_GET['key']."%' ";
        }elseif(isset($_GET['key']) && strlen($_GET['key'])>0){
            $sql .= " `uname` LIKE '%".$_GET['key']."%' ";
        }

        $order = 1;
        $title="默认排序";
        $getAll = true;

        //$time = time();
        //$startTime = $time - 60*60;
        //$sql = " `time` > '$startTime' ";
        //Log日志
        $Loglist = $this->adminLogModel->getDataBySql($condition,0,-1,"time","desc",$sql);
        if(isset($_GET['export']) && $_GET['export']==1){
//            $filename = "日志信息_".$dateStart."_".$dateEnd;
            $filename = $dateStart."_".$dateEnd;
             ob_end_clean();//清除缓冲区,避免乱码
             header("Content-type:application/octet-stream");
             header("Accept-Ranges:bytes");
//             header("Content-type:application/vnd.ms-excel;charset=gb2312");
             header("Content-type:application/vnd.ms-excel");
             header("Content-Disposition:attachment;filename=".$filename.".xls");
             header("Pragma: no-cache");
             header("Expires: 0");

             $outPut = "";
             //表头
             $outPut .= "id\tuname\tdate\toperation\toperation_name\turl\tip\t";
             $outPut .= "\n";

             //表内容
             $lineId = 1;
             foreach ($Loglist as $host=>$line){
                 $outPut .= $lineId."\t";
                 /*foreach ($line as $unit){
                     $outPut .= $unit."\t";
                 }*/
                  $outPut .= $line['uname']."\t";
                  $outPut .= $line['time_stamp']."\t";
                  $outPut .= $line['operation']."\t";
                  $outPut .= $line['operation_name']."\t";
                  $outPut .= $line['url']."\t";
                  $outPut .= $line['ip']."\t";
                  $outPut .= "\n";
                  $lineId++;
              }

              echo $outPut;
        }else{
            //分页查询开始
            $page = array();
            $perpage = 50;
            $count = count($Loglist);
            $page['amount'] = $count;
            $page['count'] = ceil($count/$perpage);
            if(isset($_GET['page'])){
                $page['current'] = $_GET['page'];
            }else{
                $page['current'] = 1;
            }
            $get = parent::unsetGet('page');
            $page['url'] = parent::setGet("/admin.log.Detail", $get);

            $indexStart = ($page['current']-1)*$perpage;
            $indexEnd   = ($page['current'])*$perpage;
            $pageData = array_slice($Loglist, $indexStart,50);
            //分页查询结束
            $this->assign('stat',$pageData);
            $this->assign("url",$url);
            $this->assign('page',$page);
            $this->assign('title',$title);
            $this->assign('GET',$_GET);
            return $this->render("/admin/log_list_all.html");
        }
    }

    //详情页
    public function pageDetail(){
        if(isset($_GET['id']) && strlen($_GET['id'])>0){
            $sql = "";
            $condition['id'] = intval($_GET['id']);
            $DataDetail = $this->adminLogModel->getData($condition,0,1,"time","desc");

            $ItemData = null;
            if(count($DataDetail)>0)
            {
                $ItemData = (Object)$DataDetail[0];
            }
            //var_dump($ItemData);
            $this->assign("item",$ItemData);
            // $this->assign("roleList",user_api::getRoleList());
            return $this->render("/admin/log_detail.html");
        }else {
            $this->success("对应的明细信息不存在","/admin.log.list");
        }
    }
}
<?php
class report_stat extends STpl
{
    public $reportHostModel;
    public $typeArray;
    public function __construct(){
        if(!user_api::auth("stat")){
            $this->success("没有权限",'/user',3);
            exit();
        }
        $this->init();
    }

    public function init(){
        $this->reportHostModel = new model_ReportHost();
        $this->assign('get',$_GET);
        $this->assign('post',$_POST);
        
        $this->typeArray = array(1=>"DPC引导的js流量",2=>"Bidder收到的js流量",3=>"Bidder投放量",4=>"DPC重定向流");
    }
    
    public function pageLeft(){
        return $this->render("/report/left.html");
    }
    
    public function pageHost(){
        $date = date("Ymd",time());
        $this->typeArray = array(1=>"DPC引导的js流量",2=>"Bidder收到的js流量",3=>"Bidder投放量",4=>"DPC重定向流");
        
        $url = array();
        $url['this'] = parent::setGet("/baichuan_advertisement_manage/report.stat.host", $_GET);
        $get = parent::unsetGet(array('date','dateStart','dateEnd','page'));
        $url['date'] = parent::setGet("/baichuan_advertisement_manage/report.stat.host", $get);
        $get = parent::unsetGet(array('type','page'));
        $url['type'] = parent::setGet("/baichuan_advertisement_manage/report.stat.host", $get);
        $get = parent::unsetGet(array('order','orderType'));
        $url['order'] = parent::setGet("/baichuan_advertisement_manage/report.stat.host", $get);
        $get = parent::unsetGet(array('order','orderType','page','type'));
        $url['detail'] = parent::setGet("/baichuan_advertisement_manage/report.stat.detail", $get);
        
        $condition = array();
        if( isset($_GET['dateStart']) && isset($_GET['dateEnd']) && strlen($_GET['dateStart'])>0 && strlen($_GET['dateEnd'])>0 ){
            $timeStart = strtotime($_GET['dateStart']);
            $dateStart = date("Ymd",$timeStart);
            $timeEnd = strtotime($_GET['dateEnd']);
            $dateEnd = date("Ymd",$timeEnd);
            
            if($dateStart == $dateEnd){
                $condition['date'] = $dateStart;
                $sql = "";
            }else{
                $sql = " `date`>='$dateStart' AND `date`<='$dateEnd' ";
            }
        }else{
            $sql = "";
            $dateStart = date("Ymd",time()-60*60*24);
            $dateEnd = date("Ymd",time()-60*60*24);
            $condition['date'] = date("Ymd",time()-60*60*24);;
        }
        
        if(isset($_GET['key']) && strlen($_GET['key'])>0 && strlen($sql)>0){
            $sql .= " AND `host` LIKE '%".$_GET['key']."%' ";
        }elseif(isset($_GET['key']) && strlen($_GET['key'])>0){
            $sql .= " `host` LIKE '%".$_GET['key']."%' ";
        }

        if( isset($_GET['type']) && isset($this->typeArray[$_GET['type']]) ){
            $title = $this->typeArray[$_GET['type']];
            $order = $_GET['type'];
            $getAll = true;
        }else{
            $order = 1;
            $title="默认排序";
            $getAll = true;
        }
        
        //HOST列表条件
        $totalList = $this->reportHostModel->getTotalList($condition,$sql);
        $stat = array();
        foreach ($totalList as $temp){
            foreach ($this->typeArray as $typeCode => $typeName){
                $stat[$temp['host']][$typeCode] = 0;
            }
        }
        foreach ($totalList as $temp){
            if(strlen($temp['host'])>0){
                $stat[$temp['host']][$temp['type']] += $temp['sum'];
            }
        }
        //处理：Bidder收到的js流量（type=2） = Bidder收到的js流量（type=2）+ Bidder投放量（type=3）
        foreach ($stat as $key=>$value){
            $stat[$key][2] = $value[2]+$value[3];
        }
        
        
        if(is_array($stat) && count($stat)>0){
            $stat = $this->multi_array_sort($stat, $order, SORT_DESC);
        }
        
        if(isset($_GET['export']) && $_GET['export']==1){
            $filename = "统计报表_".$dateStart."_".$dateEnd;
            header("Content-type:application/octet-stream");
            header("Accept-Ranges:bytes");
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=".$filename.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            
            $outPut = "";
            //表头
            $outPut .= "ID\tHost\t";
            foreach ($this->typeArray as $type){
                $outPut .= $type."\t";
            }
            $outPut .= "\n";
            
            //表内容
            $lineId = 1;
            foreach ($stat as $host=>$line){
                $outPut .= $lineId."\t".$host."\t";
                foreach ($line as $unit){
                    $outPut .= $unit."\t";
                }
                $outPut .= "\n";
                $lineId++;
            }
            
            echo $outPut;
        }else{
            //分页查询开始
            $page = array();
            $perpage = 50;
            $count = count($stat);
            $page['amount'] = $count;
            $page['count'] = ceil($count/$perpage);
            if(isset($_GET['page'])){
                $page['current'] = $_GET['page'];
            }else{
                $page['current'] = 1;
            }
            $get = parent::unsetGet('page');
            $page['url'] = parent::setGet("/baichuan_advertisement_manage/report.stat.host", $get);
            
            $hostList = array_keys($stat);
            $indexStart = ($page['current']-1)*$perpage;
            $indexEnd   = ($page['current'])*$perpage;
            
            $displayData = array();
            for($i = $indexStart; $i < $indexEnd; $i++){
                $displayData[$hostList[$i]] = $stat[$hostList[$i]];
            }
            //分页查询结束
            
            $this->assign('stat',$displayData);
            $this->assign("url",$url);
            $this->assign("typeArray",$this->typeArray);
            $this->assign('page',$page);
            $this->assign('title',$title);
            return $this->render("/report/host_list_all.html");
        }
    }
    
    public function pageDetail(){
        if(isset($_GET['host']) && strlen($_GET['host'])>0){
            $condition  = array();
            $condition['host'] = $_GET['host'];
            
            if( isset($_GET['type']) && isset($this->typeArray[$_GET['type']]) ){
                $condition['type'] = $_GET['type'];
                $typeOnly = true;
            }else{
                $typeOnly = false;
            }
            
            if( isset($_GET['dateStart']) && isset($_GET['dateEnd']) && strlen($_GET['dateStart'])>0 && strlen($_GET['dateEnd'])>0 ){
                $timeStart = strtotime($_GET['dateStart']);
                $dateStart = date("Ymd",$timeStart);
                $timeEnd = strtotime($_GET['dateEnd']);
                $dateEnd = date("Ymd",$timeEnd);
            
                if($dateStart == $dateEnd){
                    $dateStart = date("Ymd",$timeEnd-60*60*24*7);
                }
            }else{
                $dateEnd = date("Ymd",time()-60*60*24);
                $dateStart = date("Ymd",time()-60*60*24*8);
            }
            $sql = " `date`>='$dateStart' AND `date`<='$dateEnd' ";
            
            $list = $this->reportHostModel->getDataByHost($condition,$sql);
            
            foreach ($list as $item){
                $temp[$item['date']]['type'.$item['type']] = $item['amount'];
            }
            $list = $temp;
            
            $xAxis = array();
            $yAxis = array();
            $series = array();
            $data = array();
            
            if($typeOnly){
                $data[$_GET['type']]['name'] = $this->typeArray[$_GET['type']];
                
                foreach ($list as $date=>$item){
                    $xAxis['categories'][] = $date;
                    $data[$_GET['type']]['data'][] = (int)$item['type'.$_GET['type']];
                }
                foreach ($data as $temp){
                    $series[] = $temp;
                }
            }else{
                foreach ($this->typeArray as $typeCode=>$typeName){
                    $data[$typeCode]['name'] = $this->typeArray[$typeCode];
                }
                foreach ($list as $date=>$item){
                    $xAxis['categories'][] = $date;
                    foreach ($this->typeArray as $typeCode=>$typeName){
                        if(isset($item['type'.$typeCode])){
                            //处理：Bidder收到的js流量（type=2） = Bidder收到的js流量（type=2）+ Bidder投放量（type=3）
                            if($typeCode == 2 && isset($item['type'."3"]) ){
                                $data[$typeCode]['data'][] = (int)$item['type'.$typeCode] + (int)$item['type'."3"];
                            }else{
                                $data[$typeCode]['data'][] = (int)$item['type'.$typeCode];
                            }
                        }else{
                            $data[$typeCode]['data'][] = (int)0;
                        }
                    }
                }
                foreach ($data as $temp){
                    $series[] = $temp;
                }
            }
            
            $yAxis['title'] = array("text"=>"流量");
            
            $chart = array();
            $chart['chart'] = array("type"=>"line");
            $chart['credits'] = array("enabled"=>false);
            $chart['title'] = array("text"=>"流量走势：".$condition['host']);
            $chart['xAxis'] = $xAxis;
            $chart['yAxis'] = $yAxis;
            $chart['series'] = $series;
            $chartJson = json_encode($chart);
            $this->assign("chartJson",$chartJson);
            return $this->render("/report/host_detail.html");
        }
    }
    
    public function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){
        if(is_array($multi_array)){
            foreach ($multi_array as $row_array){
                if(is_array($row_array)){
                    $key_array[] = $row_array[$sort_key];
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        array_multisort($key_array,$sort,$multi_array);
        return $multi_array;
    }
}
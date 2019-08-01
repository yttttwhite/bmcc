<?php
class model_interestReport extends discuz_database{
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }
    
    //获取最新的标签报告的日期
    public function getLatestReportDate(){
        $updateTime = array();
        
        $table = parent::table('interest_summary_by_date');
        $sql = " SELECT `uptime` FROM `$table` ORDER BY `uptime` DESC LIMIT 0,1 ";
        $result = parent::fetch_first($sql);
        if(isset($result['uptime'])){
            $updateTime['tagSummary'] = $result['uptime'];
        }else{
            $updateTime['tagSummary'] = 0;
        }
        
        $table = parent::table('interest_report');
        $result = parent::fetch_first($sql);
        if(isset($result['uptime'])){
            $updateTime['tagReport'] = $result['uptime'];
        }else{
            $updateTime['tagReport'] = 0;
        }
        
        return $updateTime;
    }
    
    //获取数量靠前的标签报告
    public function getTopTagReport($limit=10, $uptime=0){
        if($uptime == 0){
            $time = time() - (60*60*24);
            $uptime = date("Y-m-d",$time);
        }elseif(is_numeric($uptime)){
            $uptime = date("Y-m-d",$uptime);
        }
        $table = parent::table('interest_report');
        $sql = " SELECT * FROM `$table` WHERE `uptime` = '$uptime' ORDER BY `count` DESC LIMIT 0,$limit ";
        $result = parent::fetch_all($sql);
        return $result;
    }
    
    //获取某标签、某段时间统计
    public function getSummaryByTag($tid, $dateFrom = 0, $days = 1){
        if($dateFrom == 0){
            $dateFrom = time() - (60*60*24*$days);
            $dateFrom = date("Y-m-d",$dateFrom);
        }elseif(is_numeric($dateFrom)){
            $dateFrom = date("Y-m-d",$dateFrom);
        }
    
        $table = parent::table('interest_report');
        if($days == 1){
            $sql = " SELECT * FROM `$table` WHERE `tid`=$tid AND `uptime` = '$dateFrom' ";
        }else{
            $sql = " SELECT * FROM `$table` WHERE `tid`=$tid AND `uptime` >= '$dateFrom' ORDER BY `uptime` LIMIT 0,$days ";
        }
        $result = parent::fetch_all($sql);
        return $result;
    
    }
    
}
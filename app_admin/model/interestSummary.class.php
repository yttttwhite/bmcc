<?php
class model_interestSummary extends discuz_database{
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }
    
    //通过日期获取统计
    public function getSummary($startDate=0, $limit=30){
        if ($startDate == 0){
            $currentTime = time();
            $startDate = $currentTime - ($limit*60*60*24);
        }
        if(is_numeric($startDate)){
            $startDate = date("Y-m-d",$startDate);
        }
    
        $table = parent::table('interest_summary_by_date');
        $sql = " SELECT * FROM `$table` WHERE `uptime` >= '$startDate' ORDER BY `uptime` LIMIT 0,$limit ";
        $result = parent::fetch_all($sql);
        return $result;
    }
}
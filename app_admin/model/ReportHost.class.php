<?php
class model_ReportHost extends discuz_database{
    public $table = "host";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }

    public function addData($data)
    {
        $id = parent::insert($this->table, $data, true, false);
        return $id;
    }
    public function getData($condition=0, $start=0, $limit=0, $order=0, $orderType="ASC")
    {
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE 1 ";
        }
        
        if($limit !== 0){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if($order !== 0){
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
        $table = parent::table($this->table);
        $sql = "SELECT * FROM `$table` $condition $order $limit ";
        echo $sql;
        $result = parent::fetch_all($sql);
        return($result);
    }
    
    public function getTotalList($condition=0, $sql="", $start=0, $limit=0, $order=0, $orderType="ASC"){
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE 1 ";
        }
        
        if( strlen($sql)>0 ){
            $condition .= " AND ".$sql;
        }
        
        if($limit !== 0){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if($order !== 0){
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
        $table = parent::table($this->table);
        $sql = "SELECT *, SUM(num) as `sum` FROM `$table` $condition GROUP BY `host`,`type` $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }
    
    public function getCount($condition=0)
    {
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE 1 ";
        }
        
        if($limit !== 0){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if($order !== 0 && strlen($order)>0){
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
        $table = parent::table($this->table);
        $sql = "SELECT COUNT(*) AS `count` FROM `$table` $condition $order $limit ";
        $result = parent::fetch_all($sql);
        return($result[0]['count']);
    }
    
    public function getDataBySql($condition=0, $sql="", $start=0, $limit=0, $order=0, $orderType="ASC")
    {
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE 1 ";
        }
        
        if( strlen($sql)>0 ){
            $condition .= " AND ".$sql;
        }
        
        if($limit !== 0){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if($order !== 0){
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = " ORDER BY `amount` DESC ";
        }
        $table = parent::table($this->table);
        $sql = "SELECT *, SUM(`num`) AS `amount` FROM `$table` $condition GROUP BY `host`,`type` $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }
    
    public function getHostList($condition=0, $sql="", $start=0, $limit=0, $order=0, $orderType="ASC")
    {
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE 1 ";
        }
        
        if( strlen($sql)>0 ){
            $condition .= " AND ".$sql;
        }
        
        if($limit !== 0){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if($order !== 0){
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = " ORDER BY `amount` DESC ";
        }
        $table = parent::table($this->table);
        $sql = "SELECT *, SUM(`num`) AS `amount` FROM `$table` $condition GROUP BY `host` $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }
    
    public function getCountBySql($condition=0, $sql="")
    {
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE 1 ";
        }
        
        if( strlen($sql)>0 ){
            $condition .= " AND ".$sql;
        }
        
        if($limit !== 0){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if($order !== 0 && strlen($order)>0){
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
        $table = parent::table($this->table);
        $sql = "SELECT COUNT( DISTINCT(`host`) ) AS `count` FROM `$table` $condition $order $limit ";
        $result = parent::fetch_all($sql);
        return($result[0]['count']);
    }
    
    public function getDataByHost($condition=0, $sql=""){
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $condition = " WHERE $condition ";
        }else{
            $condition = " WHERE 1 ";
        }
        
        if( strlen($sql)>0 ){
            $condition .= " AND ".$sql;
        }
        
        $order = " ORDER BY `date` ASC ";
        
        $table = parent::table($this->table);
        $sql = "SELECT *, SUM(`num`) AS `amount` FROM `$table` $condition GROUP BY `date`,`type` $order $limit ";
        $result = parent::fetch_all($sql);
        
        return($result);
    }
}
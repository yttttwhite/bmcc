<?php
//用户操作日志表，137服务器push_flow_monitor，BC_log
class model_adminLog extends model_Model{
    public $table = "log";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
    }
    
    public function getDataBySql($condition=0, $start='', $limit='', $order='', $orderType="ASC", $sql = ""){
        $where = " WHERE 1 ";
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $where .= " AND $condition ";
        }
        
        if(strlen($sql)>1){
            $where .= " AND ".$sql;
        }
    
        if(strlen($start)>0 && strlen($limit)>0 && is_numeric($start) && is_numeric($limit)){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
    
        if(strlen($order)>0){
            if($orderType == 1 || strtolower($orderType) === 'desc'){
                $orderType = 'DESC';
            }else{
                $orderType = 'ASC';
            }
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
    
        $table = parent::table($this->table);
        $sql = "SELECT * FROM `$table` $where $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }
}
<?php
//投诉账号查询记录
class model_AdminComplain extends discuz_database{
    public $table = "Details";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        $this->table = 'Details';
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
        $sql = "SELECT Complaint_Details.*,Complaint_domain.domain FROM `$table` left join `Complaint_domain` on Complaint_Details.Complaint_IP=Complaint_domain.IP $where $order $limit ";
        //var_dump($sql);exit;
        unset($result);
        $result = parent::fetch_all($sql);
        return($result);
    }
    
    public function getDataCount($condition=0, $order='', $orderType="ASC", $sql = ""){
        $where = " WHERE 1 ";
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $where .= " AND $condition ";
        }
    
        if(strlen($sql)>1){
            $where .= " AND ".$sql;
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
        $sql = "SELECT count(*) as num FROM `$table` left join `Complaint_domain` on Complaint_Details.Complaint_IP=Complaint_domain.IP $where $order ";
        //var_dump($sql);exit;
        $result = parent::fetch_all($sql);
        return($result[0]['num']);
    }
    
    public function getMIITCountBySql($condition=0, $order='', $orderType="ASC", $sql = ""){
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
        
        $sqlgroup = " GROUP BY Complaint_Date,Complaint_Ad";
    
        $table = parent::table($this->table);
        $sql = "SELECT COUNT(*) as num FROM `$table` $where $sqlgroup $order ";
        //var_dump($sql);exit();
        $result = parent::fetch_all($sql);
        return($result);
    }
    
    public function getMIITDataBySql($condition=0, $start='', $limit='', $order='', $orderType="ASC", $sql = ""){
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
        
        $sqlgroup = " GROUP BY Complaint_Date,Complaint_AD";
        
        $table = parent::table($this->table);
        $sql = "SELECT DISTINCT(Complaint_Details.Complaint_Ad),Complaint_Details.Complaint_Date FROM `$table` $where $order $limit ";
        //var_dump($sql);
        $result = parent::fetch_all($sql);   
        return($result);
    }
    
}
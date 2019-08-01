<?php
//用户账单列表：userbilling
class model_userbilling extends model_Model{
     public $table = "userbilling";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        parent::__construct($this->table);
    }
}
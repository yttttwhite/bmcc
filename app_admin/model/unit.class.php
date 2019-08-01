<?php
//用户表：adp_contract_info
class model_Unit extends model_Model{
    public $table = "contract_unit";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        parent::__construct($this->table);
    }
}

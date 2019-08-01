<?php
//广告位标签：adp_po_tag
class model_poTag extends model_Model{
    public $table = "po_tag";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        parent::__construct($this->table);
    }
}
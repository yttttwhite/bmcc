<?php
class admin_contractlogapi {
    private $logDB;
    private $logTable;
    public function __construct($inPath){
        $this->logDB = new SDb();
        $this->logDB->useConfig("adp");
        $this->logTable = 'adp_contract_audited_log';
    }
    public function addLog($operate_uid, $target_uid, $operate_num, $object_id, $note='') {
        if (!isset($operate_uid) || !isset($target_uid) || !isset($operate_num) || !isset($object_id)) {
            return false;
        }
        $object = '';
        if (is_array($object_id)) {
            foreach ($object_id as $oid) {
                $object .= $oid;
                if ($oid != end($object_id)) {
                    $object .= ',';
                }
            }
        } else {
            $object = $object_id;
        }
        $item = array('operate_uid'=>$operate_uid, 'target_uid'=>$target_uid,
                      'operate_num'=>$operate_num, 'object_id'=>$object, 'time'=>time());
        if(isset($note)) {
            $item['note'] = $note;
        }
        $num =  $this->logDB->insert($table=$this->logTable, $item, $isreplace=false, $isdelayed=false, $update=array());
        if($num > 0) {
            return true;
        } else {
            return false;
        }
    }
    
}
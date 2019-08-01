<?php
class message_api {
    private $msgDB;
    private $msgTable;
    public function __construct($inPath=[]){
        $this->initMsg(); //初始化消息数据库
    }
    private function initMsg() {
        $this->msgDB = new SDb();
        $this->msgDB->useConfig("adp");
        $this->msgTable = 'adp_msg_info';
    }
    
    public function getMsgCount($status = 1) {
        $this->msgDB->setPage(1);
        $this->msgDB->setLimit(-1);
        $table=array($this->msgTable);
        $uid = user_api::id();
        $condition = array("receive_id"=>$uid, "msg_status"=>$status);  //msg_status = 0已读， =1 未读， =2 已删除
        $result = $this->msgDB->select($table,$condition);
        return $result->totalSize;
    }

    public function sendMsg($sender, $receive, $title, $content) {
        $item = array('sender_id'=>$sender, 'receive_id'=>$receive, 'content'=>$content, 'title'=>$title, 'send_time'=>time());
        $this->msgDB->insert($table=$this->msgTable,$item,$isreplace=false,$isdelayed=false, $update=array());
    }

    public function getPlanCheck() {
        $status = 1; //$status = 1表示待审核， $status = 2表示未通过，$status=3表示已通过
        $page = 1;
        $pageSize = 100;
        $x = new thrift_adplan_main;
        $plans = $x->getGroupByStatus(array(),$status,$page,$pageSize);
        return $plans;
    }
    
    public function getStuffCheck() {
        $status = 1; //$status = 1表示待审核， $status = 2表示未通过，$status=3表示已通过
        $page = 1;
        $pageSize = 100;
        $x = new thrift_stuffinfo_main;
        $stuff = $x->getStuffByStatus(array(),$status,$page,$pageSize);
        return $stuff;
    }
}
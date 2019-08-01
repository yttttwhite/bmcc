<?php
class message_main extends STpl{
    public function __construct($inPath){
        
    }
    public function pageEntry($inPath) {

        $condition = array();
        $status = $_GET['msg_status'];
        if(isset( $status)) {
            if ( $status == 1 ||  $status == 0) {
                $condition['msg_status'] =  $status;
            } else if ($status == 3) {
                unset($condition['msg_status']);
            }
        } else {
            $condition['msg_status'] = $status = 1;
        }
        
        $page = $_GET['page']>0? $_GET['page']: 1;
        $limit = $_GET['limit']>0? $_GET['limit']: 20;

        $db = new SDb();
        $db->useConfig('adp');
        $db->setPage($page);
        $db->setLimit($limit);
        $condition['receive_id'] = user_api::id();
        $result = $db->select('adp_msg_info',$condition);
        $list = array_reverse($result->items);

        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->assign('page', $result->page);
        $this->assign('totalPage', $result->totalPage);
        $this->assign('limit', $result->limit);
        $this->assign('totalSize', $result->totalSize);
        return $this->render("v2/msg/msg.html");
    }

    public function pageMsgSet() {
        if (!isset($_GET['msg_id']))
            return false;
        $condition = array();
        $condition['msg_id'] =  $_GET['msg_id'];
        $db = new SDb();
        $db->useConfig('adp');

        $status = $_GET['msg_status'];
        if ( $status == 1 ||  $status == 0) {
            $items = array('msg_status' => $status);
            $result = $db->update('adp_msg_info', $condition, $items); //更新
        } else if ( $status == 2) {
            $result = $db->delete('adp_msg_info', $condition);
        } else {
            return false;
        }
        
        return $result;
    }
}
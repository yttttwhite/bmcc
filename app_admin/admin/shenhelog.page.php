<?php
class admin_shenhelog extends STpl {
 	public function __construct($inPath){
	    if(!user_api::auth("shenhe")){
	        $this->success("没有审核权限",'/baichuan_advertisement_manage/user',3);
	        exit();
	    }
	}

    public function pageEntry($path){

        $start = $_GET['start'];
        $end = $_GET['end'];
        $uid = $_GET['uid'];
        $code = $_GET['code'];
        $condition = array();
        if (empty($start) || empty($end)) {
            $start = date('Y-m-d', time() - 6*24*60*60);   //一周内
            $end = date('Y-m-d', time());   
        }

        $condition[] = "time >= " . strtotime($start);
        $condition[] =  "time <= " . (strtotime($end) + 24*60*60 - 1);

        if (!empty($uid)) {
            $condition['target_uid'] = $uid;
        } 

        if (!empty($code)) {
            $condition['operate_num'] = $code;
        }

    	$page = $_GET['pageNum']>0? $_GET['pageNum']: 1;
    	$limit = $_GET['limit']>0? $_GET['limit']: 20;
    	$db = new SDb();
    	$db->useConfig('adp');
    	$db->setPage($page);
    	$db->setLimit($limit);
    	$result = $db->select('adp_shenhe_log',$condition,"","","id desc");
//        $list  = array_reverse($result->items);
        $list  = $result->items;
        $user_list = array();
        $plan_list = array(); 
        $stuff_list = array();
        foreach ($list as $item ) {
            $user_list[] = $item['operate_uid'];
            $user_list[] = $item['target_uid'];
            $op_num = substr($item['operate_num'], 0, 1);
            if ( $op_num == 1) {
                $arr = explode(',', $item['object_id']);
                $plan_list = array_merge($plan_list, $arr);
            } else if($op_num == 2) {
                $arr = explode(',', $item['object_id']);
                $stuff_list = array_merge($stuff_list, $arr);
            }
        }
        $user_list = array_unique($user_list);
        $plan_list = array_unique($plan_list);
        $stuff_list = array_unique($stuff_list);

        $user_list = api_common::getUserNameByList($user_list);
        $plan_list = api_common::getPlanNameByList($plan_list);
        $stuff_list = api_common::getStuffNameByList($stuff_list);
        
        foreach ($list as &$item) {
            $item['operate_uid'] = $item['operate_uid'] .':'.$user_list[$item['operate_uid']];
            $item['target_uid'] = $item['target_uid'] .':'.$user_list[$item['target_uid']];

            $op_num = substr($item['operate_num'], 0, 1);
            if ( $op_num == 1) {
                $arr = explode(',', $item['object_id']);
                $item['object_id'] = '';
                foreach ($arr as $pid) {
                    $name = isset($plan_list[$pid]) ? $plan_list[$pid]: '未知';
                    $item['object_id'] .= $pid. ':' . $name.', ';
                }
            } else if($op_num == 2) {
                $arr = explode(',', $item['object_id']);
                $item['object_id'] = '';
                foreach ($arr as $sid) {
                    $name = isset($stuff_list[$sid]) ? $stuff_list[$sid]: '未知';
                    $item['object_id'] .= $sid. ':' . $name.', ';
                }
            }
        }

        $this->assign('start', $start);
        $this->assign('end', $end);
        $this->assign('uid', $uid);
        $this->assign('code', $code);
        $this->assign('user_list', $user_list);
        $this->assign('plan_list', $plan_list);
        $this->assign('stuff_list', $stuff_list);
        $this->assign('list', $list);
    	$this->assign('page', $result->page);
    	$this->assign('totalPage', $result->totalPage);
    	$this->assign('limit', $result->limit);
    	$this->assign('totalSize', $result->totalSize);
        return $this->render("v2/admin/shenhe_log.html");
    }
}

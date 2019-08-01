<?php
//wdm，公用一些函数
class api_common {
    static public function getUserNameByList($list) {
        if (!is_array($list) || count($list) == 0 ) 
            return ;
        
        $value = '';
        $end = count($list) - 1;
        $i = 0;
        foreach ( $list as $val){
            $value .= $val;
            if ($i != $end) {
                $value .= ', ';
            }
            $i++;
        }

        $table = 'adp_user_info';
        $where = ' where `uid` in ( '.$value.' )';
        $sql = 'select `uid`, `user_name` from ' . $table . $where.';';

        $db = new SDb();
        $db->useConfig('adp');
        $data = $db->execute($sql);

        $result = array();
        foreach ($data as $item) {
            $result[$item['uid']] = $item['user_name'];
        }
        return $result;
    }

    static public function getPlanNameByList($list) {
        if (!is_array($list) || count($list) == 0 ) 
            return ;
        $value = '';
        $end = count($list) - 1;
        $i = 0;
        foreach ( $list as $val){
            $value .= $val;
            if ($i != $end) {
                $value .= ', ';
            }
            $i++;
        }

        $table = 'adp_plan_info';
        $where = ' where `plan_id` in ( '.$value.' )';
        $sql = 'select `plan_id`, `plan_name` from ' . $table . $where.';';

        $db = new SDb();
        $db->useConfig('adp');
        $data = $db->execute($sql);

        $result = array();
        foreach ($data as $item) {
            $result[$item['plan_id']] = $item['plan_name'];
        }
        return $result;
    }

    static public function getStuffNameByList($list) {
        if (!is_array($list) || count($list) == 0 ) 
            return ;
        $value = '';
        $end = count($list) - 1;
        $i = 0;
        foreach ( $list as $val){
            $value .= $val;
            if ($i != $end) {
                $value .= ', ';
            }
            $i++;
        }

        $table = 'adp_stuff_info';
        $where = ' where `stuff_id` in ( '.$value.' )';
        $sql = 'select `stuff_id`, `name` from ' . $table . $where.';';

        $db = new SDb();
        $db->useConfig('adp');
        $data = $db->execute($sql);

        $result = array();
        foreach ($data as $item) {
            $result[$item['stuff_id']] = $item['name'];
        }
        return $result;
    }
}
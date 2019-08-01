<?php
class area_db{
    public static function InitDB() {
        $db = new SDb();
		$db->useConfig("rmc");
        return $db;
    }
	/**
	 * 获取所有地区
	 * */
	 //select id,parent_id,area_name,area_type,area_level from rmc_area  order by display_order;
	public static function listArea($pid=0){
		$condi=array("id>10000000","id<90000000");
		if(!empty($pid)){
		$condi['parent_id']=$pid;
		}
		$table=array("rmc_area");
		$item=array("id","parent_id","area_name","level","region_name");
		$db = self::InitDB();
		return $db->select($table,$condi,$item,$grp="",$order="");
	}
}

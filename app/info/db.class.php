<?php
class info_db{
    public static function InitDB() {
        $db = new SDb();
		$db->useConfig("adp");
        return $db;
    }
	public static function getStuffByAid($aid){
		$table=array("adp_ad_info","adp_stuff_info");
		$condi=array("adp_ad_info.adid"=>$aid,"adp_ad_info.adid=adp_stuff_info.adid");
		$db = self::InitDB();
		return self::InitDB()->selectOne($table,$condi);
	}
	
    public static function InitSspDB() {
        $db = new SDb();
		$db->useConfig("ssp");
        return $db;
    }
	public static function getSlotById($slotId){
		//$table = array("adp_ad_info","adp_stuff_info");
		//$condi = array("adp_ad_info.adid"=>$aid,"adp_ad_info.adid=adp_stuff_info.adid");
		$table = array("ssp_slot");
		$condi = array("ssp_slot.slot_id"=>$slotId);
		$db = self::InitSspDB();
		$data = $db->selectOne($table,$condi);
		return($data);
	}
	public static function getAdsBySlotId($slotId, $type = 0){
	    $slotData = self::getSlotById($slotId);
	    if(isset($slotData['width']) && isset($slotData['height'])){
	        $table=array("adp_ad_info","adp_stuff_info");  
	        $condi=array("adp_ad_info.width" => $slotData['width'], "adp_ad_info.height" => $slotData['height'], "adp_ad_info.adid=adp_stuff_info.adid");
	        if($type == 1){
	            $condi['adp_stuff_info.type'] = 1;
	        }
	        
	        $db = self::InitDB();
	        $data = $db->select($table,$condi);
	        $data = (array)$data;
	        
	        if(is_array($data['items'])){
	            $ads = $data['items'];
	            return $ads;
	        }else{
	            return false;
	        }
	    }else{
            return false;
        }
	}
	
}


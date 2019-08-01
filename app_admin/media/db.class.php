<?php
class media_db{
    public static function InitDB($dbname="rmc") {
        $db = new SDb();
		$db->useConfig($dbname);
        return $db;
    }
	/**
	 * 获取受众人群
	 * */
	public static function listMedia($condi,$Page=1,$Limit=300){
		foreach($condi as $k=>$v){
		if(empty($v))unset($condi[$k]);
		}
		$table=array("rmc_bj_media");
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->select($table,$condi);
	}
	public static function listMediaCategory(){
		$table=array("rmc_mp_media");
		$db = self::InitDB();
		$db->setPage(1);
		$db->setLimit(-1);
		return $db->select($table,array(),"category","category");
	}
	public static function listMediaType(){
		$table=array("rmc_mp_media");
		$db = self::InitDB();
		$db->setPage(1);
		$db->setLimit(-1);
		return $db->select($table,array(),"type","type");
	}
	public static function listMediaLocation(){
		$table=array("rmc_mp_media");
		$db = self::InitDB();
		$db->setPage(1);
		$db->setLimit(-1);
		return $db->select($table,array(),"location","location");
	}
	public static function listMediaDistinct($condi,$Page=1,$Limit=300){
		foreach($condi as $k=>$v){
		if(empty($v))unset($condi[$k]);
		}
		$table=array("rmc_mp_media");
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->select($table,$condi,"*","domain_name");
	}
	public static function getMedia($id){
		$table=array("rmc_bj_media");
		$condi=array("id"=>$id);
		$db = self::InitDB();
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->selectOne($table,$condi);
	}
	public static function updateMedia($id,$Media=array()){
		$table=array("rmc_bj_media");
		$condi=array("id"=>$id);
		$db = self::InitDB();
		return $db->update($table,$condi,$Media);
	}
	public static function addMedia($Media=array()){
		$table=array("rmc_bj_media");
		$db = self::InitDB();
		return $db->insert($table,$Media);
	}
	//website
	public static function getWebSite($id){
		$table=array("ssp_bj_channel");
		$condi=array("channel_id"=>$id);
		$db = self::InitDB("ssp");
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->selectOne($table,$condi);
	}
	public static function updateWebSite($id,$WebSite=array()){
		$table=array("ssp_bj_channel");
		$condi=array("channel_id"=>$id);
		$db = self::InitDB("ssp");
		return $db->update($table,$condi,$WebSite);
	}
	public static function addWebSite($WebSite=array()){
		$table=array("ssp_bj_channel");
		$db = self::InitDB("ssp");
		return $db->insert($table,$WebSite);
	}
	public static function listWebSite($condi,$Page=1,$Limit=300){
		foreach($condi as $k=>$v){
		if(empty($v))unset($condi[$k]);
		}
		$table=array("ssp_bj_channel");
		$db = self::InitDB("ssp");
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->select($table,$condi);
	}
	public static function updateWebSiteSlotCt($website_id){
		$table=array("ssp_bj_channel");
		$condi=array("website_id"=>$website_id);
		$item[]="slot_ct = (select count(*) from ssp_slot where ssp_slot.website_id=ssp_website.website_id)";
		$db = self::InitDB("ssp");
		return $db->update($table,$condi,$item);
	}
	//slot
	public static function getSlot($id){
		$table=array("ssp_position");
		$condi=array("id"=>$id);
		$db = self::InitDB("ssp");
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->selectOne($table,$condi);
	}
	public static function updateSlot($id,$Slot=array()){
		$table=array("ssp_position");
		$condi=array("id"=>$id);
		$db = self::InitDB("ssp");
		return $db->update($table,$condi,$Slot);
	}
	public static function addSlotNetwork($SlotWork=array()){
		$table=array("ssp_slot_adnetwork");
		$db = self::InitDB("ssp");
		return $db->insert($table,$SlotWork,true);
	}
	public static function getSlotNetwork($slot_id,$network_id){
		$table=array("ssp_slot_adnetwork");
		$db = self::InitDB("ssp");
		$condi = array("slot_id"=>$slot_id,"network_id"=>$network_id);
		$db->setLimit(-1);
		return $db->selectOne($table,$condi);
	}
	public static function addSlot($Slot=array()){
		$table=array("ssp_position");
		$db = self::InitDB("ssp");
		return $db->insert($table,$Slot);
	}
	public static function listSlot($condi,$Page=1,$Limit=300){
		$condi=array();
		$table=array("ssp_position");
		$db = self::InitDB("ssp");
		$db->setPage($Page);
		$db->setLimit($Limit);
		return $db->select($table,$condi);
	}
	public static function listAdNetWork(){
		$table=array("ssp_adnetwork");
		$db = self::InitDB("ssp");
		$db->setLimit(-1);
		return $db->select($table);
	}
	public static function listSlotBanDSP($slot_id){
		$table=array("ssp_slot_ban_dsp");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id);
		return $db->select($table,$data);
	}
	public static function listSlotBanCategory($slot_id){
		$table=array("ssp_slot_ban_category");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id);
		return $db->select($table,$data);
	}
	public static function listSlotBanURL($slot_id){
		$table=array("ssp_slot_ban_url");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id);
		return $db->select($table,$data);
	}
	public static function addSlotBanDSP($slot_id,$dsp_id){
		$table=array("ssp_slot_ban_dsp");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id,"dsp_id"=>$dsp_id);
		return $db->insert($table,$data,true);
	}
	public static function addSlotBanURL($slot_id,$url){
		$table=array("ssp_slot_ban_url");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id,"ban_url"=>$url);
		return $db->insert($table,$data,true);
	}
	public static function delSlotBanURL($slot_id,$url){
		$table=array("ssp_slot_ban_url");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id,"ban_url"=>$url);
		return $db->delete($table,$data);
	}
	public static function addSlotBanCategory($slot_id,$cate_id){
		$table=array("ssp_slot_ban_category");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id,"cate_id"=>$cate_id);
		return $db->insert($table,$data,true);
	}
	public static function delSlotBanCategory($slot_id,$cate_id){
		$table=array("ssp_slot_ban_category");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id,"cate_id"=>$cate_id);
		return $db->delete($table,$data);
	}
	public static function delSlotBanDSP($slot_id,$dsp_id){
		$table=array("ssp_slot_ban_dsp");
		$db = self::InitDB("ssp");
		$data=array("slot_id"=>$slot_id,"dsp_id"=>$dsp_id);
		return $db->delete($table,$data);
	}
	public static function updateSlotCache($slot_id){
		$ssp_main = new thrift_ssp_main;//主要用来加载自动的类
		$SlotData = new SlotData;
		$WebSite = new WebSite;
		$slot = self::getSlot($slot_id);
		if(!empty($slot)){
			foreach($SlotData as $k=>$v){
				if(isset($slot[$k])){
				    $SlotData->$k=$slot[$k];
				}
			}
			//获取屏蔽的DSP
			$ban_dsps= media_db::listSlotBanDSP($slot_id);
			$dsps=array();
			if(!empty($ban_dsps->items)){
				foreach($ban_dsps->items as $item){
					$dsps[]=$item['dsp_id'];
				}
			}
			$SlotData->ban_dsp=$dsps;
			//BAN 分类
			$ban_cates= media_db::listSlotBanCategory($slot_id);
			$cates=array();
			if(!empty($ban_cates->items)){
				foreach($ban_cates->items as $item){
					$cates[]=$item['cate_id'];
				}
			}
			$SlotData->ban_category =$cates;
			//BAN URL
			$ban_urls = media_db::listSlotBanURL($slot['slot_id']);
			$urls=array();
			if(!empty($ban_urls->items)){
				foreach($ban_urls->items as $item){
					$urls[]=$item['ban_url'];
				}
			}
			$SlotData->ban_urls=$urls;
			/*
			$website=self::getWebSite($slot['website_id']);
			foreach($WebSite as $k=>$v){
				if(isset($website[$k]))$WebSite->$k=$website[$k];
			}
			*/
			//获取流量分配
			$ad_network=array();
			foreach(media_network::$media as $network_id => $network_name){
				$SspSlotAdnetwork = new SspSlotAdnetwork;
				$network = media_db::getSlotNetwork($slot_id,$network_id);
				foreach($SspSlotAdnetwork as $k=>$v){
					if(isset($network[$k]))$SspSlotAdnetwork->$k=$network[$k];
				}
				$SspSlotAdnetwork->network_code=preg_replace("/\n|\r|  /","",$SspSlotAdnetwork->network_code);
				$ad_network[]=$SspSlotAdnetwork;

			}
			$SlotData->ad_network=$ad_network;

		}
		$table=array("ssp_slot_cache");
		$db = self::InitDB("ssp");
		$slotDataBinary = Thrift\Serializer\TBinarySerializer::serialize($SlotData);
		$slotDataJson = json_encode($SlotData,JSON_NUMERIC_CHECK);
		$Cache=array("slot_id"=>$slot_id,"slot_data"=>$slotDataBinary,"slot_data_json"=>$slotDataJson);
		return $db->insert($table,$Cache,true);
	}
	public static function getSlotCache($slot_id){
		$ssp_main = new thrift_ssp_main;//主要用来加载自动的类
		$table=array("ssp_slot_cache");
		$db = self::InitDB("ssp");
		$data = $db->selectOne($table,array("slot_id"=>$slot_id));
		$SlotData = new SlotData;
		if(isset($_GET['type'])){
		    print_r(Thrift\Serializer\TBinarySerializer::deserialize($data['slot_data'],"SlotData"));
		}else{
		    print_r(json_decode($data['slot_data_json']));
		}
	}
	public static function listAdCate(){
		$table=array("ad_cate");
		$db = self::InitDB("adp");
		$result = $db->select($table);
		$cates=array();
		foreach($result->items as $item){
			$name = $item['cate_name'];
			if(empty($cates[$name])){
				$cates[$name][]=$item;
			}else{
				$cates[$name][]=$item;
			}
		}
		return $cates;
	}
}


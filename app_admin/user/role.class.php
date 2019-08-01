<?php
/** 用户类型 **/
/*征用adp_user_info.colum1字段类型*/
class user_role{
	const ROLE_ADVERTISER	=0x01;	//广告主
	const ROLE_WEBSITE		=0x02;	//网站主
	const ROLE_DSP			=0x04;	//DSP接入商
	const ROLE_Operator		=0x08;	//运营商
	static $roles = array(1=>"广告主",2=>"网站主",4=>"DSP接入商",8=>"运营商");
	static $roleCode = array(1=>"advertiser", 2=>"webmaster", 4=>"dsp", 8=>"operator" , 15=>"admin");
	static $generalRole = array(1,2,4,8,15);
	
	public static function getRoleByColum($columId){
	    if(isset(self::$roleCode[$columId])){
	        return self::$roleCode[$columId];
	    }else{
	        return "noRole";
	    }
	}
}

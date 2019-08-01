<?php
function tpl_modifier_tostring($mixed){
	return var_export($mixed,true);
}
function tpl_modifier_tr($string,$zone="main"){
	return SLanguage::tr($string,$zone);
}
function tpl_modifier_default($input,$default=""){
	return empty($input)?$default:$input;
}
function tpl_modifier_version($string,$version="1.0") {
    return $string."?".$version;
}
function tpl_modifier_wordbraek($string,$break_len=20,$suffix="...",$multibyte=true){
    if(!$multibyte) return strlen($string)<$break_len?  $string:substr($string,0,$break_len).$suffix;
    return mb_strlen($string)<$break_len?  $string:mb_substr($string,0,$break_len).$suffix;
}
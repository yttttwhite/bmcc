<?php
/* cookie mapping jsonp*/
/* 主网站cookie到媒体网站种cookie*/
class stat_cookie{
	public function pageEntry($inPath){
		$time = time()+360*24*3600;
		$domain=".bcdata.com.cn";
		if(!empty($_COOKIE['bcdata_sid'])){
		}else{
			$_COOKIE['bcdata_sid']=md5(time().":".rand(1,100000000));
		}
		setcookie("bcdata_sid",$_COOKIE['bcdata_sid'],$time,"/",$domain);

		if(!empty($_COOKIE['bcdata_part_sid'])){
		}else{
			$_COOKIE['bcdata_part_sid']=md5(time().":".rand(1,100000000));
		}
		setcookie("bcdata_part_sid",$_COOKIE['bcdata_part_sid'],$time,"/",$domain);
		echo <<<DDD
function getRealDomain(domains){
	var redomain = '';
	var domainArray      =     new Array("com" , "net" , "org"  , "gov" , "edu");
	var domains_array     =     domains.split('.');
	var domain_count      =     domains_array.length-1;
	var flag = false;
	if(domains_array[domain_count]=='cn' || domains_array[domain_count]=='tw'){
		for(i=0;i<domainArray.length;i++){
			if(domains_array[domain_count-1] == domainArray[i]){
				flag =true;
				break;
			}
		}
		if(flag==true){
			redomain = domains_array[domain_count-2]+"."+domains_array[domain_count-1]+"."+domains_array[domain_count];
		}else{
			redomain = domains_array[domain_count-1]+"."+domains_array[domain_count];
		}
	}else{
		redomain = domains_array[domain_count-1]+"."+domains_array[domain_count];
	}
	return redomain;
}
var domain = getRealDomain(location.host);
DDD;
		echo "document.cookie='bcdata_sid={$_COOKIE['bcdata_sid']}; domain='+domain+'; path=/; expires=".(gmdate('D, d M Y H:i:s \G\M\T',$time))."';\n";
		echo "document.cookie='bcdata_part_sid={$_COOKIE['bcdata_part_sid']}; domain='+domain+'; path=/; expires=".(gmdate('D, d M Y H:i:s \G\M\T',$time))."';\n";
	}

}

<?php
date_default_timezone_set('Asia/Chongqing');
$a='{sn:"ads54149426",data:{aid:1683,spid:"sohu",atype:3,has_text:0,w:728,h:90,show_js:"https://ads.bcdata.com.cn/show.js",click_js:"https://ads.bcdata.com.cn/click.js",third_show_js:"<script src=\"https://v1.cnzz.com/z_stat.php?id=1000274726&web_id=1000274726\" language=\"JavaScript\"></script>",third_click_js:"<script src=\"https://v1.cnzz.com/z_stat.php?id=1000274728&web_id=1000274728\" language=\"JavaScript\"></script>",src:1,pushid:"36fac8323d3480c2c2866f851796f2d",staff:[{"addr":"https://stuff.bcdata.com.cn/5355fc52000000000000000003bb3000","adid":1683,"crop":"","ctime":1392268627,"desc":"","enabled":"RUNNING","group_id":0,"group_name":"","height":90,"landing_page":"https://www.zhongjiu.cn/cpsCommon/adCommon/AdRedirect.aspx?from_url=https://www.zhongjiu.cn/Special/year2014.htm&sign=baichuan","media_name":"","mtime":1392268627,"name":"","plan_id":0,"plan_name":"","setAddr":true,"setAdid":true,"setCrop":false,"setCtime":true,"setDesc":false,"setEnabled":true,"setGroup_id":false,"setGroup_name":false,"setHeight":true,"setLanding_page":true,"setMedia_name":false,"setMtime":true,"setName":false,"setPlan_id":false,"setPlan_name":false,"setSize":true,"setStuff_id":true,"setThumb":false,"setTitle":false,"setType":true,"setUid":true,"setVerified_or_not":false,"setVersion":false,"setWidth":true,"size":0,"stuff_id":1700,"thumb":"","title":"","type":"AD_IMAGE","uid":27,"verified_or_not":0,"version":0,"width":728}],view_type:3}}';
$size = 0;
$hosts=array(
		'115.29.173.86',
		'112.124.65.153',
		'112.124.33.66',
		'112.124.60.20',
		'112.124.65.47',
		'112.124.33.110',
		'112.124.65.86',
		'112.124.65.221',
		'115.29.174.6',
		'112.124.60.127',
		'115.29.188.63',
		'115.29.175.16',
		'115.29.173.96',
		'115.29.173.59',
		'115.29.173.75',
		'112.124.65.119',
		'10.161.165.65',
		'10.160.4.31',
		'10.160.37.149',
		'10.160.57.88',
		'10.160.65.20',
		'10.160.37.15',
		'10.160.65.237',
		'10.160.16.190',
		'10.161.167.143',
		'10.160.50.213',
		'10.161.167.149',
		'10.161.167.148',
		'10.161.165.64',
		'10.161.165.67',
		'10.161.165.66',
		'10.160.64.219',

		);
foreach($hosts as $host){
	$url = "https://$host/info.js?sn=ads54149426&aid=1683&spid=sohu&src=1&pushid=36fac8323d3480c2c2866f851796f2d&url=https%3A//www.tszww.com/files/article/html/2/2223/259034.html";
	echo "测试开始[";
	echo date("Y-m-d H:i:s")."]\t";
	echo "主机:$host\t";
	$start = microtime(true);
	$ct = @file_get_contents($url);
	$end = microtime(true);
	$time = number_format($end-$start,3);
	$size2 = strlen($ct);
	echo "时间:{$time}秒\t文件大小:{$size2}\t";
	if($size>0){
		if($size!=$size2){
			echo "文件大小不匹配!!!";
		}
	}
	$size = $size2;
	echo "\n";
}

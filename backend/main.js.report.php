<?php
$result=array();
$aid="";
if(!empty($argv[1])){
	$path = $argv[1];
}else{
	$path="/data/log/".@date("Ymd")."/";
}
if(!empty($argv[2])){
	$aid = " | grep '{sp:{$argv[2]}}' ";
}
echo "\n统计目录: $path $aid 的数据如下:\n";
@mkdir("/data/tmp/");
exec("cat $path/info_log_* |grep -v cms |grep -v 'ads89.bcdata.com.cn' | grep -v 'ads78.bcdata.com.cn' | grep -v 'ads119.bcdata.com.cn' $aid > /data/tmp/x.log");
exec('cat /data/tmp/x.log | grep "{type:start}" | wc -l	',$out1,$ret);
$result["main.js开始执行,加载info.js\t\t"]	=	$out1[0];

exec('cat /data/tmp/x.log | grep "{type:loaded}" | wc -l	',$out2,$ret);
$result["浏览器加载成功info.js\t\t\t"]	=	$out2[0];

exec('cat /data/tmp/x.log | grep "show error" | wc -l	',$out3,$ret);
$result["info.js里的前端错误(show error)\t\t"]	=	$out3[0];

exec('cat /data/tmp/x.log | grep "get span error" | wc -l	',$out3_2,$ret);
$result["info.js里的前端错误(get span error)\t"]	=	$out3_2[0];

#exec('cat /data/tmp/x.log | grep "{type:empty staff}" | wc -l	',$out4,$ret);
#$result["info.js总的错误数据(废弃)\t\t"]	=	$out4[0];
exec('cat /data/tmp/x.log | grep "{type:empty staff(0)}" | wc -l	',$out4,$ret);
$result["info.js empty staff(0) 文件内容为空\t"]	=	$out4[0];//."\t有可能是ads域名被墙，也有可能出现js错误";

exec('cat /data/tmp/x.log | grep "{type:empty staff(1)}" | wc -l	',$out5,$ret);
$result["info.js empty staff(1) Info为空\t\t"]	=	$out5[0]."\t有可能info.js加载超时，info.js内容为空，或者js错误";

exec('cat /data/tmp/x.log | grep "{type:empty staff(2)}" | wc -l	',$out6,$ret);
$result["info.js empty staff(2) Info.data为空\t"]	=	$out6[0];

exec('cat /data/tmp/x.log | grep "{type:empty staff(3)}" | wc -l	',$out7,$ret);
$result["info.js empty staff(3) Info.data.staff为空\t"]	=	$out7[0]."\t典型的取不出广告内容的错误";

exec('cat /data/tmp/x.log | grep "type error" | wc -l	',$out8,$ret);
$result["info.js里的素材类型错误(type不为1，2，8）\t"]	=	$out8[0];

exec('cat /data/tmp/x.log | grep "{type:show ok}" | wc -l	',$out9,$ret);
$result["最终成功显示广告\t\t\t\t"]	=	$out9[0];

//exec('cat /data/tmp/x.log | grep "{type:error}" | wc -l	',$out10,$ret);
//$result["Script Error\t\t\t\t"]	=	$out10[0]."\t浏览器脚本错误，有可能是我们引起的，也有可能是别人";

exec('cat /data/tmp/x.log | grep "showjs start" | wc -l	',$out11,$ret);
$result["显示js计数器开始计数\t\t\t"]	=	$out11[0];

exec('cat /data/tmp/x.log | grep "showjs ok" | wc -l	',$out12,$ret);
$result["显示js计数器计数成功\t\t\t"]	=	$out12[0];

exec('cat /data/tmp/x.log | grep "clickjs start" | wc -l	',$out13,$ret);
$result["点击js计数器开始计数\t\t\t"]	=	$out13[0];

exec('cat /data/tmp/x.log | grep "clickjs ok" | wc -l	',$out14,$ret);
$result["点击js计数器计数成功\t\t\t"]	=	$out14[0];
exec('rm -rf /data/tmp/x.log');
/*
我这边总的成功率是 147540/151131					97.62%
请求info.js的失败率（总的）：(151131 - 149254 + 1448)/151131  =		2.20%
请求info.js的失败率（网络加载失败）：(151131 - 149254)/151131  =	1.24%
请求info.js的失败率（数据为空）： 1448/151131  =			0.96%
有效广告显示成功率为 ： 147540/(149254 - 1448)				99.820%  !!!!!!!!!!!!!!!!!!!

showjs 加载错误率 146903/147597						0.47%

点击率： 9/147597							0.006%
有效率点击率：	7/147597						0.005%

*/

$result["请求info.js的失败率（总的）\t\t"]	=	@number_format( (($out1[0]-$out2[0]) + $out4[0]+ $out5[0] + $out6[0] + $out7[0] + $out8[0])*100/$out1[0],2)."%";
$result["请求info.js的失败率（网络）\t\t"]	=	@number_format(  ($out1[0]-$out2[0])*100/$out1[0],2)."%";
$result["请求info.js的失败率（内网）\t\t"]	=	@number_format(  ( $out4[0] + $out5[0] + $out6[0] + $out7[0] + $out8[0])*100/$out1[0],2)."%";

$result["有效内容成功率\t\t\t\t"]	=	@number_format($out9[0]*100 / ($out2[0] - $out4[0] - $out5[0] - $out6[0] - $out7[0] - $out8[0]),2)."%";
$result["点击率！！！！\t\t\t\t"]       =       @number_format($out14[0]*100/$out12[0],2)."%";
$result["总成功率！！！\t\t\t\t"]	=	@number_format($out12[0]*100/$out1[0],2)."%";

print_r($result);


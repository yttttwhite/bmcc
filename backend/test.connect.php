<?php
function getCt($ct){
	preg_match("/\d+ \d+ (\d+)/msi",$ct,$_all);
	print_R($_all);
	return $_all[1];
}
$url = "https://admin.bcdata.com.cn/status/";
$time_1 = microtime(true);
$ct  = getCt(file_get_contents($url));
sleep(10);
$time_2 = microtime(true);
$ct2  = getCt(file_get_contents($url));
echo "\nTotal:".($ct2-$ct);
echo "\nAverage Per Sec:".($ct2-$ct)/10;
echo "\n";

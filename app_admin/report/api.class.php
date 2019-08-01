<?php
class report_api{
	public static function getCostToday($uid){
		$a = new thrift_report_main;
		$query = new queryOptions;
		$query->startAt=date("Ymd");
		$query->endAt=date("Ymd");
		$query->id=$uid;
		return $a->getCostByUid($query);
	}
}

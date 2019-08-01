<?php
/*
interface ReportServiceIf {
  public function AdReportByAdid(\QueryOptions $q, \PageOptions $p);
  public function AdReportByGroupId(\QueryOptions $q, \PageOptions $p);
  public function GroupReportByPlanId(\QueryOptions $q, \PageOptions $p);
  public function PlanReportByUid(\QueryOptions $q, \PageOptions $p);
  public function getCostByUid(\QueryOptions $q);
  public function AreaByAdid(\QueryOptions $q, \PageOptions $p);
  public function AreaByGid(\QueryOptions $q, \PageOptions $p);
  public function AreaByPid(\QueryOptions $q, \PageOptions $p);
  public function AreaByUid(\QueryOptions $q, \PageOptions $p);
  public function DayByAdid(\QueryOptions $q, \PageOptions $p);
  public function DayByGid(\QueryOptions $q, \PageOptions $p);
  public function DayByPid(\QueryOptions $q, \PageOptions $p);
  public function DayByUid(\QueryOptions $q, \PageOptions $p);
  public function SourceByAdid(\QueryOptions $q, \PageOptions $p);
  public function SourceByGid(\QueryOptions $q, \PageOptions $p);
  public function SourceByPid(\QueryOptions $q, \PageOptions $p);
  public function SourceByUid(\QueryOptions $q, \PageOptions $p);
  public function HourByAdid(\QueryOptions $q, \PageOptions $p);
  public function HourByGid(\QueryOptions $q, \PageOptions $p);
  public function HourByPid(\QueryOptions $q, \PageOptions $p);
  public function HourByUid(\QueryOptions $q, \PageOptions $p);
  public function HostByAdid(\QueryOptions $q, \PageOptions $p);
  public function HostByGid(\QueryOptions $q, \PageOptions $p);
  public function HostByPid(\QueryOptions $q, \PageOptions $p);
  public function HostByUid(\QueryOptions $q, \PageOptions $p);
  public function AdspaceByAdid(\QueryOptions $q, \PageOptions $p);
  public function AdspaceByGid(\QueryOptions $q, \PageOptions $p);
  public function AdspaceByPid(\QueryOptions $q, \PageOptions $p);
  public function AdspaceByUid(\QueryOptions $q, \PageOptions $p);
  public function CostsByUidV2(\QueryOptions $q, \PageOptions $p);
  public function ping($ignoreme);
}
*/
class dc_api{
	static public function __callStatic($name,$args){
		$start = date("Ymd",strtotime($args[1]));
		$end = date("Ymd",strtotime($args[2]));
		$a = new thrift_report_main;
		$page = new pageOptions;
		$page->pageSize = 1000;

		$para = new queryOptions;
		$para->id = $args[0];//$uid;
		$para->startAt = $start;
		$para->endAt= $end;
		$r = $a->$name($para,$page);
		return $r;
	}
}

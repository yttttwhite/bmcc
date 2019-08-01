<?php
class report_main extends STpl{
	/**获取报表数据的ajax接口*/
	public function pageData($inPath){
		$start= empty($_REQUEST['start'])?date("Ymd",time()-30*24*3600):date("Ymd",strtotime($_REQUEST['start']));
		$end  = empty($_REQUEST['end'])?date("Ymd",time()):date("Ymd",strtotime($_REQUEST['end']));
		$a = new thrift_report_main;
		$page = new pageOptions;
		$page->pageSize = (strtotime($end)-strtotime($start))/3600/24+1;
		$para = new queryOptions;
		$para->startAt = $start;
		$para->endAt= $end;
		$r = new reportResult;
		$type="plan";
		//{{{
		$areas=array();
		$areas_tmp = area_db::listArea();
		foreach($areas_tmp->items as $area){
			$id = $area['id'];
			if(empty($area['parent_id'])){
				$areas[$id]=$area['area_name'];
			}else{
				foreach($areas_tmp->items as $area2){
					if($area2['id']==$area['parent_id']){
						$areas[$id]=$area2['area_name'];
						break;
					}
				}
			}
		}
		//}}}
		if(!empty($_REQUEST['gid'])){
			$para->id = $_REQUEST['gid'];
			$r=$a->AdReportByGroupId($para,$page);
			$r=$a->DaybyGid($para,$page);
		}elseif(!empty($_REQUEST['pid'])){
			$para->id = $_REQUEST['pid'];
			$r=$a->DaybyPid($para,$page);
			$page2 = new pageOptions;
			$page2->pageSize=-1;
			$r_area=$a->AreaByPid($para,$page2);
		}else{
			$para->id = user_api::id();
			$r=$a->DaybyUid($para,$page);
		}
		//{{{
		if(!empty($r_area->data)){
			foreach($r_area->data as &$data){
				$id = $data->id;
				if(!empty($areas[$id])){
					$data->area_name = $areas[$id];
				}else{
					$data->area_name = "其它";
				}
			}
			$area_show=array();
			foreach($r_area->data as $data){
				$id=$data->area_name;
				$area_show[$id]+=$data->show;;
			}
		}
		//}}}
		$result=$this->data2json($r,$area_show);
		return SJson::encode($result);
	}
	private function data2json($r,$r_area){
		$result=new stdclass;
		$result->cate=array();
		$result->data=array();

		//get cate
		if(!empty($r->data)){
			foreach($r->data as $item){
				$result->cate[]=$item->id;
			}
		}

		//get name
		if(!empty($r->data)){
			foreach($r->data as $item){

				foreach($item as $k=>$v){
					if($k=="id" || $k=="push" || $k=="bid" || $k=="bidres" || $k=="selfcost")continue;
					$tmp=new stdclass;
					$tmp->name=$k;
					$tmp->data=array();
					$result->data[$k]=$tmp;
				}
				break;
			}
		}
		if(!empty($r->data)){
			foreach($r->data as $day=>$item){
				foreach($item as $k=>$v){
					if($k=="id" || $k=="push" || $k=="bid" || $k=="bidres" || $k=="selfcost")continue;
					if($k=="show"){$v=$v/1000;}
					if($k=="cost"){
						$result->data[$k]->type="spline";
					}
					if(is_numeric($v)) $v=floatval($v);
					$result->data[$k]->data[]=$v;
				}
			}
			//获取媒体信息
			//增加一个饼图
			if(!empty($r_area)){
				$k++;
				$data = new stdclass;
				$data->type="pie";
				$data->name="show";
				$data->size=130;
				$data->showInLegend=false;
				$data->center=array(100,80);
				$data->data=array();
				foreach($r_area as $area=>$show){
					$item=array("name"=>$area,"y"=>$show);
					$data->data[]=$item;//tmp->show;
				}
				$result->data[$k]=$data;
			}
			/*
			$item=array("name"=>"x1","y"=>3);
			$data->data[]=$item;
			$item=array("name"=>"x1","y"=>3);
			$data->data[]=$item;
			$item=array("name"=>"x1","y"=>4);
			$data->data[]=$item;
			*/
		}
		sort($result->data);
		return($result);
	}
	public function pageDataEcharts($inPath){
		$start= empty($_REQUEST['start'])?date("Ymd",time()-30*24*3600):date("Ymd",strtotime($_REQUEST['start']));
		$end  = empty($_REQUEST['end'])?date("Ymd",time()):date("Ymd",strtotime($_REQUEST['end']));
		$a = new thrift_report_main;
		$page = new pageOptions;
		$page->pageSize = (strtotime($end)-strtotime($start))/3600/24+1;
		$para = new queryOptions;
		$para->startAt = $start;
		$para->endAt= $end;
        $para->id = $_REQUEST['id'];
		$r = new reportResult;
		$type="plan";
		//{{{
		$areas=array();
		$areas_tmp = area_db::listArea();
		foreach($areas_tmp->items as $area){
			$id = $area['id'];
			if(empty($area['parent_id'])){
				$areas[$id]=$area['area_name'];
			}else{
				foreach($areas_tmp->items as $area2){
					if($area2['id']==$area['parent_id']){
						$areas[$id]=$area2['area_name'];
						break;
					}
				}
			}
		}
		//}}}
		 if(!empty($_REQUEST['gid'])){
			$para->id = $_REQUEST['gid'];
			$r=$a->AdReportByGroupId($para,$page);
			$r=$a->DaybyGid($para,$page);
		}elseif(!empty($_REQUEST['pid'])){
			$para->id = $_REQUEST['pid'];
			$r=$a->DaybyPid($para,$page);
			$page2 = new pageOptions;
			$page2->pageSize=-1;
			$r_area=$a->AreaByPid($para,$page2);
		}else{
            if(empty($para->id) || $para->id ==1){
                $para->id = user_api::id();
                if(user_api::auth("admin")){
                    $para->id = 0;
                }
            }
            $info = user_api::info();
            if($info->role_id == "1000"){
                $para->id = 0;
            }
			$r=$a->DaybyUid($para,$page);
			 //echo "test2";
		}
        file_put_contents("/tmp/php-log.txt","\npara".var_export($para,true),FILE_APPEND);
        file_put_contents("/tmp/php-log.txt","\nresult".var_export($r,true),FILE_APPEND);
		$result=array();
		if(is_array($r->data)){
		    foreach($r->data as $item){
		        foreach($item as $k=>$v){
		            if($k=="show"){$v=$v/1000;}
		            if($k=="pv"){$v=$v/1000;}
		            if($k=="uv"){$v=$v/1000;}
		            if($k=="ipv"){$v=$v/1000;}
		            $result[$k][]=(float)$v;
		        }
		    }
		}
		return SJson::encode($result);
	}

	public function pageNavi($inPath) {
		return $this->render("header.report.navi");
	}
	public function pageEntry($inPath){
		return $this->render("html/report/guanggaobaobiao.html");
	}
	
	public function pageTotalReport($inPath){
		return $this->render("html/report/zonglan.html");
	}
	
	public function pageTimeReport($inPath){
		return $this->render("html/report/.html");
	}
	
	public function pageMediaReport($inPath){
		return $this->render("html/report/meitibaobiao.html");
	}
	
	public function pageAreaReport($inPath){
		return $this->render("html/report/diyubaobiao.html");
	}
	
	public function pageContentReport($inPath){
		return $this->render("html/report/.html");
	}
	
	public function pageAudienceReport($inPath){
		return $this->render("html/report/renqunbaobiao.html");
	}


}

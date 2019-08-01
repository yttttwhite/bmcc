<?php
class ad_api{
	static public function listPlans($status=0,$userId=0){
		$b = new thrift_adplan_main;
		$c = new thrift_adgroup_main;
		if ($userId == 0) {
		    $userId = user_api::id();
		}
		 $plans = $b->getAdPlansByBindid($userId);
		if(!empty($plans)){
			foreach($plans as $k=>$plan){
				if($plan->start_date!=0){
				$plan->start_date = date("Y-m-d",$plan->start_date);
				}
				if($plan->end_date!=0){
				$plan->end_date = date("Y-m-d",$plan->end_date);
				}
				$plans[$k]=$plan;
				if($status){
					 if($plan->enable!=$status)unset($plans[$k]);continue;
				}
			}
		}
		sort($plans);
		return $plans;
	}
	/***
	 * 通过bindid去查询广告计划
	 */
	static public function listPlansByBindid($status=0,$bindId=0){
	    $b = new thrift_adplan_main;
	    $c = new thrift_adgroup_main;
	    if ($userId == 0) {
	        $userId = user_api::id();
	    }
	    $plans = $b->getAdPlansByBindid($bindId);
	    if(!empty($plans)){
	        foreach($plans as $k=>$plan){
	            if($plan->start_date!=0){
	                $plan->start_date = date("Y-m-d",$plan->start_date);
	            }
	            if($plan->end_date!=0){
	                $plan->end_date = date("Y-m-d",$plan->end_date);
	            }
	            $plans[$k]=$plan;
	            if($status){
	                if($plan->enable!=$status)unset($plans[$k]);continue;
	            }
	        }
	    }
	    sort($plans);
	    return $plans;
	}
	
	/**
	 * 通过bindid去查询数据
	 */
	  static public function listPlansBindReport($start,$end,$status=0,$userId = 0){
	    $b = new thrift_adplan_main;
	    $c = new thrift_adgroup_main;
	    $a = new thrift_report_main;
	    $page = new pageOptions;
	    $para = new queryOptions;
	    $para->startAt = date("Ymd",strtotime($start));
	    $para->endAt= date("Ymd",strtotime($end));
	
	    if($userId === "all"){
	        $u = new thrift_aduser_main;
	        $users = $u->getAdUsersByCid(0,AccountStatus::ALL);
	        $plans = array();
	        foreach ($users as $user){
	            $plans = array_merge(self::listPlansByBindid($status,$user->uid),$plans);
	        }
	    }else{
	        $plans = self::listPlansByBindid($status,$userId);//$b->getAdPlansByUid(user_api::id());
	        //$para->id = user_api::id();
	        $para->id = $userId;
	        $reports = $a->PlanReportByUid($para,$page);
	        if(!empty($plans)){
	            foreach($plans as &$plan){
	                if(!empty($reports->data)){
	                    $report=new stdclass;
	                    foreach($reports->data as $item){
	                        if($item->id==$plan->plan_id){
	                            foreach($item as $k=>$v){
	                                if(!isset($report->$k)){$report->$k=$v;}
	                                else $report->$k+=$v;
	                            }
	                            $plan->report=$report;
	                            break;
	                        }
	                    }
	                }
	            }
	        }
	    }
	    return $plans;
	}
	static public function listPlansReport($start,$end,$status=0,$userId = 0){
		$b = new thrift_adplan_main;
		$c = new thrift_adgroup_main;
		$a = new thrift_report_main;
		$page = new pageOptions;
		$para = new queryOptions;
		$para->startAt = date("Ymd",strtotime($start));
		$para->endAt= date("Ymd",strtotime($end));
		
		if($userId === "all"){
		    $u = new thrift_aduser_main;
		    $users = $u->getAdUsersByCid(0,AccountStatus::ALL);
		    $plans = array();
		    foreach ($users as $user){
		        $plans = array_merge(self::listPlans($status,$user->uid),$plans);
		    }
		}else{
		    $plans = self::listPlans($status,$userId);//$b->getAdPlansByUid(user_api::id());
		    $para->id = user_api::id();
		    $reports = $a->PlanReportByUid($para,$page);
		    if(!empty($plans)){
		        foreach($plans as &$plan){
		            if(!empty($reports->data)){
		                $report=new stdclass;
		                foreach($reports->data as $item){
		                    if($item->id==$plan->plan_id){
		                        foreach($item as $k=>$v){
		                            if(!isset($report->$k)){$report->$k=$v;}
		                            else $report->$k+=$v;
		                        }
		                        $plan->report=$report;
		                        break;
		                    }
		                }
		            }
		        }
		    }
		}
		return $plans;
	}
	static public function listGroupsReport($plan_id,$start,$end,$status=0){
		$b = new thrift_adplan_main;
		$c = new thrift_adgroup_main;
		$a = new thrift_report_main;
		$page = new pageOptions;
		$para = new queryOptions;
		$para->startAt = date("Ymd",strtotime($start));
		$para->endAt= date("Ymd",strtotime($end));
		$groups = ad_api::listGroups($plan_id,$status);
		$para->id = $plan_id;
		$reports = $a->GroupReportByPlanId($para,$page);
		if(!empty($groups)){
			foreach($groups as &$group){
				if(!empty($reports->data)){
					$report=new stdclass;
					foreach($reports->data as $item){
						if($item->id==$group->group_id){
							foreach($item as $k=>$v){
								if(!isset($report->$k)){$report->$k=$v;}
								else $report->$k+=$v;
							}
							$group->report=$report;
							break;
						}
					}
				}
			}
		}
		return $groups;
	}
	static public function listAdsReport($group_id,$start,$end){
		$a = new thrift_report_main;
		$page = new pageOptions;
		$para = new queryOptions;
		$para->startAt = $start;//date("Ymd",strtotime($start));
		$para->endAt= $end;//date("Ymd",strtotime($end));
		$adinfo_api = new thrift_adinfo_main;
		$stuff_api = new thrift_stuffinfo_main;
		$ads = $adinfo_api->findAdInfoByGid($group_id);
		foreach($ads as $k=>&$ad){
			$stuffs= $stuff_api->getStuffsByAdid($ad->adid);
			if(empty($stuffs)){
			    unset($ads[$k]);
			}else{
			    $ad->stuff = $stuffs[0];
			}
			$para->id = $ad->adid;
			//$r=$a->AdReportByAdid($para,$page);
			if(!empty($r->data)){
				$report=new stdclass;
				foreach($r->data as $item){
					unset($item->id);
					foreach($item as $k=>$v){
						if(!isset($report->$k)){$report->$k=$v;}
						else $report->$k+=$v;
					}
				}
				$ad->report=$report;
			}
		}
		return $ads;
	}
	static public function listads($group_id){
		$a = new thrift_adinfo_main;
		//$b = new thrift_stuffinfo_main;
		$ads = $a->findAdInfoByGid($group_id);
		//foreach($ads as $k=>&$ad){
		//	$stuffs= $b->getStuffsByAdid($ad->adid);
		//	if(empty($stuffs))unset($ads[$k]);
		//	else $ad->stuff=$stuffs[0];
		//}
		return $ads;
	}
	static public function listGroups($plan_id,$status=0){
		$c = new thrift_adgroup_main;
		$groups = $c->findAdGroupByInt(array("plan_id"=>$plan_id));
		foreach($groups as $k=>$group){
			if($group->start_date!=0){
				$group->start_date = date("Y-m-d",$group->start_date);
			}
			if($group->end_date!=0){
				$group->end_date = date("Y-m-d",$group->end_date);
			}
			if($status && $group->enabled!=$status)unset($groups[$k]);
		}
		sort($groups);
		return $groups;
	}
	/**返回按地区位置，按1，2号城市划分**/
	static public function getArea_ByCity(){
		$a = new thrift_area_main;
		$b = $a->getAllIdName(0);
		$result=array("1"=>array(),"2"=>array());
		foreach($b as $_b){
			foreach($_b as $area){
				if($area->level==1 || $area->area_name=="北京" || $area->area_name=="上海"){
					$result[1][]=$area;
				}elseif($area->level==2){
					$result[2][]=$area;
				}
			}
		}
		return ($result);
	}
	/**返回按地区位置，如华东，东北等形式的数组**/
	static public function getArea_ByArea(){
		$a = new thrift_area_main;
		$b = $a->getAllIdName(0);
		$result=array();
		foreach($b as $_b){
			foreach($_b as $area){
				$regin=$area->region_name;
				if(empty($area->parent_id) || $area->parent_id<=0){
				$result[$regin][]=$area;
				}
			}
		}
		return ($result);
	}
	static public function listChildArea($pid){
		return area_db::listArea($pid);
	}

	public static function _prepare_list($post, $key) {
		$host_set_object = array();
		if(!empty($post[$key])){
			$host_set_object[$key] = preg_split("/[\r\n,;]/", $post[$key], -1, PREG_SPLIT_NO_EMPTY);
		}else{
			$host_set_object[$key] = array();
		}
		$include_host = array_merge($host_set_object[$key]);
		return implode(",", $include_host);
	}

	public static function group_host_encode(&$AdGroup,$post){
		$AdGroup->exclude_host = ad_api::_prepare_list($post, '_exclude_host');
		$AdGroup->include_host = ad_api::_prepare_list($post, '_include_host');
		$AdGroup->exclude_ip = ad_api::_prepare_list($post, '_exclude_ip');
		$AdGroup->include_ip = ad_api::_prepare_list($post, '_include_ip');
		$AdGroup->exclude_adsl = ad_api::_prepare_list($post, '_exclude_adsl');
		$AdGroup->include_adsl = ad_api::_prepare_list($post, '_include_adsl');
		$AdGroup->host_set_object = json_encode(array(
				"_exclude_host" => explode(',', $AdGroup->exclude_host),
				"_include_host" => explode(',', $AdGroup->include_host),
				"1" => "1"));
		return $AdGroup;

	}

	public static function group_useragent_encode(&$AdGroup,$post){
			$include_useragent_set_object = array();
			if(!empty($post['terminal'])){
				$include_useragent_set_object['terminal']= $post['terminal'];
			}else{
				$include_useragent_set_object['terminal']=array();
			}
			if(!empty($post['os'])){
				$include_useragent_set_object['os']= $post['os'];
			}else{
				$include_useragent_set_object['os']=array();
			}
			if(!empty($post['agent'])){
				$include_useragent_set_object['agent']=$post['agent'];
			}else{
				$include_useragent_set_object['agent']=array();
			}

		$include_useragent=array_merge($include_useragent_set_object['terminal'],$include_useragent_set_object['os'],$include_useragent_set_object['agent']);

		$AdGroup->include_useragent=implode(",",$include_useragent);
		$AdGroup->include_useragent_set_object=json_encode($include_useragent_set_object);
		return $AdGroup;

	}
	public static function group_host_decode(&$AdGroup){
		if(!empty($AdGroup->host_set_object)){
			$host_set_object = json_decode($AdGroup->host_set_object, true);
			$AdGroup->_include_host		= $host_set_object['_include_host'];
			$AdGroup->_exclude_host		= $host_set_object['_exclude_host'];
			$AdGroup->_include_media_id	= $host_set_object['_include_media_id'];
			$AdGroup->_exclude_media_id	= $host_set_object['_exclude_media_id'];
		}else{
			$host_set_object = array();
			$host_set_object['_include_host']=array();
			$host_set_object['_exclude_host']=array();
			$host_set_object['_include_media_id']=array();
			$host_set_object['_exclude_media_id']=array();
			$AdGroup->_include_host		= implode(',', $host_set_object['_include_host']);
			$AdGroup->_exclude_host		= implode(',', $host_set_object['_exclude_host']);
			$AdGroup->_include_media_id	= implode(',', $host_set_object['_include_media_id']);
			$AdGroup->_exclude_media_id	= implode(',', $host_set_object['_exclude_media_id']);
		}

		$AdGroup->exclude_ip   = explode(',', $AdGroup->exclude_ip);
		$AdGroup->include_ip   = explode(',', $AdGroup->include_ip);
		$AdGroup->exclude_adsl = explode(',', $AdGroup->exclude_adsl);
		$AdGroup->include_adsl = explode(',', $AdGroup->include_adsl);
	}
	public static function group_useragent_decode(&$AdGroup){
		if(!empty($AdGroup->include_useragent_set_object)){
			$include_useragent_set_object = json_decode($AdGroup->include_useragent_set_object,true);
		}else{
			$include_useragent_set_object = array();
			$include_useragent_set_object['terminal']=array();
			$include_useragent_set_object['os']=array();
			$include_useragent_set_object['agent']=array();
		}
//		$AdGroup->include_useragent=implode(',',array_merge($include_useragent_set_object['terminal'],$include_useragent_set_object['os'],$include_useragent_set_object['agent']));

	}
	/**
	 *提交素材信息到精分系统
	 * 获取当前已上传素材信息，素材id,业务素材名称，图片文件名及路径，点击跳转URL
	 **/
	public static function postStuffInfo($ads,$status){
			if($status =="add"){
				$sta = 1; //添加操作
			}elseif ($status =="save"){
				$sta = 2;  //修改操作
			}elseif ($status =="delete"){
				$sta = 3;//删除操作
			}
			foreach($ads as $stu){
				if(empty($stu->stuff->landing_page)){
					$https_url = "null";
				}else{
					$https_url = $stu->stuff->landing_page;
				}
				$stuff[] =  array(ID=>$stu->stuff->adid,
                                   NAME=>$stu->adname,
                                   PICTURE=>$stu->stuff->addr,
						           URL=>$https_url,
						           STATUS=>$sta);
			}
           /* $qStr = '';
            foreach($stuff as $key=>$val){
                $s = '';
                foreach($val as $k=>$v){
                    $s .= '&' . $k .'=' .$v;
                }
                $qStr .= '||' . ltrim($s, '&');
            }
            $qStr = ltrim($qStr, '|');*/
			
             $url = 'https://10.4.56.182:18081/mcp/dataSync/bj/907/1?CONTENT='; //待对方告知接口ip和端口进行联调测试
            //$webService = file_get_contents($url.json_encode($qStr));
            // 参数数组
            $stuff = json_encode($stuff);
            $data = array (
                'CONTENT' => $stuff
            );
            $ch = curl_init ();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1 );
            curl_setopt($ch, CURLOPT_HEADER, 0 );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
            $return = curl_exec($ch );
            curl_close( $ch );
            $return =json_decode($return ,true);
            return $return;
	}
	
	/***
	 * 上传文件到ftp服务器
	 */
	public static function  ftpUpload($file)
	{
	    $ftp_server="172.29.160.83";
	    $ftp_port ="32323";
	    $ftp_user_name="jingzhun";
	    $ftp_user_pass="KcyNxEhldDDAE0";
	    $remote_file = "/home/vgop";
	    $return = array(
	        "code"=>0,
	        'msg' =>""
	    );
	    // set up basic connection
	    $conn_id = ftp_connect($ftp_server);
	    // login with username and password
	    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	    if(!$login_result){
	       $return  = array(
	           'code'=>'-1',
	           'msg'=>"登录ftp服务器失败",
	       );
	    }
	    // upload a file
	    if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
	        $return  = array(
	            'code'=>'1',
	            'msg'=>"success",
	        );
	    } else {
	        $return  = array(
	            'code'=>'-2',
	            'msg'=>"fail",
	        );
	    }
	    // close the connection
	    ftp_close($conn_id);
	    return $return;
	}
}

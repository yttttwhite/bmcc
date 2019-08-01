<?php
class ad_stuff extends STpl{

    public $configForTa;

	public function __construct($inPath){

		if(user_api::id()==0){
			header("location:/baichuan_advertisement_manage/user");
		}
		$config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'version');
		$this->assign("config",$config);

		$adTypesInfo = array(

				1001 => array(
						'name' => '灵集-banner'
				),
				1002 => array(
						'name' => '灵集-普通信息流',
						'tip' => '需要上传图标，图标规则为正方形'
				),
//				1003 => array(
//						'name' => 'Inmobi-原生|启动页'
//				),
				1004 => array(
						'name' => '灵集-视频',
						'tip' => '视频格式：mp4'
				),
		);

		//构造只有inmobi的广告类型
		$adTypesInfo_inmobi = $adTypesInfo;
		$normal = array(1,2,32,64,128,256,512);
		foreach($normal as $k=>$val){
			unset($adTypesInfo_inmobi[$val]);
		}
		//构造普通的没有inmobi的广告类型
		$adTypesInfo_normal = $adTypesInfo;
		$inmobi = array(1001,1002,1003,1004);
		foreach($inmobi as $k=>$val){
			unset($adTypesInfo_normal[$val]);
		}

		$this->assign("adTypesInfoJson",json_encode($adTypesInfo));
		$this->assign("adTypesInfo",$adTypesInfo);
		$this->assign("adTypesInfo_normal",$adTypesInfo_normal);
		$this->assign("adTypesInfo_inmobi",$adTypesInfo_inmobi);
		$this->assign("_GET",$_GET);

		$this->configForTa = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'ta');
	}
	public function pageEntry($inPath){
		$ads=array();
		$this->assign("ads",$ads);
		return $this->render("v2/ad/scList.html");
	}
	public function pageStatus($inPath){
		if(!empty($_POST['adids'])){
		    $thriftStuffInfo = new thrift_stuffinfo_main;
			$a = new thrift_status_main;
			if($inPath[3]=="start"){
				foreach($_POST['adids'] as $adid){
				    $stuffs = $thriftStuffInfo->getStuffsByAdid($adid);
				    $stuff=$stuffs[0];
				    if($stuff->uid!==user_api::id() && !user_api::auth('admin')){
				        die("ERROR");
				    }else{
				        $a->updateAdInfoStatus($adid,PlanStatus::RUNNING);
				    }
				}
			}elseif($inPath[3]=="stop"){
				foreach($_POST['adids'] as $adid){
					$stuffs = $thriftStuffInfo->getStuffsByAdid($adid);
					$stuff=$stuffs[0];
					if($stuff->uid!==user_api::id() && !user_api::auth('admin')){
					    die("ERROR");
					}else{
					    $a->updateAdInfoStatus($adid,PlanStatus::STOPPED);
					}
				}
			}

		}
		return true;
	}
	public function pageDel($inPath){
		if(!empty($_POST['adids'])){
			$a = new thrift_adinfo_main;
			$b = new thrift_stuffinfo_main;
			foreach($_POST['adids'] as $adid){

				$stuffs = $b->getStuffsByAdid($adid);
				$stuff=$stuffs[0];

				$config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'config');
				if($config['delete']==1 && !user_api::auth('admin')){
					die("0");
				}
				if($stuff->uid!==user_api::id() && !user_api::auth('admin')){
					die("0");
				}
				$ad= $a->getAdInfoById($adid);
				$b = new thrift_adplan_main;
				$plan = $b->getAdPlanByPid($ad->plan_id);
				$r  = $a->delAdInfoById($adid);
				$r2 = $b->delStuffById($stuff->stuff_id);
                /******删除素材,通知亚信接口********/
				if($plan->priority==1){
                $status = 3;
            //    $stuff->ftp_addr = "/data/www/123.png";
                $data = array(
                    'ID'=>$stuff->stuff_id,
                    'NAME'=>$ads->adname,
                    'PICTURE'=>$stuff->ftp_addr,
                    'URL'=>$stuff->landing_page,
                    'STATUS'=>$status
                );
                $ads = $data;
                $re = ad_api::postStuffInfo($ads);
			}
               // var_dump($re);
                /*******删除素材，通知亚信接口********/
			}

		}
		return true;
	}
	public function pageDelete($inPath){
		if(isset($_POST['adid'])){
			$adId = $_POST['adid'];
			$a = new thrift_adinfo_main;
			$b=new thrift_stuffinfo_main;
			$stuffs = $b->getStuffsByAdid($adId);
			$stuff=$stuffs[0];
			if($stuff->uid!==user_api::id() && !user_api::auth("admin")){
				die("ERROR");
			}
			$r2 = $b->delStuffById($stuff->stuff_id);
			$r  = $a->delAdInfoById($adId);
		}
		return true;
	}

	private function reArrayFiles(&$file_post) {

		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $file_post[$key][$i];
			}
		}

		return $file_ary;
	}
	public function pageAdd($inPath){
		if(empty($inPath[3])){
			//empty plan_id
			header("location:/baichuan_advertisement_manage/ad.plan.add");
		}elseif(empty($inPath[4])){
			header("location:/baichuan_advertisement_manage/ad.plan.add.".$inPath[3]);
		}
		$plan_id=$inPath[3];
		$a = new thrift_adplan_main;
		$b = new thrift_adgroup_main;
		$position_thrift = new thrift_admedia_main;
		$plan = $a->getAdPlanByPid($plan_id);
		$all_position = $position_thrift->getAllPo();
		foreach($all_position as $position){
			if($plan->ad_pos_id>0 && $position->id == $plan->ad_pos_id){ //广告位
				$ad_pos[] = $position;
			}
			if(strlen($plan->tag_identification)>0 && $position->tag_identification == $plan->tag_identification){  //广告位类型
				$ad_position_type[] = $position;
			}
		}

		if($plan->ad_pos_id>0){
			unset($ad_position_type);
			$pos = $ad_pos;
		}else{
			unset($ad_pos);
			$pos = $ad_position_type;
		}
		$arr_pos = array();
		foreach($pos as $val){
			$size = $val->width."px*".$val->height."px";
			array_push($arr_pos,$size);
			$ad_unique_position = array_unique($arr_pos);
			$ad_position = implode("或",$ad_unique_position);
		}
		if($plan->uid!=user_api::id() && !user_api::auth('admin') && !user_api::auth("adReadonly")){
			die("NO PLAN");
		}
		$group_id=$inPath[4];
		$group=$b->findAdGroupById($inPath[4]);
		if($group->uid!=user_api::id() && !user_api::auth('admin') && !user_api::auth("adReadonly")){
			die("NO GROUP");
		}

        // 通过广告组channelid限制广告尺寸与文字长度
        $channel_list = @explode(",",$group->channels);

        $groupTaLimit = array(
            "height_min"=>0, "width_min"=>0,
            "height_max"=>0, "width_max"=>0,
            "fornt_min"=>0, "fornt_max"=>0,
        );

        $channelConfig = array();

        foreach ($channel_list as $channel) {
            $channelInfo = $this->configForTa[$channel];
            if (empty($channelInfo)){
            	continue;
            }
            $channelInfo["channel_id"] = $channel;
            array_push($channelConfig, $channelInfo);
            /*
                if ($groupTaLimit["height_min"] == 0) {
                    $groupTaLimit["height_min"] = $channelInfo["height"];
                    $groupTaLimit["width_min"] = $channelInfo["width"];
                    $groupTaLimit["height_max"] = $channelInfo["height"];
                    $groupTaLimit["width_max"] = $channelInfo["width"];
                    $groupTaLimit["fornt_min"] = $channelInfo["fontsize"];
                    $groupTaLimit["fornt_max"] = $channelInfo["fontsize"];
                    continue;
                }

            // 图片限制
            if (($channelInfo["width"] * $channelInfo["height"]) < ($groupTaLimit["height_min"] * $groupTaLimit["weight_min"])) {
                $groupTaLimit["height_min"] = $channelInfo["height"];
                $groupTaLimit["width_min"] = $channelInfo["width"];
            } else if (($channelInfo["width"] * $channelInfo["height"]) > ($groupTaLimit["height_max"] * $groupTaLimit["width_max"])) {
                $groupTaLimit["height_max"] = $channelInfo["height"];
                $groupTaLimit["width_max"] = $channelInfo["width"];
            }
            // 文字限制
            if ($channelInfo["fontsize"] < $groupTaLimit["fornt_min"]) {
                $groupTaLimit["fornt_min"] = $channelInfo["fontsize"];
            } else if ($channelInfo["fontsize"] > $groupTaLimit["fornt_max"]) {
                $groupTaLimit["fornt_max"] = $channelInfo["fontsize"];
            }
             */
        }
        //var_dump($groupTaLimit);
	    $this->assign("plan_id",$plan_id);
		$this->assign("plan",$plan);
		$this->assign("group_id",$group_id);
		//$ads=ad_api::listads($group_id);
		$start="00000000";
		$end="99999999";
		$ads = ad_api::listAdsReport($group_id,$start,$end);
		$positions = array(0=>"默认",1=>"正上方",2=>"右上角",3=>"右侧居中",4=>"右下角",5=>"正下方",6=>"左下角",7=>"左侧居中",8=>"左上角");
		$visibleStuffType = array(1,2,7,9);

		$this->assign("ads",$ads);
		$this->assign("positions",$positions);
		$this->assign("visibleStuffType",$visibleStuffType);
		$this->assign("rule",ad_landingrule::$rule);
        $this->assign("sp_list",@explode(",",$group->sp_list));
        //$this->assign("groupTaLimit", $groupTaLimit);
        $this->assign("channels_config", $channelConfig);
        $verified_or_not = 0;
        $has_passed = 0;
        foreach ($ads as $item){
            if($item->stuff->verified_or_not == 1){
                $verified_or_not = 1;
                break;
            }
            if($item->stuff->verified_or_not == 2){
                $has_passed = 1;
                break;
            }
        }
        if($verified_or_not == 1){
            $this->assign("btn_disable",1);
        }else{
            $this->assign("btn_disable",0);
        }
        $this->assign("has_passed",$has_passed);
        $this->assign("ad_position",$ad_position);

		return $this->render("v2/ad/step_3.html");
	}
	public function pageAddOne($inPath){
		if(empty($inPath[3])){
			header("location:/baichuan_advertisement_manage/ad.plan.add");
		}elseif(empty($inPath[4])){
			header("location:/baichuan_advertisement_manage/ad.plan.add.".$inPath[3]);
		}
		$plan_id=$inPath[3];
		$a = new thrift_adplan_main;
		$plan = $a->getAdPlanByPid($plan_id);
		if($plan->uid!=user_api::id() && !user_api::auth('admin')){
			die("NO PLAN");
		}
		$group_id=$inPath[4];
		$b = new thrift_adgroup_main;
		$plan = $a->getAdPlanByPid($plan_id);
		if($plan->uid!=user_api::id() && !user_api::auth('admin')){
			die("NO PLAN");
		}
		$group_id=$inPath[4];
		$group=$b->findAdGroupById($inPath[4]);
		if($group->uid!=user_api::id() && !user_api::auth('admin')){
			die("NO GROUP");
		}
		$this->assign("plan_id",$plan_id);
		$this->assign("group_id",$group_id);
		if(!empty($_POST['adname'])){
			$c_api=new thrift_adinfo_main;
			$d_api=new thrift_stuffinfo_main;
			$b=new AdInfo;
			//{{{ ugly code
			$a_api = new thrift_adplan_main;
			$plan = $a_api->getAdPlanByPid($plan_id);
			if($plan->uid!=user_api::id() && !user_api::auth('admin')){
				die("NO PLAN");
			}
			$b->time_interval = $plan->time_interval;
			$b->day_num= $plan->day_num;
			$b->show_num= $plan->show_num;
			//}}}
			$c=new StuffInfo;
			$b->group_id	=$c->group_id	=$group_id;
			$b->uid			=$c->uid		=$plan->uid;
			$b->plan_id		=$c->plan_id	=$plan_id;
			$b->adname		=$c->name		=$_POST['adname'];
			$b->show_js		=$_POST['show_js'];
			$b->click_js	=$_POST['click_js'];
			if(!empty($_POST['view_type'])){
				$b->view_type = $_POST['view_type'];//浮窗和嵌入式
			}else{
				$b->view_type = 1;//默认嵌入
			}
			if(!empty($_POST['view_position'])){
				$b->colum1 = $_POST['view_position'];//浮窗和嵌入式
			}else{
				$b->colum1 = 0;//默认位置
			}
			$b->width = 0;//$width;
			$b->height= 0;//$height;
			if(!empty($_REQUEST['width'])) $b->width = $_POST['width'];
			if(!empty($_REQUEST['height'])) $b->height= $_POST['height'];

			$b->ctime=$b->mtime=time();
			$b->ad_price=0;
			$r=$c_api->addAdInfo($b);
			if($r>0){
				$adid=$r;
				$c->uid	=$plan->uid;
				$c->adid=$adid;
				$c->addr="";
				$c->width=0;
				$c->height=0;
				if(!empty($_REQUEST['width'])) $c->width = $_POST['width'];
				if(!empty($_REQUEST['height'])) $c->height= $_POST['height'];
				$c->type=$_REQUEST['type'];
				$c->ctime=$c->mtime=time();
				$c->landing_page=$_REQUEST['landing_page'];
				$c->text=$_REQUEST['text'];
				if(!empty($_POST['landing_rule'])){
					$c->landing_rule=$_POST['landing_rule'];
				}
				/*if(!empty($_POST['description'])){
				    $c->description=$_POST['description'];
				}*/
                $operator = user_api::name();
				$stuff_id=$d_api->addStuffInfo($c);
				if($stuff_id>0){
				    if(user_api::auth('admin')){
				        $d_api->updateVerifiedStatus($stuff_id,2, $operator);
				    }else{
                        if(isset($_POST['submit_or_not'])&&$_POST['submit_or_not']==1){
				            $d_api->updateVerifiedStatus($stuff_id,1, $operator);
                        }else{
				            $d_api->updateVerifiedStatus($stuff_id,0, $operator);
                        }
				    }
					header("location:/baichuan_advertisement_manage/ad.stuff.add.$plan_id.$group_id");
				}
			}
		}
		$this->assign("rule",ad_landingrule::$rule);
        $start="00000000";
        $end="99999999";
        $ads = ad_api::listAdsReport($group_id,$start,$end);
        $verified_or_not = 0;
        $has_passed = 0;
        foreach ($ads as $item){
            if($item->stuff->verified_or_not == 1){
                $verified_or_not = 1;
                break;
            }
            if($item->stuff->verified_or_not == 2){
                $has_passed = 1;
                break;
            }
        }
        if($verified_or_not == 1){
            $this->assign("btn_disable",1);
        }else{
            $this->assign("btn_disable",0);
        }
        $this->assign("has_passed",$has_passed);
		return $this->render("v2/ad/step_3_1.html");
	}
	public function pageSet($inPath){
		return $this->render("v2/ad/scSet.html");
	}
	/**
	 * Ajax save handler
	 */
    public function pageSave($inPath){
		$result=array("error"=>"","fileid"=>"");
        $stuff_id=0;
        $ad_id=0;
		$a=new thrift_adinfo_main;
		$b=new thrift_stuffinfo_main;
		$c = new thrift_adgroup_main;

		$group=$c->findAdGroupById($_POST['group_id']);
		if($group->uid!=user_api::id() && !user_api::auth('admin') && !user_api::auth("adReadonly")){
			die("NO GROUP");
		}
        // 通过广告组channelid限制广告尺寸与文字长度
        $channel_list = @explode(",",$group->channels);

		if(!empty($_POST['group_id'])){
			//更新素材信息
			$ads = ad_api::listads($_POST['group_id']);
			foreach($ads as $ad){
				//更新landing_page
				$x = new thrift_adplan_main;
				$plan = $x->getAdPlanByPid($ad->plan_id);
				//根据广告计划去找广告位标签，去找广告位的尺寸
				$tag = $plan->tag_identification;
				$positionModel = new model_sspPosition();
				$positions =  $positionModel->getData(array('tag_identification'=>$tag));
				if($plan->uid!=user_api::id() && !user_api::auth('admin')){
					die("NO PLAN");
				}
				if(!empty($ad->adid)){
					$stuffs = $b->getStuffsByAdid($ad->adid);
					$stuff=$stuffs[0];
					if(empty($stuff))continue;
					if(!empty($_POST['landing_page'][$ad->adid])){
						$stuff->landing_page=$_POST['landing_page'][$ad->adid];
					}
					if(!empty($_POST['width'][$ad->adid])){
						$stuff->width=$_POST['width'][$ad->adid];
					}
					if(!empty($_POST['height'][$ad->adid])){
						$stuff->height=$_POST['height'][$ad->adid];
					}
					if(!empty($_POST['landing_rule'][$ad->adid])){
						$stuff->landing_rule=$_POST['landing_rule'][$ad->adid];
					}
					if(isset($_POST['text'][$ad->adid])){
						$stuff->text=$_POST['text'][$ad->adid];
					}
                    if(isset($_POST['title'][$ad->adid])){
                        $stuff->title=$_POST['title'][$ad->adid];
                       /* if(strlen($stuff->title) > 28){
                            $result['error']="广告".$ad->adid."标题字符数超过28";
                            return SJson::encode($result);
                        }*/
					}
					$stuff->desc= $_POST['description'][$ad->adid];
					$r = $b->updateStuffInfo($stuff);
                   // var_dump($stuff);
                     /*********编辑素材，通知亚信*******/
					if($plan->priority==1){
                    $status = 2;
                   // $stuff->ftp_addr = "/data/jingzhun/123.jpg";
                    $data = array(
                       'ID'=>$stuff->stuff_id,
                       'NAME'=>$ad->adname,
                       'PICTURE'=>$stuff->ftp_addr,
                       'URL'=>$stuff->landing_page,
                       'STATUS'=>$status
                     );
                    $ads = $data;
                   // var_dump($data);
                    $re = ad_api::postStuffInfo($ads);
				}
                   // var_dump($re);
                    /****************/
                    $operator = user_api::name();
					if(user_api::auth('admin')){
					    $b->updateVerifiedStatus($stuff->stuff_id,2, $operator);
					}else{
                        if(isset($_POST['submit_or_not'])&&$_POST['submit_or_not']==1){
					        $b->updateVerifiedStatus($stuff->stuff_id,1, $operator);
                        }else{
					        $b->updateVerifiedStatus($stuff->stuff_id,0, $operator);
                        }
					}
				}
				//更新adname
				$new_ad = $a->getAdInfoById($ad->adid);
				if(!empty($_POST['adname'][$ad->adid])){
					$new_ad->adname=$_POST['adname'][$ad->adid];
				}
				//更新监控JS
				if(isset($_POST['click_js'][$ad->adid])){
					$new_ad->click_js=$_POST['click_js'][$ad->adid];
				}
				if(isset($_POST['show_js'][$ad->adid])){
					$new_ad->show_js=$_POST['show_js'][$ad->adid];
				}
				if(!empty($_POST['view_type'][$ad->adid])){
					$new_ad->view_type = $_POST['view_type'][$ad->adid];
				}
				if(!empty($_POST['view_position'][$ad->adid])){
					$new_ad->colum1 = $_POST['view_position'][$ad->adid];
				}else{
				    $new_ad->colum1 = 0;
				}
				$new_ad->width=$stuff->width;
				$new_ad->height=$stuff->height;

				// 检查图片大小
                $isMatch = false;
                /*foreach ($channel_list as $channel) {
                    $channelInfo = $this->configForTa[$channel];
                    if (empty($channelInfo)){
            	        continue;
                    }
                    if ($channelInfo["width"] == $stuff->width && $channelInfo["height"] == $stuff->height) {
                    	$isMatch = true;
                 		break;
                 	}
                }
                if ($isMatch == false && $plan->platform==1) {
                	$result['error']="广告".$ad->adid."图片大小不匹配";
                	return SJson::encode($result);
            	}*/
                foreach ($positions as $positionTemp) {
                    $positionInfo = $this->configForTa[$positionTemp['position_identification']];
                    if (empty($positionInfo)){
                        continue;
                    }
                    if ($positionInfo["width"] == $stuff->width && $positionInfo["height"] == $stuff->height) {
                        $isMatch = true;
                        break;
                    }
                }
                /*if ($isMatch == false && $plan->platform==1) {
                    $result['error']="广告".$ad->adid."图片大小不匹配";
                    return SJson::encode($result);
                }*/
            	$a->updateAdInfo($new_ad);
			}
		}
		if(!empty($_FILES)){
			$files = self::reArrayFiles($_FILES['stuff']);
			$a = new thrift_adinfo_main;
			$d= new thrift_stuffinfo_main;
			foreach($files as $file){
			    //检测文件类型
			    $re = $this->checkExt($file);
			    if($re==false){
			        $file['error'] = "UPLOAD_ERR_UNVALID_FILE";
			    }
				if(!empty($file['error'])){
					$upload_errors = array(
							UPLOAD_ERR_OK        => "No errors.",
							UPLOAD_ERR_INI_SIZE    => "Larger than upload_max_filesize.",
							UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.",
							UPLOAD_ERR_PARTIAL    => "Partial upload.",
							//UPLOAD_ERR_NO_FILE        => "No file.",
							UPLOAD_ERR_NO_TMP_DIR    => "No temporary directory.",
							UPLOAD_ERR_CANT_WRITE    => "写入文件失败，请检查权限或者磁盘是否已经满",
							UPLOAD_ERR_EXTENSION     => "File upload stopped by extension.",
							UPLOAD_ERR_EMPTY        => "File is empty.", // add this to avoid an offset
					        UPLOAD_ERR_UNVALID_FILE =>'文件类型不支持'
					);
					$er = $file['error'];
					$result['error']=@$upload_errors[$er];
					return SJson::encode($result);

				}else{
					//对文件大小做限制，图片55K，flash 100K
					$f_type=strtolower($file['type']);
					if ($f_type== "image/gif" OR $f_type== "image/png" OR $f_type== "image/jpeg" OR $f_type== "image/gif"){
						if(filesize($file['tmp_name'])>300*1024){
							$result['error']="图片不能大于300K";
							return SJson::encode($result);
						}
					}elseif($f_type=="application/x-shockwave-flash"){
						if(filesize($file['tmp_name'])>300*1024){
							$result['error']="Flash不能大于300K";
							return SJson::encode($result);
						}
					}
					if(empty($result['error']) && !empty($file['tmp_name'])){
						require_once(ROOT."/stuff/id.class.php");
						$file_object = new stuff_id;
						$file_id=$file_object->upload($file['tmp_name'],user_api::getUserID(),$_REQUEST['play_status']);
						if($file_id!==false){
                        /***************************É´«Ë²ĸøµ½ftp**********************/
					    $a_api = new thrift_adplan_main;
						$plan = $a_api->getAdPlanByPid($_REQUEST['plan_id']);
						if($plan->priority==1){
						$fileUp = "/data/stuff/".date("Ymd")."/".$file_id;
                        $ftpFileId = $file_id.'.'.end(explode(".", $file["name"]));
                        $re = ad_api::ftpUpload($fileUp,$ftpFileId);
						}
                        /******************************************************************/
							$result['fileid']=$file_id;
						}else{
							$result['error']="上传文件失败v1";
							return SJson::encode($result);
						}
					}else{
						$result['error']="上传文件失败v2";
						return SJson::encode($result);
					}
				}
				$b=new AdInfo;
				//{{{ ugly code
				$a_api = new thrift_adplan_main;
				$plan = $a_api->getAdPlanByPid($_REQUEST['plan_id']);
				if($plan->uid!=user_api::id() && !user_api::auth('admin')){
					die("NO PLAN");
				}
				$b->time_interval = $plan->time_interval;
				$b->day_num= $plan->day_num;
				$b->show_num= $plan->show_num;
				//}}}
				$c=new StuffInfo;
				$b->group_id    = $_REQUEST['group_id'];
				$b->uid			= $plan->uid;
				$b->plan_id		= $_REQUEST['plan_id'];
				$b->adname		= $file['name'];
				$b->show_js		= "";
				$b->click_js	= "";
				$b->view_type   = 2;//浮窗
				$b->width       = 0;//$width;
				$b->height      = 0;//$height;
				$type=1;
				if(!empty($file['tmp_name'])){
					$f_type=strtolower($file['type']);
					if ($f_type== "image/gif" OR $f_type== "image/png" OR $f_type== "image/jpeg" OR $f_type== "image/gif"){
						list($width, $height, $type, $attr) = getimagesize($file['tmp_name']);
						if(!empty($width) || !empty($height)){
							$type=1;
							//adinfo
							//从图片里获取
							if(empty($_REQUEST['width'])) $b->width = $width;
							if(empty($_REQUEST['height'])) $b->height= $height;
						}
					}elseif($f_type=="application/x-shockwave-flash"){
						//从swf里获取
						exec(ROOT_APP."/../tools/swfdump -X -Y -r ".$file['tmp_name'],$r);
						preg_match("/\-X (\d+) \-Y (\d+) \-r ([\d|\.]+)/msi",$r[0],$m);
						if(!empty($m)){
							$width = $m[1];
							$height = $m[2];
						}

						if(empty($_REQUEST['width'])) $b->width = $width;
						if(empty($_REQUEST['height'])) $b->height= $height;
						$type=2;
					}
				}
				if(empty($file_id)){
					$result['error']="请选择素材文件";
					return SJson::encode($result);
				}else{
					$b->ctime=$b->mtime=time();
					$b->ad_price=0;//=$b->mtime=time();
					//echo  "run  stuff2";
					$r=$a->addAdInfo($b);
					$result['ad_id']=$r;
					if($r>0){
						$adid=$r;
					}else{
						$result['error']="新增广告失败:".$r;
						return SJson::encode($result);
					}
				}
				$c->uid	=$plan->uid;
				$c->adid=$adid;
				if(!empty($file_id)){
					$host = SConfig::getConfig(ROOT_CONFIG."/js.conf","host");
					$c->addr="https://".$host->stuff."/$file_id";
				}
				$c->width=$width;
				$c->height=$height;
				$c->type=$type;//$_REQUEST['type'];
				$c->ctime=$c->mtime=time();
				$c->landing_page="";//$_REQUEST['landing_page'];
				$c->ftp_addr = "/home/jingzhun/material/".$ftpFileId;
               // var_dump($c);
				$stuff_id=$d->addStuffInfo($c);
               // var_dump($stuff_id);
                /***********上传素材通知亚信********/
				if($plan->priority==1){
                $status = 1;
                $picture  = "/home/jingzhun/material/".$ftpFileId;
                //https://10.4.56.182:18081/mcp/v1/dataSync/bj/907/1?CONTENT= [{"ID":"1","NAME":"¶¨ÏÑԼ","PICTURE":"app.png","URL":"https://221.179.131.140/activity","STATUS":1}
                $data = array(
                'ID'=>$stuff_id,
                'NAME'=>$b->adname,
                'PICTURE'=>$picture ,
                'URL'=>$c->landing_page,
                'STATUS'=>$status
                );
                $ads = $data;
                $re = ad_api::postStuffInfo($ads);
			}
                /************************************/
                $operator = user_api::name();
				if(empty($stuff_id)){
					$result['error']='素材服务接口新增失败';
				}else{
					if(user_api::auth('admin')){
						$d->updateVerifiedStatus($stuff_id,2, $operator);
					}else{
                        if(isset($_POST['submit_or_not'])&&$_POST['submit_or_not']==1){
					        $d->updateVerifiedStatus($stuff_id,1, $operator);
                        }else{
					        $d->updateVerifiedStatus($stuff_id,0, $operator);
                        }
					}
				}
				$result['stuff_id']=$stuff_id;
				$result['stuff_info']=var_export($c,true);;
			}
		}
		return SJson::encode($result);
	}

    /**
     * *
     * 新增上传素材接口，服务端
     */
    public function pageApiUpload()
    {
        if (! empty($_FILES)) {
            $files = self::reArrayFiles($_FILES['stuff']);
            foreach ($files as $file) {
                if (! empty($file['tmp_name'])) {
                    require_once (ROOT . "/stuff/id.class.php");
                    $file_object = new stuff_id();
                    $file_id = $file_object->upload($file['tmp_name'], user_api::getUserID(), $_REQUEST['play_status']);
                    if ($file_id !== false) {
                        $result['fileid'] = $file_id;
                    } else {
                        $result['error'] = "上传文件失败v1";
                        return SJson::encode($result);
                    }
                } else {
                    $result['error'] = "上传文件失败v2";
                    return SJson::encode($result);
                }
            }
        }
    }
    
    /***
     * php上传文件检测文件类型
     */
    public  function   checkExt($file){
        $allowedExts = array(
                     'jpg',
                     'jpeg',
                     'png',
                     'swf',
                     'psd',
                     'bmp',
                     'tiff_ii',
                     'tiff_mm',
                     'jpc',
                     'jp2',
                     'jpx',
                     'jb2',
                     'swc',
                     'iff',
                     'wbmp',
                     'xbm',
                     'ico',
                     'count',
                     'gif'
        );
        $extension = end(explode(".", $file["name"]));
        if ((($file["type"] == "image/gif") ||($file["type"] == "image/bmp")||($file["type"] == "application/octet-stream")||($file["type"] == "application/x-shockwave-flash")|| ($file["type"] == "image/jpeg") || ($file["type"] == "image/jpg") || ($file["type"] == "image/pjpeg") || ($file["type"] == "image/x-png") || ($file["type"] == "image/png"))) {
            return  true;
        }  else{
            return   false;
        }
        if(in_array($extension, $allowedExts)){
            return  true;
        } else{
            return  false;
        }
    }


	//start:素材编辑重写
	//添加素材
	public function pageAddExchangeStuff($inPath){
		$icon_size = SConfig::getConfigArray(ROOT_CONFIG."/config.php","icon_size");
		$inmobi_stuff_size1 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size1");
		$inmobi_stuff_size2 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size2");
		$inmobi_stuff_size3 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size3");
		$inmobi_stuff_size4 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size4");
		$this->assign("inmobi_stuff_size1",$inmobi_stuff_size1);
		$this->assign("inmobi_stuff_size2",$inmobi_stuff_size2);
		$this->assign("inmobi_stuff_size3",$inmobi_stuff_size3);
		$this->assign("inmobi_stuff_size4",$inmobi_stuff_size4);
		$this->assign("icon_size",$icon_size);
		if(empty($inPath[3])){
			header("location:/baichuan_advertisement_manage/ad.plan.add");
		}elseif(empty($inPath[4])){
			header("location:/baichuan_advertisement_manage/ad.plan.add.".$inPath[3]);
		}
		$plan_id=$inPath[3];
		$a = new thrift_adplan_main;
		$plan = $a->getAdPlanByPid($plan_id);
		if($plan->uid!=user_api::id() && !user_api::auth('admin')){
			die("NO PLAN");
		}
		$group_id=$inPath[4];
		$b = new thrift_adgroup_main;
		$group=$b->findAdGroupById($inPath[4]);
		if($group->uid!=user_api::id() && !user_api::auth('admin')){
			die("NO GROUP");
		}
		$this->assign("plan_id",$plan_id);
		$this->assign("group_id",$group_id);
		$this->assign("group_info",$group);
		return $this->render("v2/ad/add_exchange_stuff.html");
	}

	//编辑普通素材广告
	public function pageEditExchangeAd($inPath){
		$icon_size = SConfig::getConfigArray(ROOT_CONFIG."/config.php","icon_size");
		$this->assign("icon_size",$icon_size);
		$b = new thrift_adgroup_main;
		if(empty($inPath[3])){
			header("location:/baichuan_advertisement_manage/ad.plan.add");
		}elseif(empty($inPath[4])){
			header("location:/baichuan_advertisement_manage/ad.plan.add.".$inPath[3]);
		}elseif(empty($inPath[5])){
			header("location:/baichuan_advertisement_manage/ad.group.list.".$inPath[3].".".$inPath[4]);
		}
		$this->assign("plan_id",$inPath[3]);
		$this->assign("group_id",$inPath[4]);
		$group=$b->findAdGroupById($inPath[4]);
		if($group->uid!=user_api::id() && !user_api::auth('admin')){
			die("NO GROUP");
		}
		$this->assign("group_info",$group);

		$adInfoThrift     =   new thrift_adinfo_main;
		$stuffInfoThrift  =   new thrift_stuffinfo_main;
		$adid = $inPath[5];
		$adInfo = $adInfoThrift->getAdInfoById($adid);
		$stuffs = $stuffInfoThrift->getStuffsByAdid($adid);
		$stuffInfo = $stuffs[0];
		$this->assign("btn_disable",$stuffInfo->verified_or_not);
		$this->assign("adInfo",$adInfo);
		$this->assign("stuffInfo",$stuffInfo);
		if(isset($_GET['debug']) && $_GET['debug'] === "yanglihui"){
			print_r($adInfo);
			print_r($stuffInfo);
		}else{
			$this->render("/ad/edit_exchange_stuff.html");
		}
	}

	//保存普通素材广告
	public function pageSaveExchangeStuff($inPath){
		$plan_id = $inPath[3];
		$group_id=$inPath[4];
		if(!empty($_REQUEST['plan_id']) && !empty($_REQUEST['group_id'])){
			$plan_id = $_REQUEST['plan_id'];
			$group_id = $_REQUEST['group_id'];
		}
		$this->assign("plan_id", $plan_id);
		$this->assign("group_id", $group_id);
		$inmobi_stuff_size1 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size1");
		$inmobi_stuff_size2 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size2");
		$inmobi_stuff_size3 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size3");
		$inmobi_stuff_size4 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size4");
		$this->assign("inmobi_stuff_size1",$inmobi_stuff_size1);
		$this->assign("inmobi_stuff_size2",$inmobi_stuff_size2);
		$this->assign("inmobi_stuff_size3",$inmobi_stuff_size3);
		$this->assign("inmobi_stuff_size4",$inmobi_stuff_size4);
		$host = SConfig::getConfig(ROOT_CONFIG."/js.conf","host");
		$adInfoThrift     = new thrift_adinfo_main;
		$stuffInfoThrift  = new thrift_stuffinfo_main;
		$a_api = new thrift_adplan_main;
		$d_api=new thrift_stuffinfo_main;
		$this->stuffinfoModel = new model_stuffInfo();
		$this->planinfoModel= new model_planInfo();
		$editableAdColum = array("adname","show_js","click_js","width","height","view_type");
		$editableStuffColum = array("name","title","desc","icon_width","landing_page","width","height");

		if(isset($_POST['adid'])){
			//编辑页面跳转而来
			$adid = $_POST['adid'];
			$adInfo = $adInfoThrift->getAdInfoById($adid);
			if($adInfo->uid == user_api::id() || user_api::auth('admin')){
				foreach ($editableAdColum as $key){
					if(isset($_POST[$key])){
						$adInfo->$key = $_POST[$key];
					}
				}

				$adInfoThrift->updateAdInfo($adInfo);

				if(isset($_POST['stuff_id'])){
					$stuffs = $stuffInfoThrift->getStuffsByAdid($adid);
					$stuffInfo = $stuffs[0];
					if(isset($stuffInfo->adid) && $stuffInfo->adid == $adid){
						foreach ($editableStuffColum as $key){
							if(isset($_POST[$key])){
								if($key === "landing_page"){
									if( stripos($_POST['landing_page'], "https://") === 0 || stripos($_POST['landing_page'], "https://") === 0 ){
										$stuffInfo->landing_page = $_POST['landing_page'];
									}elseif(strlen($_POST['landing_page'])>0){
										$stuffInfo->landing_page = $_POST['landing_page'];
									}
								}elseif($key === "icon_width"){
									$stuffInfo->icon_width = $stuffInfo->icon_height = $_POST['icon_width'];
								}elseif($key === "width"){
									$stuffInfo->width = $_POST['width'];
								}elseif($key === "height"){
									$stuffInfo->height = $_POST['height'];
								}else{
									$stuffInfo->$key = $_POST[$key];
								}
							}
						}
						$stuffInfo->mtime = time();
						$stuffInfo->crop = $_POST['icon_width'];
						$stuffInfoThrift->updateStuffInfo($stuffInfo);

						if(user_api::auth('admin')){
							$d_api->updateVerifiedStatus($_POST['stuff_id'],2);
							//初始化审核日志
							$log = new admin_logapi;
							$operate_uid = user_api::id();
							$uid=$adInfo->uid;
							$operate_num = 212; //操作代码，表示 2：素材 由1：等待审核 转为 2：审核通过
							$msgText = $this->generateMsgText($operate_num, $_POST['stuff_id']); //生成文本信息
							$log->addLog($operate_uid, $uid, $operate_num, $_POST['stuff_id'], $msgText['body']);//日志生成
							$data = array();
							$data['submit_time'] = time();
							$this->stuffinfoModel->updateData($data,array("stuff_id"=>$stuffInfo->stuff_id));
							$this->planinfoModel->updateData($data,array("plan_id"=>$stuffInfo->plan_id));
							if(isset($_POST['submit_or_not'])&&$_POST['submit_or_not']==0){
								$d_api->updateVerifiedStatus($_POST['stuff_id'],0, user_api::name());
							}
						}else{
							if(isset($_POST['submit_or_not'])&&$_POST['submit_or_not']==1){
								$d_api->updateVerifiedStatus($_POST['stuff_id'],1, user_api::name());
								$data = array();
								$data['submit_time'] = time();
								$this->stuffinfoModel->updateData($data,array("stuff_id"=>$stuffInfo->stuff_id));
								//$data['verified_or_not'] = 1;
								//$this->planinfoModel->updateData($data,array("plan_id"=>$stuffInfo->plan_id));
							}else{
								$d_api->updateVerifiedStatus($_POST['stuff_id'],0, user_api::name());
							}
						}
					}
					header("location:/baichuan_advertisement_manage/ad.group.list.".$adInfo->plan_id.".".$adInfo->group_id);
					exit();
				}
			}

			header("location:/baichuan_advertisement_manage/ad.stuff.EditExchangeAd.".$adInfo->plan_id.".".$adInfo->group_id.".".$adid."?save_only=1");
		}else{
			//新增页面跳转而来
			$response['error'] = 0;
			$response['message'] = "";
			$types = array("image/gif","image/png","image/jpeg","image/jpg","image/gif","application/x-shockwave-flash","video/mp4","video/x-flv");
			$ad_type = "";
			if(isset($_FILES['ad-image-file']['tmp_name']) && file_exists($_FILES['ad-image-file']['tmp_name'])){
				$f_type=strtolower($_FILES['ad-image-file']['type']);
				$ad_type = $f_type;
				if(!in_array($f_type, $types)){
					$response['error']++;
					if(strlen($f_type)>0){
						$response['message'] .= "不支持的文件类型，识别到的文件类型为：".$f_type;
					}else{
						$response['message'] .= "文件类型无法识别";
					}
				}else{
					if(stripos($f_type, "mp4") !== false || stripos($f_type, "flv") !== false){
						$maxSize = 8*1024*1024;
						if(filesize( $_FILES['ad-image-file']['tmp_name'] )>$maxSize){
							$response['error']++;
							$response['message'] .= "视频不能大于8M";
						}
						if($_POST['view_type']==1004){
							$size_string = $inmobi_stuff_size3[$_POST['stuff_size3']];
							$info = $this->getVideoInfo($_FILES['ad-image-file']['tmp_name']);
							if(isset($info['video']['resolution_x']) && isset($info['video']['resolution_y'])){
								$wid  = $info['video']['resolution_x'];
								$hei  = $info['video']['resolution_y'];
								$size_arr = array_filter(explode(";", $size_string));
								$flag = 0;
								foreach ($size_arr as $item){
									$wid_tmp = explode("*", $item)[0];
									$hei_tmp = explode("*",$item)[1];
									if($wid == $wid_tmp && $hei == $hei_tmp){
										$flag=1;
									}
								}
								if($flag == 0){
									$response['error']++;
									$response['message'] .="视频实际尺寸(宽度*长度)为：".$wid.'*'."$hei";
									$response['message'] .="\n预期值为:".implode("或", $size_arr);
								}
							}else{
								$response['error']++;
								$response['message'] .= "无法获取该视频尺寸";
							}
						}
					}else{
						$maxSize = 400*1024;
						if(filesize( $_FILES['ad-image-file']['tmp_name'] )>$maxSize){
							$response['error']++;
							$response['message'] .= "图片或Flash不能大于400K";
						}
						if($_POST['view_type']>=1001 && $_POST['view_type']<=1003){
							if($_POST['view_type']==1001){
								$size_string = $inmobi_stuff_size2[$_POST['stuff_size2']];
							}else if($_POST['view_type']==1002 || $_POST['view_type']==1003){
								$size_string = $inmobi_stuff_size1[$_POST['stuff_size1']];
							}
							if(empty($size_string)){
								$response['error']++;
								$response['message'] .= "图片的预期尺寸为空值";
							}else{
								$size_arr = array_filter(explode(";", $size_string));
								$img_info = getimagesize($_FILES['ad-image-file']['tmp_name']);
								$img_wid = $img_info[0];
								$img_hei = $img_info[1];
								$flag = 0;
								foreach ($size_arr as $item){
									$wid_tmp = explode("*", $item)[0];
									$hei_tmp = explode("*",$item)[1];
									if($img_wid == $wid_tmp && $img_hei == $hei_tmp){
										$flag=1;
									}
								}
								if($flag == 0){
									$response['error']++;
									$response['message'] .="图片实际尺寸(宽度*长度)为：".$img_wid.'*'."$img_hei";
									$response['message'] .="\n预期值为:".implode("或", $size_arr);
								}
							}
						}
					}
				}
			}else{
				if(isset($_REQUEST['ad_icon_group'])){
					$response['error']++;
					$response['message'] .= "没有收到上传文件，或文件类型不支持";
				}

			}
			 if(isset($_POST['view_type']) && $_POST['view_type'] == 1002){
				//icon信息
				 if(isset($_FILES['ad-icon-file']['tmp_name']) && file_exists($_FILES['ad-icon-file']['tmp_name'])){
					$paragram = array();
					$paragram['view_type'] = $_POST['view_type'];
					$paragram['stuff_icon_size'] = $_POST['icon_width'];
					$paragram['file'] = $_FILES;
					$response = $this->Validate($paragram,1);
					if(filesize( $_FILES['ad-icon-file']['tmp_name'] )>400*1024){
						$response['error']++;
						$response['message'] .= "上传图标文件不能大于400K";
					}
				}else{
					 if(isset($_REQUEST['ad_icon_group'])){
						 $response['error']++;
						 $response['message'] .= "没有收到上传的图标文件";
					 }

				}
				 //logo信息
				 if(isset($_FILES['ad-logo-file']['tmp_name']) && file_exists($_FILES['ad-logo-file']['tmp_name'])){
					 $item = array();
					 $item['view_type'] = $_POST['view_type'];
					 $item['stuff_logo_size'] = $_POST['logo_width'];
					 $item['file'] = $_FILES;
					 $response = $this->Validate($item,2);
					 if(filesize( $_FILES['ad-logo-file']['tmp_name'] )>400*1024){
						 $response['error']++;
						 $response['message'] .= "上传logo文件不能大于400K";
					 }
				 }else{
					 if(isset($_REQUEST['ad_logo_group'])){
						 $response['error']++;
						 $response['message'] .= "没有收到上传的logo文件";
					 }
				 }


			}
			/** if(isset($_POST['view_type']) && $_POST['view_type'] == 1004){
				if(isset($_FILES['ad-video-icon-file']['tmp_name']) && file_exists($_FILES['ad-video-icon-file']['tmp_name'])){
					$paragram = array();
					$paragram['view_type'] = $_POST['view_type'];
					$paragram['stuff_size'] = $_POST['stuff_size4'];
					$paragram['file'] = $_FILES;
					$response = $this->Validate($paragram);
					if(filesize( $_FILES['ad-video-icon-file']['tmp_name'] )>400*1024){
						$response['error']++;
						$response['message'] .= "上传图标文件不能大于400K";
					}
				}else{
					$response['error']++;
					$response['message'] .= "没有收到上传的图标文件";
				}
			} */

			if($response['error'] > 0){
				$this->assign("response",$response);
				$b = new thrift_adgroup_main;
				$group=$b->findAdGroupById($group_id);
				$this->assign("group_info",$group);
				$icon_size = SConfig::getConfigArray(ROOT_CONFIG."/config.php","icon_size");
				$inmobi_stuff_size1 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size1");
				$inmobi_stuff_size2 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size2");
				$inmobi_stuff_size3 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size3");
				$inmobi_stuff_size4 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size4");
				$this->assign("inmobi_stuff_size1",$inmobi_stuff_size1);
				$this->assign("inmobi_stuff_size2",$inmobi_stuff_size2);
				$this->assign("inmobi_stuff_size3",$inmobi_stuff_size3);
				$this->assign("inmobi_stuff_size4",$inmobi_stuff_size4);
				$this->assign("icon_size",$icon_size);
				return $this->render("v2/ad/add_exchange_stuff.html");
				exit();
			}

			$adInfo     =   new AdInfo;
			$stuffInfo  =   new StuffInfo;

			$plan = $a_api->getAdPlanByPid($_REQUEST['plan_id']);
			if($plan->uid!=user_api::id() && !user_api::auth('admin')){
				die("NO PLAN");
			}
			$adInfo->time_interval  = $plan->time_interval;
			$adInfo->day_num   = $plan->day_num;
			$adInfo->show_num  = $plan->show_num;
			$adInfo->group_id  = $_REQUEST['group_id'];
			$adInfo->plan_id   = $_REQUEST['plan_id'];
			$adInfo->uid       = $plan->uid;
			$adInfo->adname	   = $file['name'];
			$adInfo->show_js   = "";
			$adInfo->click_js  = "";
			$adInfo->view_type = 2;   //浮窗
			$adInfo->width     = 0;   //$width;
			$adInfo->height    = 0;   //$height;
			$adInfo->ctime     = $adInfo->mtime=time();
			$adInfo->ad_price  = 0;

			if(!empty($_POST['adname'])){
				$adInfo->adname=$_POST['adname'];
			}
			if(isset($_POST['click_js'])){
				$adInfo->click_js=$_POST['click_js'];
			}
			if(isset($_POST['show_js'])){
				$adInfo->show_js=$_POST['show_js'];
			}
			if(!empty($_POST['view_type'])){
				$adInfo->view_type = $_POST['view_type'];
			}
			if(!empty($_POST['view_position'])){
				$adInfo->colum1 = $_POST['view_position'];
			}else{
				$adInfo->colum1 = 0;
			}

			$adid = $adInfoThrift->addAdInfo($adInfo);
			if($adid > 0){
				$adInfo->adid = $adid;
				$stuffInfo->group_id  = $_REQUEST['group_id'];
				$stuffInfo->plan_id   = $_REQUEST['plan_id'];
				$stuffInfo->name   =   $adInfo->adname;
				$stuffInfo->uid	   =   $plan->uid;
				$stuffInfo->adid   =   $adid;
				$stuffInfo->ctime  =   $stuffInfo->mtime   =   time();
				$stuffInfo->landing_page = $_REQUEST['landing_page'];
				$stuffInfo->crop = $_REQUEST['icon_width'];
				if(isset($_POST['title'])){
					$stuffInfo->title = $_POST['title'];
				}
				if(isset($_POST['desc'])){
					$stuffInfo->desc = $_POST['desc'];
				}
				if(isset($_POST['landing_page'])){
					if( stripos($_POST['landing_page'], "https://") === 0 || stripos($_POST['landing_page'], "https://") === 0 ){
						$stuffInfo->landing_page = $_POST['landing_page'];
					}elseif(strlen($_POST['landing_page'])>0){
						$stuffInfo->landing_page = $_POST['landing_page'];
					}
				}
				//视频类型的图标
		/**	if(isset($_POST['view_type']) && $_POST['view_type'] == 1004 && isset($_FILES['ad-video-icon-file'])){
					$videoIconSize = $inmobi_stuff_size4[$_POST['stuff_size4']];
					$size_video = array_filter(explode(";", $videoIconSize));
					foreach($size_video as $icon){
						$icon_width = explode("*", $icon)[0];
						$icon_height = explode("*", $icon)[1];
					}
					$maxIconSize = $icon_width*$icon_height;  //限定最大上传
					$result = $this->saveFile($_FILES['ad-video-icon-file']);
					if(isset($result['error'])){

					}elseif($result['fileid']){
						$resultSize = $result['width']*$result['height'];
						if($resultSize <= $maxIconSize){
							$stuffInfo->icon_addr = "https://".$host->stuff."/".$result['fileid'];
							$stuffInfo->icon_width = $result['width'];
							$stuffInfo->icon_height = $result['height'];
							$stuffInfo->type   = $result['type'];
							$stuffInfo->icon_mime_type = $result['mime_type'];
						}else{
							$iconSize = $maxIconSize/1024;  //转换成大小
							$response['error']++;
							$response['message'] .= "上传图标文件不能大于".$iconSize."K";
						}

					}
				}  */

				if(isset($_POST['view_type']) && $_POST['view_type'] == 1002 && isset($_FILES['ad-icon-file'])){
					$result = $this->saveFile($_FILES['ad-icon-file']);
					if(isset($result['error'])){

					}elseif($result['fileid']){
						$stuffInfo->icon_addr = "https://".$host->stuff."/".$result['fileid'];
						$stuffInfo->icon_width = $result['width'];
						$stuffInfo->icon_height = $result['height'];
						$stuffInfo->type   = $result['type'];
						$stuffInfo->icon_mime_type = $result['mime_type'];
					}
				}
				//logo
				if(isset($_POST['view_type']) && $_POST['view_type'] == 1002 && isset($_FILES['ad-logo-file'])){
					$result = $this->saveFile($_FILES['ad-logo-file']);
					if(isset($result['error'])){

					}elseif($result['fileid']){
						$stuffInfo->logo_addr = "https://".$host->stuff."/".$result['fileid'];
						$stuffInfo->logo_width = $result['width'];
						$stuffInfo->logo_height = $result['height'];
						$stuffInfo->type   = $result['type'];
						$stuffInfo->icon_mime_type = $result['mime_type'];
					}
				}


				if(isset($_FILES['ad-image-file'])){
//					var_dump($_FILES);die(wewewe);
					$result = $this->saveFile($_FILES['ad-image-file']);
					if(isset($result['error'])){

					}elseif($result['fileid']){
						$stuffInfo->addr   = "https://".$host->stuff."/".$result['fileid'];
						$stuffPropertys = array("width","height","type","mime_type","frame_rate","duration","bitrate","size");
						foreach ($stuffPropertys as $stuffProperty){
							if(isset($result[$stuffProperty])){
								$stuffInfo->$stuffProperty = $result[$stuffProperty];
							}
						}

						$adInfo->width     = $stuffInfo->width;
						$adInfo->height    = $stuffInfo->height;
					}
				}
				$adInfoThrift->updateAdInfo($adInfo);
				//灵集中，对接信息流素材时APP信息字段
				if(isset($_POST['app_type'])){
					$stuffInfo->app_type=$_POST['app_type'];
				}
				if(isset($_POST['packagename'])){
					$stuffInfo->packagename=$_POST['packagename'];
				}
				if(isset($_POST['appname'])){
					$stuffInfo->appname=$_POST['appname'];
				}
				if(isset($_POST['app_intro_url'])){
					$stuffInfo->app_intro_url=$_POST['app_intro_url'];
				}
				if(isset($_POST['app_size'])){
					$stuffInfo->app_size=$_POST['app_size'];
				}
				if(isset($_POST['app_ver'])){
					$stuffInfo->app_ver=$_POST['app_ver'];
				}
				if(isset($_POST['itunesId'])){
					$stuffInfo->itunesId=$_POST['itunesId'];
				}
				if(isset($_POST['app_id'])){
					$stuffInfo->app_id=$_POST['app_id'];
				}
				if(isset($_POST['deeplink-url'])){
					$stuffInfo->deeplinkurl=$_POST['deeplink-url'];
				}
				if(isset($_POST['ad_action'])){
					$stuffInfo->ad_action=$_POST['ad_action'];
				}
				if(!empty($_POST['stuff_type'])){
					$stuffInfo->type=$_POST['stuff_type'];
				}
				$stuffInfo->ad_stuff_platform = 1; //0为本平台素材，1为同步到灵集的素材
				$id = $stuffInfoThrift->addStuffInfo($stuffInfo);

				if(user_api::auth('admin')){
					$d_api->updateVerifiedStatus($id,2);
					//初始化审核日志
					$log = new admin_logapi;
					$operate_uid = user_api::id();
					$uid=$stuffInfo->uid;
					$operate_num = 212; //操作代码，表示 2：素材 由1：等待审核 转为 2：审核通过
					$msgText = $this->generateMsgText($operate_num, $id); //生成文本信息
					$log->addLog($operate_uid, $uid, $operate_num, $id, $msgText['body']);//日志生成
					$data = array();
					$data['mtime'] = time();
					$this->stuffinfoModel->updateData($data,array("stuff_id"=>$id));
					$this->planinfoModel->updateData($data,array("plan_id"=>$stuffInfo->plan_id));
					if(isset($_POST['submit_or_not'])&&$_POST['submit_or_not']==0){
						$d_api->updateVerifiedStatus($id,0, user_api::name());
					}
				}else{
					if(isset($_POST['submit_or_not'])&&$_POST['submit_or_not']==1){
						$d_api->updateVerifiedStatus($id,1, user_api::name());
						$data = array();
						$data['mtime'] = time();
						$this->stuffinfoModel->updateData($data,array("stuff_id"=>$id));
						//$data['verified_or_not'] = 1;
						//$this->planinfoModel->updateData($data,array("plan_id"=>$stuffInfo->plan_id));
					}else{
						$d_api->updateVerifiedStatus($id,0, user_api::name());
					}
				}
				//此处开始同步素材信息到灵集服务器上

//				$new_ad = $adInfoThrift->getAdInfoById($adid);
//				$stuffs = $stuffInfoThrift->getStuffsByAdid($adid);
//				$stuff_info = $stuffs[0];
//				$plan = $a_api->getAdPlanByPid($new_ad->plan_id);
//				$ad_data = array();
//				$ad_data = array("ad_info"=>$new_ad,
//								"stuff_info"=>$stuff_info,
//								"plan_info"=>$plan);
//
//				if(!empty($ad_data)){
//					$res = $this->CurlAdExchange($ad_data);
//				}
//				$sms= json_decode($res);
//				$host = SConfig::getConfig(ROOT_CONFIG."/js.conf","host");
//				if(strlen(json_encode($sms->message)) >2){
//					$del_res_ad = $adInfoThrift->delAdInfoById($new_ad->adid);
//					$del_res_stuff = $stuffInfoThrift->delStuffById($stuff_info->stuff_id);
//					$errormsg = json_encode($sms->message);
//					$url="https://".$host->admin."/ad.stuff.addExchangeStuff".".".$adInfo->plan_id.".".$adInfo->group_id;
//					ob_start();
//					echo "<script> alert('提交错误，错误信息为:$errormsg');</script>";
//					ob_end_flush();
//					header("Refresh: 2; url=$url");
//				}else{
//					$url="https://".$host->admin."/ad.group.list".".".$adInfo->plan_id.".".$adInfo->group_id.".".$adid;
//					ob_start();
//					echo "<script> alert('提交成功！'); </script>";
//					ob_end_flush();
//					header("Refresh: 1; url=$url");
//
//				}


			}
		}
	}


	/***
	 * @date 2018-03-26
	 * @description 提交灵集类型的广告
	 */
	public function CurlAdExchange($parameter,$timeout = 40,$aHeader=array()){
		$curl_post = SConfig::getConfigArray(ROOT_CONFIG."/config.php","curl_post");
		$post_url = $curl_post['post_url']."/upload";  //上传物料
		$ad_info = $parameter['ad_info'];
		$stuff_info = $parameter['stuff_info'];
		$plan_info = $parameter['plan_info'];
		$adx_data = array();
		$adx_data['dspid'] = $curl_post['dspid'];
		$adx_data['token'] = $curl_post['token'];
		if($ad_info->view_type ==1001 || $ad_info->view_type ==1004){ //1001为banner，1002为信息流，1004为video
			$adx_data['creativeType'] = 1;  //1.普通物料banner或video 2.普通信息流
			$material = array();
			$material['creativeId'] = (string)$ad_info->adid; //广告创意id
			$material['name'] = $ad_info->adname; //广告创意名称
			$material['vendorId'] = 0; //素材所投放的渠道媒体ID，渠道媒体为 0-灵集 vendorId指定为0，默认为0
			$material['url'] = $stuff_info->addr; //物料地址
			$material['width'] = $stuff_info->width;
			$material['height'] = $stuff_info->height;
			$material['duration'] = 0;  //素材时长，图片类素材制定素材时长为零
			$material['landingpage'] = $stuff_info->landing_page;
			$material['deeplinkurl'] = $stuff_info->deeplinkurl;
//			$material['advertiser'] = $stuff_info->uid; //DSP平台广告主名称，需要和资质文件中的广告主名称一致
			$material['advertiser'] = "灵集"; //DSP平台广告主名称，需要和资质文件中的广告主名称一致
			$material['startdate'] = date('Y-m-d',$plan_info->start_date);
			if($plan_info->end_date ==0){
				$time_stamp = 4102416000; //0为不限，故传值2100年1月1日，
				$material['enddate'] = date('Y-m-d',$time_stamp);
			}else{
				$material['enddate'] = date('Y-m-d',$plan_info->end_date);
			}

			$material['monitor'] = array($ad_info->show_js); //必填项，第三方展示监控
//			$material['monitorPosition'] = $parameter['monitorPosition'];
			$material['cm'] = array($ad_info->click_js); //必填项，第三方点击监控
//			$material['type'] = $parameter['type'];
			$material['action'] = $stuff_info->ad_action;
		}elseif($ad_info->view_type ==1002){
			$adx_data['creativeType'] = 2;
			$natived = array();
			$natived['creativeId'] = (string)$ad_info->adid;
//			$natived['category'] = $parameter['category'];  //暂不使用
			$stu = end(explode(".", $stuff_info->addr));
			$type_image = array("gif","png","jpeg","jpg");
			$type_video = array("MP4","mp4","flv","swf");
			$pic = array();
			$icon = array();
			$logo = array();
			if(in_array($stu,$type_image)){
				if(strlen($stuff_info->icon_addr) >0){
					$icon['type'] = 1;  //1-icon 2-logo 3-main(image)
					$icon['width'] = $stuff_info->icon_width;
					$icon['height'] = $stuff_info->icon_height;
					$icon['url'] = $stuff_info->icon_addr;
				}
				if(strlen($stuff_info->logo_addr) >0){
					$logo['type'] = 2;  //1-icon 2-logo 3-main(image)
					$logo['width'] = $stuff_info->logo_width;
					$logo['height'] = $stuff_info->logo_height;
					$logo['url'] = $stuff_info->logo_addr;
				}
				if(strlen($stuff_info->addr) >0){
					$pic['type'] = 3;  //1-icon 2-logo 3-main(image)
					$pic['width'] = $stuff_info->width;
					$pic['height'] = $stuff_info->height;
					$pic['url'] = $stuff_info->addr;
				}

				$natived['nativepic'] = array($icon,$logo,$pic);
				if(strlen($stuff_info->icon_addr) ==0){
					unset($natived['nativepic'][0]);
				}
				if(strlen($stuff_info->logo_addr) ==0){
					unset($natived['nativepic'][1]);
				}
				foreach($natived['nativepic'] as $a){
					$m[] = $a;
				}
				$natived['nativepic'] = $m;

			}

			if(in_array($stu,$type_video)){
				$video = array();
				$video['width'] = $stuff_info->width;
				$video['height'] = $stuff_info->height;
				$video['url'] = $stuff_info->addr;
				$video['duration'] = $stuff_info->duration;
				$video['coverurl'] = "https://www.coverurl.com";
				$natived['nativevideo'] = array($video);
			}

			$natived['landingpage'] = $stuff_info->landing_page;
			$natived['deeplinkurl'] = $stuff_info->deeplinkurl;
			$natived['advertiser'] = "灵集";
			$natived['startdate'] = date('Y-m-d',$plan_info->start_date);
			if($plan_info->end_date ==0){
				$time_stamp = 4102416000; //0为不限，故传值2100年1月1日，
				$natived['enddate'] = date('Y-m-d',$time_stamp);
			}else{
				$natived['enddate'] = date('Y-m-d',$plan_info->end_date);
			}
			$natived['monitor'] = array($ad_info->show_js);
			$natived['title'] = $stuff_info->title;
			$natived['description'] = $stuff_info->desc;
			$natived['source'] = " ";
			$natived['action'] = $stuff_info->ad_action;
			if($stuff_info->ad_action == 2){
				$download_info = array();
				$download_info['app_type'] = $stuff_info->app_type;  //0为 Android，1为 ios
				$download_info['packagename'] = $stuff_info->packagename;
				$download_info['appname'] = $stuff_info->appname;
				if($stuff_info->app_type ==0){
					$download_info['app_intro_url'] = $stuff_info->app_intro_url;
				}
				$download_info['app_size'] = $stuff_info->app_size;
				$download_info['app_ver'] = $stuff_info->app_ver;
				if($parameter['app_type'] ==0){
					$download_info['app_id'] = $stuff_info->app_id;
				}else{
					$download_info['itunesId'] = $stuff_info->itunesId;
				}
				$natived['download_info'] = (object)$download_info;
			}

		}
		if($ad_info->view_type ==1001 || $ad_info->view_type ==1004){
			unset($natived);
			$adx_data['material'] = array($material);
		}else{
			unset($material);
			$adx_data['natived'] = array($natived);
		}

		$data_json = json_encode($adx_data,JSON_UNESCAPED_SLASHES);
//		var_dump($data_json);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch,CURLOPT_URL,$post_url);
		if( count($aHeader) >= 1 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8','Content-Length:'.strlen($data_json)));
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data_json);
		$result = curl_exec($ch);
		if($result){
			return $result;
		}else{
			return curl_error($ch);
		}
		curl_close($ch);
	}


	/**
	 * @param $parameter
	 * @param int $timeout
	 * @param array $aHeader
	 * @return mixed|string
	 * @date 2018-04-26
	 * @description 提交哇棒的广告
	 */
	public function CurlPostStuff($parameter,$timeout = 40,$aHeader=array(),$apiType=1){
		$curl_post = SConfig::getConfigArray(ROOT_CONFIG."/config.php","wb_curl_post");
		switch ($apiType){
			case 1: //创意新增/修改
				$post_url = $curl_post['post_url']."/creative/add";
				break;
			case 2:  //创意查询
				$post_url = $curl_post['post_url']."/creative/query";
				break;

			case 3:  //创意状态查询
				$post_url = $curl_post['post_url']."/creative/queryAuditState";
				break;
			default:
				$post_url = "";
		}


		$ad_info = $parameter['ad_info'];
		$stuff_info = $parameter['stuff_info'];
		$plan_info = $parameter['plan_info'];
		$adx_data = array();
		$adx_data['id'] = $curl_post['id'];
		$adx_data['token'] = $curl_post['token'];

		$data_json = json_encode($adx_data,JSON_UNESCAPED_SLASHES);

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch,CURLOPT_URL,$post_url);
		if( count($aHeader) >= 1 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8','Content-Length:'.strlen($data_json)));
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data_json);
		$result = curl_exec($ch);
		if($result){
			return $result;
		}else{
			return curl_error($ch);
		}
		curl_close($ch);

	}




	//生成消息文本
	private function generateMsgText($operate_num, $object_list) {
		if ($operate_num < 100)
			return;
		$subject = '广告审核结果';
		$num = count($object_list);
		$body = '有 '.$num.' 个';

		//十位数，原先的状态
		$code = substr($operate_num, 1, 1);
		if ( $code == '1') {
			$body .= '等待审核的';
		} else if ($code == '2') {
			$body .= '原先已审核通过的';
		} else if ($code == '3') {
			$body .= '原先已被拒绝的';
		} else if ($code == '5') {
			$body .= '原先已被批复的';
		}

		//百位数，操作对象的类型
		$code = substr($operate_num, 0, 1);
		if ( $code == '1') {
			$body .= '计划,';
		} else if ($code == '2') {
			$body .= '素材,';
		}

		//个位数，被操作之后的状态
		$code = substr($operate_num, 2, 1);
		if ( $code == '1') {
			$body .= '已经被置为等待审核的状态。';
		} else if ($code == '2') {
			$body .= '已经被置为审核通过。';
		} else if ($code == '3') {
			$body .= '已经被拒绝。';
		} else if ($code == '4') {
			$body .= '已经被置为待批复。';
		} else if ($code == '5') {
			$body .= '已经被置位已批复。';
		}

		$body .=  '被审核的内容如下：';
		if(is_array($object_list)){
			foreach ($object_list as $obj) {
				$body .= $obj. ' ';
			}
		}else{
			$body .= $object_list. ' ';
		}

		$msgText = array();
		$msgText['subject'] = $subject;
		$msgText['body'] = $body;
		return $msgText;
	}



}

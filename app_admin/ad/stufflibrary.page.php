<?php
class ad_stufflibrary extends STpl{

//    public $configForTa;

	public function __construct($inPath){
		if(user_api::id()==0){
			header("location:/baichuan_advertisement_manage/user");
		}
		$config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'version');
		$this->assign("config",$config);
		$adTypesInfo = array(

				1001 => array(
//						'name' => '灵集-banner'
						'name' => 'banner'
				),
				1002 => array(
//						'name' => '灵集-普通信息流',
						'name' => '普通信息流',
						'tip' => '需要上传图标，图标规则为正方形'
				),
//				1003 => array(
//						'name' => 'Inmobi-原生|启动页'
//				),
				1004 => array(
//						'name' => '灵集-视频',
						'name' => '视频',
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

//		$this->configForTa = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'ta');
	}
	public function pageEntry($inPath){
		$ads=array();
		$this->assign("ads",$ads);
		return $this->render("v2/ad/scList.html");
	}

	/**
	 * @param $inPath
	 * 新增素材
	 */
	public function pageAdd($inPath){

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
		$host = SConfig::getConfig(ROOT_CONFIG."/js.conf","host");
		$industryInfoModel = new model_industryInfo();
		$industry_list = $industryInfoModel->getData();
		$this->assign("industry_list",$industry_list);

		if(empty($inPath[3]) || $_REQUEST['stuff_id'] >0){
			$stufflibraryModel = new model_stuffLibrary();
			$stuffInfo = $stufflibraryModel->getData(array("stuff_id"=>$_REQUEST['stuff_id']));
			$this->assign("stuffInfo",$stuffInfo[0]);

			return $this->render("material/materialNew.html");

		}else{ //新增素材
			//新增页面跳转而来
			$response['error'] = 0;
			
			$response['message'] = "";
			$stuff_width = 0;
			$stuff_height = 0;
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

								$stuff_width = $wid;
								$stuff_height = $hei;
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
								$stuff_width = $img_wid;
								$stuff_height = $img_hei;

								if(false && $flag == 0){
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
                        
			if($response['error'] > 0){
                            
				$this->assign("response",$response);
				return $this->render("material/materialNew.html");
				exit();

			}else{
                                   
				$stuffInfo['name']   =   $_POST['adname'];
				$stuffInfo['uid']	   =   user_api::id();
				$stuffInfo['ctime']  =   $stuffInfo['mtime']   =   time();
				$stuffInfo['description'] = $_POST['desc'];
				if(isset($_POST['title'])){
					$stuffInfo['title'] = $_POST['title'];
				}
				if(isset($_POST['landing_page'])){
					if( stripos($_POST['landing_page'], "http://") === 0 || stripos($_POST['landing_page'], "https://") === 0 ){
						$stuffInfo['landing_page'] = $_POST['landing_page'];
					}else{
						$stuffInfo['landing_page'] = "";
					}
				}
                                 
				if(isset($_POST['view_type']) && $_POST['view_type'] == 1002 && isset($_FILES['ad-icon-file'])){
					$result = $this->saveFile($_FILES['ad-icon-file']);
					if(isset($result['error'])){

					}elseif($result['fileid']){
						$stuffInfo['icon_addr'] = "https://".$host->stuff."/".$result['fileid'];
						$stuffInfo['icon_width'] = $result['width'];
						$stuffInfo['icon_height'] = $result['height'];
						$stuffInfo['type']   = $result['type'];
						$stuffInfo['icon_mime_type'] = $result['mime_type'];
					}
				}
				//logo

				if(isset($_POST['view_type']) && $_POST['view_type'] == 1002 && isset($_FILES['ad-logo-file'])){
					$result = $this->saveFile($_FILES['ad-logo-file']);
					if(isset($result['error'])){

					}elseif($result['fileid']){
						$stuffInfo['logo_addr'] = "https://".$host->stuff."/".$result['fileid'];
						$stuffInfo['logo_width'] = $result['width'];
						$stuffInfo['logo_height'] = $result['height'];
						$stuffInfo['type']   = $result['type'];
						$stuffInfo['icon_mime_type'] = $result['mime_type'];
					}
				}
                                    
				if(isset($_FILES['ad-image-file'])){
					$result = $this->saveFile($_FILES['ad-image-file']);
					if(isset($result['error'])){

					}elseif($result['fileid']){
						$stuffInfo['addr']   = "https://".$host->stuff."/".$result['fileid'];
						$stuffPropertys = array("width","height","type","mime_type","frame_rate","duration","bitrate","size");
						foreach ($stuffPropertys as $stuffProperty){
							if(isset($result[$stuffProperty])){
								$stuffInfo[$stuffProperty] = $result[$stuffProperty];
							}
						}

						$stuffInfo['width']     = $stuff_width;
						$stuffInfo['height']    = $stuff_height;
					}
				}
                                          
				if(isset($_POST['show_js'])){
					$stuffInfo['show_js']=$_POST['show_js'];
				}
				if(isset($_POST['click_js'])){
					$stuffInfo['click_js']=$_POST['click_js'];
				}
				if(isset($_POST['view_type'])){
					$stuffInfo['adType']=$_POST['view_type'];
				}
				if(isset($_POST['industry_id']) && $_POST['industry_id'] >0){
					$stuffInfo['industry_id']=$_POST['industry_id'];
				}
				if(isset($_POST['tel_number'])){
					$stuffInfo['tel_number']=$_POST['tel_number'];
				}

				if(isset($_POST['start_date'])){
					$stuffInfo['valid_startTime'] = strtotime($_POST['start_date']);
				}
				if(isset($_POST['end_date'])){
					$stuffInfo['valid_endTime'] = strtotime($_POST['end_date']);
				}else{
					$stuffInfo['valid_endTime'] = 0; //0为不限
				}

				//灵集中，对接信息流素材时APP信息字段
				if(isset($_POST['app_type'])){
					$stuffInfo['app_type']=$_POST['app_type'];
				}
				if(isset($_POST['packagename'])){
					$stuffInfo['packagename']=$_POST['packagename'];
				}
				if(isset($_POST['appname'])){
					$stuffInfo['appname']=$_POST['appname'];
				}
				if(isset($_POST['app_intro_url'])){
					$stuffInfo['app_intro_url']=$_POST['app_intro_url'];
				}
				if(isset($_POST['app_size'])){
					$stuffInfo['app_size']=$_POST['app_size'];
				}
				if(isset($_POST['app_ver'])){
					$stuffInfo['app_ver']=$_POST['app_ver'];
				}
				if(isset($_POST['itunesId'])){
					$stuffInfo['itunesId']=$_POST['itunesId'];
				}
				if(isset($_POST['app_id'])){
					$stuffInfo['app_id']=$_POST['app_id'];
				}
				if(isset($_POST['deeplink-url'])){
					$stuffInfo['deeplinkurl']=$_POST['deeplink-url'];
				}
				if(isset($_POST['ad_action'])){
					$stuffInfo['ad_action']=$_POST['ad_action'];
				}
				if(!empty($_POST['stuff_type'])){
					$stuffInfo['type']=$_POST['stuff_type'];
				}

				$stuffInfo['ad_stuff_platform'] = 1; //0为本平台素材，1为同步到灵集的素材
                             
				//为赢纳测试方便加的
				if(user_api::auth('admin')) {
					$stuffInfo['verified_or_not'] = 2;
				}else{
					$stuffInfo['verified_or_not'] = 1;
				}

				$stufflibraryModel = new model_stuffLibrary();
				$stuffStatusModel = new model_stuffStatus();
				$mediaListModel = new model_rmcbjMedia();
				$id = $stufflibraryModel->addData($stuffInfo);
                                  
				if($id > 0){
					$stuff_id = $id;
					$media_list = $mediaListModel->getData(array("media_status"=>1)); //media_status 0为禁用，1为启用
					if(!empty($media_list)){
						foreach($media_list as $media){
							$status_data = [];
							$status_data['stuff_id'] = $stuff_id;
							$status_data['media_id'] = $media['id'];
							$status_data['media_name'] = $media['media_name'];
							$status_data['identification'] = $media['identification'];
							if(user_api::auth('admin')) {
								$status_data['stuff_audit_status'] = 2;// 素材状态，1为待审核，2为审核通过，3为审核不通过
							}else{
								$status_data['stuff_audit_status'] = 1;
							}
							$status_data['ctime'] = time();
							$status_data['mtime'] = time();
							$stuff_status_id = $stuffStatusModel->addData($status_data);
						}
					}

					//提交到灵集平台
//					$ad_data = array();
//					$ad_data = $stufflibraryModel->getData(array("stuff_id"=>$stuff_id));
//
//					if(!empty($ad_data)){
//						$res = $this->CurlAdExchange($ad_data[0]);
//						$res2 = $this->CurlPostStuff($ad_data[0]);
//
//					}
//
//					$sms= json_decode($res);
//					$sms2= json_decode($res2);
//					$host = SConfig::getConfig(ROOT_CONFIG."/js.conf","host");
//					$flag =0;
					$flag =1;
//					if(strlen(json_encode($sms->message)) >2 || $sms2->code != 200){
//						$flag =1;
//					}
//					if(strlen(json_encode($sms->message)) >2 && $sms2->code != 200){
//						$flag =2;
//					}
////					if($flag >0){
//						$del_res_ad = $stufflibraryModel->deleteData(array("stuff_id"=>$stuff_id));
//						$del_res_stuff = $stuffStatusModel->deleteData(array("stuff_id"=>$stuff_id));
//						if(strlen(json_encode($sms->message)) >2){
//							$errormsg = json_encode($sms->message);
//						}
//						if($sms2->code != 200){
//							$errormsg2 = $sms2->error_hint;
//						}
//						$url="https://".$host->admin."/ad.stufflibrary.Add"."?nav=8";
//						$error = $errormsg.$errormsg2;
//						$this->success("提交到第三方媒体平台错误，错误信息为:$error", $url, 3);
//						exit();

////				}else{
                                                 
						if(user_api::auth('admin')){
							$stufflibraryModel->updateData(array("verified_or_not"=>2),array("stuff_id"=>$id));
							//初始化审核日志
							$log = new admin_logapi;
							$operate_uid = user_api::id();
							$uid=$stuffInfo['uid'];
							$operate_num = 212; //操作代码，表示 2：素材 由1：等待审核 转为 2：审核通过
							$msgText = $this->generateMsgText($operate_num, $id); //生成文本信息
							$log->addLog($operate_uid, $uid, $operate_num, $id, $msgText['body']);//日志生成
							$data = array();
							$data['mtime'] = time();
							$data['last_operator'] = user_api::name();
							if(isset($_POST['submit_or_not']) && $_POST['submit_or_not']==0){
								$data['verified_or_not'] =0;
								$stufflibraryModel->updateData($data,array("stuff_id"=>$id));

							}
						}else{

							if(isset($_POST['submit_or_not'])&&$_POST['submit_or_not']==1){
								$data['verified_or_not'] =1;
								$stufflibraryModel->updateData($data,array("stuff_id"=>$id));

							}else{
								$data['verified_or_not'] =0;
								$stufflibraryModel->updateData($data,array("stuff_id"=>$id));
							}
						}

						$url="https://".$host->admin."/baichuan_advertisement_manage/ad.stufflibrary.List"."?nav=8";
						$this->success("提交成功", $url, 2);
						exit();
//						ob_start();
//						echo "<script> alert('提交成功！'); </script>";
//						ob_end_flush();
//						header("Refresh: 1; url=$url");

					}

////				}

			}

		}

	}

	/**
	 * 素材库
	 */
	public function pageList($inPath){
		$ownuser = array_unique($this->getOwnuser());
		$user = user_api::info();
		$role_id = $user->role_id; //当前用户角色id 10000：系统管理员，1000：运营商 18：子运营商，12：客户经理，13：广告主
		$condition = array();
		if (!empty($_GET['audit_status'])) {
			$status = $_GET['audit_status'];
			$condition['verified_or_not'] = $status;  //verified_or_not 为1 待审，2 通过，3 未通过
		}
		$like = array();
		if (!empty($_GET['stuff_name'])) {
			$stuff_name = $_GET['stuff_name'];
			$like['name'] = "%".trim($_GET['stuff_name'])."%";
		}

		$stufflibraryModel = new model_stuffLibrary();
		$stuff_lib_list = $stufflibraryModel->getDataLike($condition,$like,0,-1,"stuff_id","desc");
		foreach ($stuff_lib_list as $k=>$v) {
			if (!in_array($v['uid'], $ownuser)) {
				unset($stuff_lib_list[$k]);
			}
		}

		foreach($stuff_lib_list as $stuff){
			if (!isset($adSopnsorArray[$stuff['uid']])) {
				$adSopnsorArray[$stuff['uid']] = user_api::getUserByID($stuff['uid'])->user_name;
			}
			$stuff['userName'] = $adSopnsorArray[$stuff['uid']];
		}
		$page = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
		$pageSize = !empty($_REQUEST['ps'])?$_REQUEST['ps']:100;
		$stuff_list = $stuff_lib_list;
		// 分页操作
		$total = count($stuff_list);
		if ($_GET['pageNum']) {
			$pageNum = $_GET['pageNum'];
		} else {
			$pageNum = 1;
		}
		$pageSize = 15;
		if ($pageNum * $pageSize - 1 <= $total) {
			$start = ($pageNum - 1) * $pageSize;
			$end = $pageNum * $pageSize - 1;
		} else {
			$start = ($pageNum - 1) * $pageSize;
			$end = $total - 1;
		}
		$stuff_list = array_slice($stuff_list, $start, $pageSize);
		$stuff_list = json_encode($stuff_list);
		$stuff_list = json_decode($stuff_list);

		$totalPage = ceil($total / $pageSize);

		$this->assign("totalPage", $totalPage);
		$this->assign("pageNum", $pageNum);
		$this->assign('total', $total);
		$this->assign("adSopnsorArray",$adSopnsorArray);
		$this->assign("stuff_name",$stuff_name);
		$this->assign("status",$status);
		$this->assign("nav",$_GET['nav']);
		$this->assign("stuff_lib_list",$stuff_list);

		return $this->render("material/materialList.html");
	}

	/**
	 * @param $inPath
	 * 素材审核列表
	 */
	public function pageAuditedList($inPath)
	{
		$condition = array();
		if (!empty($_GET['audit_status'])) {
			$status = $_GET['audit_status'];
			$condition['verified_or_not'] = $status;  //verified_or_not 为1 待审，2 通过，3 未通过
		}
		$like = array();
		if (!empty($_GET['stuff_name'])) {
			$stuff_name = $_GET['stuff_name'];
			$like['name'] = "%".trim($_GET['stuff_name'])."%";
		}
		$stufflibraryModel = new model_stuffLibrary();
		$stuff_lib_list = $stufflibraryModel->getDataLike($condition,$like,0,-1,"stuff_id","desc");
		$ownuser = array_unique($this->getOwnuser());
		foreach ($stuff_lib_list as $k=>$v) {
			if (!in_array($v['uid'], $ownuser)) {
				unset($stuff_lib_list[$k]);
			}
		}


		foreach($stuff_lib_list as $stuff){
			if (!isset($adSopnsorArray[$stuff['uid']])) {
				$adSopnsorArray[$stuff['uid']] = user_api::getUserByID($stuff['uid'])->user_name;
			}
			$stuff['userName'] = $adSopnsorArray[$stuff['uid']];
		}
		$page = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
		$pageSize = !empty($_REQUEST['ps'])?$_REQUEST['ps']:100;
		$stuff_list = $stuff_lib_list;
		// 分页操作
		$total = count($stuff_list);
		if ($_GET['pageNum']) {
			$pageNum = $_GET['pageNum'];
		} else {
			$pageNum = 1;
		}
		$pageSize = 15;
		if ($pageNum * $pageSize - 1 <= $total) {
			$start = ($pageNum - 1) * $pageSize;
			$end = $pageNum * $pageSize - 1;
		} else {
			$start = ($pageNum - 1) * $pageSize;
			$end = $total - 1;
		}
		$stuff_list = array_slice($stuff_list, $start, $pageSize);
		$stuff_list = json_encode($stuff_list);
		$stuff_list = json_decode($stuff_list);

		$totalPage = ceil($total / $pageSize);

		$this->assign("totalPage", $totalPage);
		$this->assign("pageNum", $pageNum);
		$this->assign('total', $total);
		$this->assign("adSopnsorArray",$adSopnsorArray);
		$this->assign("stuff_name",$stuff_name);
		$this->assign("status",$status);
		$this->assign("nav",$_GET['nav']);
		$this->assign("stuff_lib_list",$stuff_list);

		return $this->render("material/materialAudit.html");
	}

	/**
	 * @param $inPath
	 * 获取单个素材信息
	 */
	public function pageGetOne($inPath)
	{
		$stuff_id = $_REQUEST['stuff_id']; //素材id
		$stufflibraryModel = new model_stuffLibrary();
		$stuffStatusModel = new model_stuffStatus();
		$stuffs = $stufflibraryModel->getData(array("stuff_id"=>$stuff_id));
		$stuff_status = $stuffStatusModel->getData(array("stuff_id"=>$stuff_id));

		foreach($stuffs as $stuff){
			if (!isset($adSopnsorArray[$stuff['uid']])) {
				$adSopnsorArray[$stuff['uid']] = user_api::getUserByID($stuff['uid'])->user_name;
			}
			$stuff['userName'] = $adSopnsorArray[$stuff['uid']];
		}
		$this->assign("adSopnsorArray",$adSopnsorArray);
		$this->assign("stuff",$stuffs[0]);
		$this->assign("stuff_status",$stuff_status);
		return $this->render("material/materialDetail.html");
	}


	/**
	 * @param $inPath
	 * 获取所有已通过的素材
	 */
	public function pageGetStuffLib($inPath){
		$condition = array();
//		if (!empty($_GET['audit_status'])) {
//			$status = $_GET['audit_status'];
//			$condition['verified_or_not'] = $status;  //verified_or_not 为1 待审，2 通过，3 未通过
//		}
		$condition['verified_or_not'] = 2;
		$like = array();
		if (!empty($_GET['stuff_name'])) {
			$stuff_name = $_GET['stuff_name'];
			$like['name'] = "%".trim($_GET['stuff_name'])."%";
		}

		$stufflibraryModel = new model_stuffLibrary();
		$stuffStatusModel = new model_stuffStatus();
		$mediaListModel = new model_rmcbjMedia();
//		$media_list = $mediaListModel->getData(array("media_status"=>1)); //media_status 0为禁用，1为启用
//		var_dump($media_list);die(fdswwew);
//		$media_id_arr = array_unique(array_column($media_list,"identification")); //identification 为媒体标识

		$stuff_lib_list = $stufflibraryModel->getDataLike($condition,$like,0,-1,"stuff_id","desc");
		$stuff_status = $stuffStatusModel->getData(array("stuff_audit_status"=>2));
		$stuff_id_arr = array_unique(array_column($stuff_status,"stuff_id"));
		$ownuser = array_unique($this->getOwnuser());
		foreach ($stuff_lib_list as $k=>$v) {
			if (!in_array($v['uid'], $ownuser)) {
				unset($stuff_lib_list[$k]);
			}
			if(!in_array($v['stuff_id'],$stuff_id_arr)){
				unset($stuff_lib_list[$k]);
			}
		}

		foreach($stuff_lib_list as $stuff){
			if (!isset($adSopnsorArray[$stuff['uid']])) {
				$adSopnsorArray[$stuff['uid']] = user_api::getUserByID($stuff['uid'])->user_name;
			}
			$stuff['userName'] = $adSopnsorArray[$stuff['uid']];
		}
		$page = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
		$pageSize = !empty($_REQUEST['ps'])?$_REQUEST['ps']:100;
		$stuff_list = $stuff_lib_list;
		// 分页操作
		$total = count($stuff_list);
		if ($_GET['pageNum']) {
			$pageNum = $_GET['pageNum'];
		} else {
			$pageNum = 1;
		}
		$pageSize = 15;
		if ($pageNum * $pageSize - 1 <= $total) {
			$start = ($pageNum - 1) * $pageSize;
			$end = $pageNum * $pageSize - 1;
		} else {
			$start = ($pageNum - 1) * $pageSize;
			$end = $total - 1;
		}
		$stuff_list = array_slice($stuff_list, $start, $pageSize);
		$stuff_list = json_encode($stuff_list);
		$stuff_list = json_decode($stuff_list);

		$totalPage = ceil($total / $pageSize);

		$this->assign("totalPage", $totalPage);
		$this->assign("pageNum", $pageNum);
		$this->assign('total', $total);
		$this->assign("adSopnsorArray",$adSopnsorArray);
		$this->assign("stuff_name",$stuff_name);
		$this->assign("status",$status);

		$this->assign("stuff_lib_list",$stuff_list);


		return $this->render("material/materialListNoMain.html");


	}

	/**
	 * @param $inPath
	 * 本平台素材审核
	 */
	public function pageUpdateStatus($inPath){

		if(!empty($_REQUEST['type']) && !empty($_REQUEST['data_list'])){
			$status = $_REQUEST['type'];
			$data = [];
			if($status ==2){ //2 通过 3 未通过
				$data['verified_or_not'] = 2;
			}else{
				$data['verified_or_not'] = 3;
			}
			$stufflibraryModel = new model_stuffLibrary();
			$condition = [];

			foreach($_REQUEST['data_list'] as $uid=>$stuff_list){
				$condition['stuff_id'] = $stuff_list[0];
				$id = $stufflibraryModel->updateData($data,$condition);
			}
			if($id){
				return SJson::encode(array("code"=>1,"msg"=>"审核状态更新成功"));
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
		$stuff_info = (object)$parameter;
		$adx_data = array();
		$adx_data['dspid'] = $curl_post['dspid'];
		$adx_data['token'] = $curl_post['token'];
		if($stuff_info->adType ==1001 || $stuff_info->adType ==1004){ //1001为banner，1002为信息流，1004为video
			$adx_data['creativeType'] = 1;  //1.普通物料banner或video 2.普通信息流
			$material = array();
			$material['creativeId'] = (string)$stuff_info->stuff_id; //广告创意id
			$material['name'] = $stuff_info->name; //广告创意名称
			$material['vendorId'] = 0; //素材所投放的渠道媒体ID，渠道媒体为 0-灵集 vendorId指定为0，默认为0
			$material['url'] = $stuff_info->addr; //物料地址
			$material['width'] = $stuff_info->width;
			$material['height'] = $stuff_info->height;
			$material['duration'] = $stuff_info->duration;  //素材时长，图片类素材制定素材时长为零
			$material['landingpage'] = $stuff_info->landing_page;
			$material['deeplinkurl'] = $stuff_info->deeplinkurl;
//			$material['advertiser'] = $stuff_info->uid; //DSP平台广告主名称，需要和资质文件中的广告主名称一致
			$material['advertiser'] = "灵集"; //DSP平台广告主名称，需要和资质文件中的广告主名称一致
			$material['startdate'] = date('Y-m-d',$stuff_info->valid_startTime);
			if($stuff_info->valid_endTime ==0){
				$time_stamp = 4102416000; //0为不限，故传值2100年1月1日，
				$material['enddate'] = date('Y-m-d',$time_stamp);
			}else{
				$material['enddate'] = date('Y-m-d',$stuff_info->valid_endTime);
			}

			$material['monitor'] = array($stuff_info->show_js); //必填项，第三方展示监控
//			$material['monitorPosition'] = $parameter['monitorPosition'];
			$material['cm'] = array($stuff_info->click_js); //必填项，第三方点击监控
//			$material['type'] = $parameter['type'];
			$material['action'] = $stuff_info->ad_action;
		}elseif($stuff_info->adType ==1002){
			$adx_data['creativeType'] = 2;
			$natived = array();
			$natived['creativeId'] = (string)$stuff_info->stuff_id;
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
			$natived['startdate'] = date('Y-m-d',$stuff_info->valid_startTime);
			if($stuff_info->valid_endTime ==0){
				$time_stamp = 4102416000; //0为不限，故传值2100年1月1日，
				$natived['enddate'] = date('Y-m-d',$time_stamp);
			}else{
				$natived['enddate'] = date('Y-m-d',$stuff_info->valid_endTime);
			}
			$natived['monitor'] = array($stuff_info->show_js);
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
		if($stuff_info->adType ==1001 || $stuff_info->adType ==1004){
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
		$stuff_info = (object)$parameter;
		$adx_data = [];
		$data = [];
		if(!empty($parameter)){
			$data['advertiser_id'] = 6;
			$data['creative_id'] = $stuff_info->stuff_id;
			if($stuff_info->type == 6){
				$data['type'] = 3;
			}elseif($stuff_info->type == 3){
				$data['type'] = 4; //类型 1:图片 2:flash 3:视频 4:图文
			}else{
				$data['type'] = intval($stuff_info->type);
			}

			$data['adview_type'] = 2; //1:web 2:mobile 3:video 默认web
			$data['creative_url'] = $stuff_info->addr; //创意URL
			$data['landing_page'] = $stuff_info->landing_page; //目标地址
//			$data['impress_url'] = $stuff_info->show_js; //展示监控地址
//			$data['click_url'] = $stuff_info->click_js;  //点击监控地址
			$data['height'] = intval($stuff_info->height);
			$data['width'] = intval($stuff_info->width);
//			$data['creative_trade_id'] = 9901;  //行业id 必须字段
			$data['creative_trade_id'] = intval($stuff_info->industry_id);  //行业id 必须字段
			if($stuff_info->ad_action ==3){ //互动类型 0:无 1:电话 2：下载 5:deeplink
				$data['interactive_style'] = 1;
				$data['tel_no'] = $stuff_info->tel_number;
			}

			if($stuff_info->ad_action ==2){ //2 为下载
				$data['download_url'] = $stuff_info->download_url;
				$data['app_name'] = $stuff_info->appname;
				$data['app_desc'] = $stuff_info->app_size;
				$data['app_pageage_size'] = $stuff_info->app_size;
			}
			if($stuff_info->ad_action ==5){ //5为deeplink
				$data['appPackageName'] = $stuff_info->packagename;
				$data['deeplink_url'] = $stuff_info->deeplinkurl;
				$data['app_version'] = $stuff_info->app_ver;
				$data['fallback_type'] = 1;
			}

		}
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

		$adx_data['auth'] = array(
				"id"=>$curl_post['id'],
				"token"=>$curl_post['token']);
		$adx_data['request'] = $data;

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





	//生成消息文本
	public function generateMsgText($operate_num, $object_list) {
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


	/**
	 * *
	 * 获取当前用户的管理用户列表
	 */
	public function getOwnuser()
	{
		$info = user_api::info();
		$user_model = new model_userInfo();
		if ($info->role_id == 13) {
			//广告主只能查看自己
			$uids[] = $info->uid;
			return $uids;
		}
		if ($info->role_id == 10000||$info->role_id==1000) {
			//1，管理员首先可以查看自己
			$uids[] = $info->uid;
			$condition1 = array();
			//2查看自己创建的的子运营的账号
			$condition1['creator_id'] = $info->uid;
			$condition1['role_id'] = 18;
			$userOp = $user_model->getData($condition1, 0, - 1);
			if ($userOp) {
				foreach ($userOp as $v2) {
					array_push($uids, $v2['uid']);
					//3.查看自己创建的客户经理的账号
					$condition2['creator_id'] = $v2['uid'];
					$condition2['role_id'] = 12;
					$userManager1 = $user_model->getData($condition2, 0, - 1);
					if ($userManager1) {
						foreach ($userManager1 as $v3) {
							array_push($uids, $v3['uid']);
							//3.查看自己创建的广告主的账号
							$condition3['creator_id'] = $v3['uid'];
							$condition3['role_id'] = 13;
							$userAdvertise1 = $user_model->getData($condition3, 0, - 1);
							if ($userAdvertise1 ) {
								foreach ($userAdvertise1  as $v4) {
									array_push($uids, $v4['uid']);
								}
							}
						}
					}

				}
			}
			//3.查看自己创建的客户经理的账号
			$condition4['creator_id'] = $info->uid;
			$condition4['role_id'] = 12;
			$userManager2 = $user_model->getData($condition4, 0, - 1);
			if ($userManager2) {
				foreach ($userManager2 as $v5) {
					array_push($uids, $v5['uid']);
					//3.查看自己创建的广告主的账号
					$condition5['creator_id'] = $v5['uid'];
					$condition5['role_id'] = 13;
					$userAdvertise2 = $user_model->getData($condition5, 0, - 1);
					if ($userAdvertise2 ) {
						foreach ($userAdvertise2  as $v6) {
							array_push($uids, $v6['uid']);
						}
					}
				}
			}
			//3.查看自己创建的广告主的账号
			$condition['creator_id'] = $info->uid;
			$condition['role_id'] = 13;
			$userAdvertise = $user_model->getData($condition, 0, - 1);
			if ($userAdvertise ) {
				foreach ($userAdvertise  as $v) {
					array_push($uids, $v);
				}
			}
			return $uids;
		}
		//子运营商角色
		if ($info->role_id == 18) {
			// 1，子运营商首先可以查看自己
			$uids[] = $info->uid;
			$condition = array();
			//2.查看自己创建的客户经理的账号
			$condition['creator_id'] = $info->uid;
			$condition['role_id'] = 12;
			$userManager = $user_model->getData($condition, 0, - 1);
			if ($userManager) {
				foreach ($userManager as $v) {
					array_push($uids, $v['uid']);
					//3.查看自己创建的广告主的账号
					$condition['creator_id'] = $v['uid'];
					$condition['role_id'] = 13;
					$userAdvertise = $user_model->getData($condition, 0, - 1);
					if ($userAdvertise ) {
						foreach ($userAdvertise  as $v) {
							array_push($uids, $v['uid']);
						}
					}

				}
			}
			//3.查看自己创建的广告主的账号
			$condition2['creator_id'] = $info->uid;
			$condition2['role_id'] = 13;
			$userAdvertise2 = $user_model->getData($condition2, 0, - 1);
			if ($userAdvertise2 ) {
				foreach ($userAdvertise2  as $v2) {
					array_push($uids, $v2['uid']);
				}
			}
			return $uids;
		}
		//客户经理角色
		if ($info->role_id == 12) {
			// 1，客户经理首先可以查看自己
			$uids[] = $info->uid;
			$condition = array();
			//3.查看自己创建的广告主的账号
			$condition['creator_id'] = $info->uid;
			$condition['role_id'] = 13;
			$userAdvertise = $user_model->getData($condition, 0, - 1);
			if ($userAdvertise ) {
				foreach ($userAdvertise  as $v) {
					array_push($uids, $v['uid']);
				}
			}
			return  $uids;
		}

	}



}

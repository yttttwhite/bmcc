<?php
//用户表：adp_plan_info
class model_planInfo extends model_Model{
    public $table = "plan_info";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        parent::__construct($this->table);
    }
    
    public function getStat($condition=0, $start='', $limit='', $order='', $orderType="ASC"){
        $table = parent::table($this->table);
        $sql = "SELECT `uid` , `verified_or_not` , `enable`, `total_cpt`,COUNT(*) AS `count` FROM `$table` GROUP BY `uid` , `verified_or_not` , `enable` ,`total_cpt`";
        $result = parent::fetch_all($sql);
        return($result);
    }

    /**
     * @param $request
     * @param $key
     * @return bool|string
     * @description 校验接口中dspid和token是否正确
     */
    public function authorize($request,$key)
    {
        $dspid = $key['dspid'];
        $token = $key['token'];
        $errorMsg = '';
        if(empty($request)){
            $errorMsg = "请求参数不能为空";
        }else{
            if($request['dspid'] != $dspid){
                $errorMsg = "dspid不正确";
            }
            if($request['token'] != $token){
                $errorMsg = "token不正确";
            }
        }

        if(strlen($errorMsg) > 0){
            $result = array('result'=>1,'message'=>$errorMsg); //0：执行成功 1:系统认证失败 2:请求参数错误 3:其他错误
            echo SJson::encode($result);
            exit();
        }

    }

    /**
     * @param $post_data
     * @return array
     * @description 添加广告计划信息
     */
    public function AddPlan($post_data)
    {
        $data = [];
        $errorMsg = '';
        unset($post_data['dspid']);
        unset($post_data['token']);
        if(!empty($post_data)){
            if(strlen(trim($post_data['plan_name'])) ==0){
                $errorMsg = '广告计划名称不能为空';
            }
            if(strlen(trim($post_data['plan_name'])) >= 50){
                $errorMsg = '广告计划名称最大长度不能超过50个字符';
            }
            if(!isset($post_data['uid']) || empty($post_data['uid'])){
                $errorMsg = '创建者uid不能为空';
            }
            if(!isset($post_data['contract_type']) || empty($post_data['contract_type'])){
                $errorMsg = '合同类型不能为空';
            }
            if(!isset($post_data['billing_type']) || empty($post_data['billing_type'])){
                $errorMsg = '计费方式不能为空';
            }
            if(!isset($post_data['contract_id']) || empty($post_data['contract_id'])){
                $errorMsg = '合同id不能为空';
            }
            if(!isset($post_data['setting_price']) || empty($post_data['setting_price'])){
                $errorMsg = '广告位置定价不能为空';
            }
            if(empty($post_data['position_type']) || !in_array($post_data['position_type'],array(1,2))){
                $errorMsg = '广告类型参数不能为空或参数不合法';
            }
            if($post_data['position_type'] ==1){
                if(strlen(trim($post_data['tag_identification']))){
                    $errorMsg = '广告位类型不能为空';
                }
            }
            if($post_data['position_type'] ==2){
                if(empty($post_data['source_id'])){
                    $errorMsg = '媒体id不能为空';
                }
                if(empty($post_data['channel_id'])){
                    $errorMsg = '频道id不能为空';
                }
                if(empty($post_data['ad_pos_id'])){
                    $errorMsg = '广告位id不能为空';
                }
            }

            if(empty($post_data['frequency_control']) || !in_array($post_data['frequency_control'],array(-1,0,1,2,3,4))){
                $errorMsg = '频次控制参数不能为空或参数不合法';
            }
            if(empty($post_data['smooth_control']) || !in_array($post_data['smooth_control'],array(1,2))){
                $errorMsg = '投放频次参数不能为空或参数不合法';
            }

            if(strlen($errorMsg) !=0){
                $data['result'] = 2;
                $data['message'] = $errorMsg;
            }else{
                $result = $this->addApiData($post_data,'adp_plan_info');
                $data['result'] = 0;
                $data['message'] = $result;
            }
        }else{
            $data['result'] = 2;
            $data['message'] = '提交的广告计划信息不能为空';
        }
        return $data;
    }

    /**
     * @param $post_data
     * @return array
     * @description 新增广告组和广告信息
     */
    public function AddGroup($post_data){
        $data = [];
        $errorMsg = '';
        unset($post_data['dspid']);
        unset($post_data['token']);
        if(!empty($post_data)){
            //判断参数是否符合要求
            if(strlen(trim($post_data['group_name'])) ==0){
                $errorMsg = '广告组名称不能为空';
            }
            if(strlen(trim($post_data['group_name'])) >= 50){
                $errorMsg = '广告组名称最大长度不能超过50个字符';
            }
            if(empty($post_data['plan_id'])){
                $errorMsg = '广告计划id不能为空';
            }
            if(strlen(trim($post_data['bj_area'])) ==0){
                $errorMsg = '投放区域不能为空';
            }
            if(strlen(trim($post_data['os_type'])) ==0){
                $errorMsg = '终端类型不能为空';
            }
            if(empty($post_data['is_first_page']) || !in_array($post_data['is_first_page'],array(0,1,2))){
                $errorMsg = '屏幕位置参数不能为空或参数不合法';
            }
            if(strlen(trim($post_data['stuff_url'])) ==0){
                $errorMsg = '素材地址不能为空';
            }
            if(strlen(trim($post_data['stuff_name'])) ==0){
                $errorMsg = '素材名称不能为空';
            }
            if(strlen(trim($post_data['stuff_size'])) ==0){
                $errorMsg = '素材尺寸不能为空';
            }
            if(empty($post_data['view_type']) || !in_array($post_data['view_type'],array(1,2,8,16,32,64,128,256,512))){
                $errorMsg = '展示类型参数不能为空或参数不合法';
            }
            if(empty($post_data['view_position']) || !in_array($post_data['view_position'],array(0,1,2,3,4,5,6,7,8))){
                $errorMsg = '展示位置参数不能为空或参数不合法';
            }

            if(strlen($errorMsg) !=0){
                $data['result'] = 2;
                $data['message'] = $errorMsg;
            }else{
                $groupInfo = [];
                $adInfo =    [];
                $plan = $this->getTableList(array('plan_id'=>$post_data['plan_id']),1,1,'plan_id','desc','adp_plan_info');
                $groupInfo['group_name']   =    $post_data['group_name'];
                $groupInfo['plan_id']   =    $post_data['plan_id'];
                $groupInfo['uid']   =    $post_data['uid'];
                $groupInfo['start_date']   =  $plan[0]['start_date'];
                $groupInfo['end_date']   =    $plan[0]['end_date'];
                $groupInfo['is_first_page']      =    $post_data['is_first_page'];
                $groupInfo['area_list']      =   implode(',',$post_data['bj_area']);
                $groupInfo['enable']      =  1; //1为有效，2为无效，3为过期，4为删除，5为冻结
                $groupInfo['ctime']   =   time();
                $groupInfo['mtime']   =   time();
                $groupInfo['media_type']   =    1; //0:固网，1：移动互联网
                $groupInfo['os_type']      =    $post_data['os_type'];
                $groupInfo['exchanges']      =    $post_data['exchanges'];

                $groupId = $this->addApiData($groupInfo,'adp_group_info');

                if($groupId > 0){

                    //添加广告信息
                    $adInfo['media_name']   = 'bmcc';
                    $adInfo['adname']   =    $post_data['stuff_name'];
                    $adInfo['uid']   =    $post_data['uid'];

                    $adInfo['group_id']   =    $groupId;
                    $adInfo['plan_id']   =    $post_data['plan_id'];
                    $adInfo['adType']   =    $post_data['view_type'];
                    $adInfo['width']   =    $post_data['stuff_size_width'];
                    $adInfo['height']   =    $post_data['stuff_size_height'];
                    $adInfo['play_status']   =    3; //1：审核通过，2：审核通过，3：待审核，4：已删除 6 预算暂停
                    $adInfo['media_type']   =    1; //0:固网，1：移动互联网

                    $adInfo['colum1']   =    $post_data['view_position'];
                    $adInfo['verified_or_not']   =    1; //1为待审核，2为审核通过，3为拒绝
                    $adInfo['ctime']   =    time();
                    $adInfo['mtime']   =    time();

                    $adId = $this->addApiData($adInfo,'adp_ad_info');
                    if($adId >0){
                        $stuff_data = array();
                        $stuff = $this->getTableList(array('stuff_id'=>$post_data['stuff_id']),1,1,'stuff_id','desc','adp_stuff_info');
                        $adid_array = explode(',',$stuff[0]['adid']);
                        array_push($adid_array,$post_data['adid']);
                        $stuff_data['adid'] = implode(',',$adid_array);
                        $stuffId = parent::update('adp_stuff_info', $stuff_data, array('stuff_id'=>$post_data['stuff_id']));
                        if($stuffId >0){
                            $data['result'] = 0;
                            $data['message'] = $stuffId;
                        }else{
                            $data['result'] = 2;
                            $data['message'] = '素材关联更新失败';
                        }

                    }else{
                        $count = parent::delete('adp_group_info', array('group_id'=>$groupId));
                        unset($count);
                        $data['result'] = 2;
                        $data['message'] = '新增广告组和广告信息失败';
                    }
                }
            }

        }else{
            $data['result'] = 2;
            $data['message'] = '提交的广告组和广告信息不能为空';
        }
        return $data;

    }

    /**
     * @param $post_data
     * @return array
     * @description 新增素材信息
     */
    public function AddStuff($post_data)
    {
        $data = [];
        $errorMsg = '';
        unset($post_data['dspid']);
        unset($post_data['token']);
        if(!empty($post_data)){
            if(empty($post_data['stuff_type']) || !in_array($post_data['stuff_type'],array(0,17))){
                $errorMsg = '创意类型参数不能为空或参数不合法';
            }
            if(empty($post_data['view_type']) || !in_array($post_data['view_type'],array(1001,1002,1004))){
                $errorMsg = '广告类型参数不能为空或参数不合法';
            }
            if(strlen(trim($post_data['adname'])) ==0){
                $errorMsg = '素材名称不能为空';
            }
            if(strlen(trim($post_data['stuff_size'])) ==0){
                $errorMsg = '素材尺寸不能为空';
            }
            if($post_data['view_type'] ==1002 && strlen(trim($post_data['logo_size'])) ==0){
                $errorMsg = 'LOGO素材尺寸不能为空';
            }
            if($post_data['view_type'] ==1002 && strlen(trim($post_data['icon_size'])) ==0){
                $errorMsg = 'ICON素材尺寸不能为空';
            }
            if(strlen(trim($post_data['title'])) ==0){
                $errorMsg = '标题不能为空';
            }
            if(empty($post_data['ad_action']) || !in_array($post_data['ad_action'],array(1,2,3,5))){
                $errorMsg = '广告交互类型参数不能为空或参数不合法';
            }
            if(strlen($errorMsg) !=0){
                $data['result'] = 2;
                $data['message'] = $errorMsg;
            }else{
                $stuffInfo = [];
                $stuffInfo['name'] = $post_data['adname'];
                $stuffInfo['uid'] = $post_data['uid'];
                $stuffInfo['width'] = ''; //待定
                $stuffInfo['height'] = '';
                $stuffInfo['type'] = 1; //1为图片，2为flash，3为文字
                $stuffInfo['title'] = $post_data['title'];
                $stuffInfo['ad_action'] = $post_data['ad_action'];
                $stuffInfo['description'] = $post_data['desc'];
                $stuffInfo['addr'] = 'url';  //素材上传地址
                $stuffInfo['landing_page'] = $post_data['landing_page'];  //目标地址
                $stuffInfo['enabled'] = 1;  //
                $stuffInfo['ctime'] = time();
                $stuffInfo['mtime'] = time();
                $stuffInfo['media_name'] = 'bmcc';
                $stuffInfo['verified_or_not'] = 1; //1为待审核，2为审核通过，3为拒绝
                $stuffInfo['show_js'] = $post_data['show_js'];  //展示监控
                $stuffInfo['click_js'] = $post_data['click_js'];  //点击监控


            }


        }else{
            $data['result'] = 2;
            $data['message'] = '提交的素材信息不能为空';
        }
        return $data;


    }


    /**
     * @return array
     * @description 获取所有行业信息
     */
    public function getIndustryInfo()
    {
        $table = 'adp_industry_info';
        $sql = "SELECT * FROM `$table`";
        $result = parent::fetch_all($sql);
        $data = [];
        if($result){
            $data['result'] = 0;
            $data['message'] = $result;
        }else{
            $data['result'] = 3;
            $data['message'] = '数据查询请求错误';
        }
        return $data;

    }

    /**
     * @param $page
     * @param $limit
     * @param $status
     * @return array
     * @description 获取素材信息
     */
    public function getStuffInfo($page,$limit,$status)
    {
        $stuff_table = 'adp_stuff_library';
        $condition = [];
        if($status > 0){
            $condition['verified_or_not'] = $status; //1为待审核，2为审核通过，3为拒绝通过
        }
        $stuff_list = $this->getTableList($condition,$page,$limit,'stuff_id','desc',$stuff_table);

        $data = [];
        if($stuff_list){
            $data['result'] = 0;
            $data['message'] = $stuff_list;
        }else{
            $data['result'] = 3;
            $data['message'] = '数据查询请求错误';
        }
        return $data;
    }

    /**
     * @param $page
     * @param $limit
     * @param $status
     * @return array
     * @description 获取广告计划列表
     */
    public function getPlanInfo($page,$limit,$status)
    {
        $table = 'adp_plan_info';
        $condition = [];
        if($status > 0){
            $condition['verified_or_not'] = $status; //1为待审核，2为审核通过，3为拒绝通过
        }
        $result = $this->getTableList($condition,$page,$limit,'plan_id','desc',$table);
        $data = [];
        if($result){
            $data['result'] = 0;
            $data['message'] = $result;
        }else{
            $data['result'] = 3;
            $data['message'] = '数据查询请求错误';
        }
        return $data;
    }

    /**
     * @param $page
     * @param $limit
     * @param $status
     * @return array
     * @description 获取媒体信息列表
     */
    public function getMediaInfo($page,$limit)
    {
        $table = 'rmc_bj_media';
        $condition = [];
        $condition['media_status'] = 1;  //媒体状态 0关 1开
        $result = $this->getTableList($condition,$page,$limit,'id','desc',$table);
        $data = [];
        if($result){
            $data['result'] = 0;
            $data['message'] = $result;
        }else{
            $data['result'] = 3;
            $data['message'] = '数据查询请求错误';
        }
        return $data;
    }

    /**
     * @param $page
     * @param $limit
     * @param $status
     * @return array
     * @description 获取频道信息列表
     */
    public function getChannelInfo($page,$limit)
    {
        $table = 'ssp_bj_channel';
        $condition = [];
        $condition['channel_status'] = 1;  //媒体状态 0关 1开
        $result = $this->getTableList($condition,$page,$limit,'media_id','desc',$table);
        $data = [];
        if($result){
            $data['result'] = 0;
            $data['message'] = $result;
        }else{
            $data['result'] = 3;
            $data['message'] = '数据查询请求错误';
        }
        return $data;
    }

    /**
     * @param $page
     * @param $limit
     * @param $status
     * @return array
     * @description 获取广告位信息列表
     */
    public function getAdPositionInfo($page,$limit)
    {
        $table = 'ssp_position';
        $condition = [];
        $condition['plan_id'] = 0;  //独占广告计划id，如果非独占置0
        $result = $this->getTableList($condition,$page,$limit,'id','desc',$table);
        $data = [];
        if($result){
            $data['result'] = 0;
            $data['message'] = $result;
        }else{
            $data['result'] = 3;
            $data['message'] = '数据查询请求错误';
        }
        return $data;
    }

    /**
     * @param $page
     * @param $limit
     * @param $status
     * @return array
     * @description 获取广告分类信息列表
     */
    public function getMediaTagInfo($page,$limit)
    {
        $table = 'adp_po_tag';
        $condition = [];
        $condition['plan_id'] = 0;  //独占广告计划id，如果非独占置0
        $result = $this->getTableList($condition,$page,$limit,'id','desc',$table);
        $data = [];
        if($result){
            $data['result'] = 0;
            $data['message'] = $result;
        }else{
            $data['result'] = 3;
            $data['message'] = '数据查询请求错误';
        }
        return $data;
    }

    /**
     * @param $page
     * @param $limit
     * @param $status
     * @return array
     * @description 获取地区信息列表
     */
    public function getAreaInfo()
    {
        $result = [];
        /*地区*/
        $result['area_region'] = rmc_db::listAreaByRegion();
        /*一二线城市*/
        $result['area_level'] =  rmc_db::listAreaByLevel();
        $data = [];
        if($result){
            $data['result'] = 0;
            $data['message'] = $result;
        }else{
            $data['result'] = 3;
            $data['message'] = '数据查询请求错误';
        }
        return $data;
    }

    /**
     * @param int $condition
     * @param string $start
     * @param string $limit
     * @param string $order
     * @param string $orderType
     * @param string $tableName
     * @return mixed
     * @description 获取对应表的所有信息
     */
    public function getTableList($condition=0, $start='', $limit='', $order='', $orderType="ASC",$tableName=''){
        $where = " WHERE 1 ";
        if($condition==0 || empty($condition)){
            unset($where);
            unset($condition);
        }
        if(is_array($condition) && count($condition)>0){
            $condition = parent::implode($condition, "AND");
            $where .= " AND $condition ";
        }else{
            $where .= $condition;
        }
        if(strlen($start)>0 && strlen($limit)>0 && is_numeric($start) && is_numeric($limit)){
            if($start ==1){
                $limit = parent::limit($start,$limit);
            }else{
                $limit = parent::limit(($start-1)*$limit,$limit);
            }

        }else{
            $limit = "";
        }

        if(strlen($order)>0){
            if($orderType == 1 || strtolower($orderType) === 'desc'){
                $orderType = 'DESC';
            }else{
                $orderType = 'ASC';
            }
            $order = parent::order($order,$orderType);
            $order = " ORDER BY $order ";
        }else{
            $order = "";
        }
        if(strlen($tableName) ==0){
            $table = $this->table;
        }else{
            $table = $tableName;
        }

        $sql = "SELECT * FROM `$table` $where $order $limit ";
        $result = parent::fetch_all($sql);
        return($result);
    }


    /**
     * @param $data
     * @param string $tableName
     * @return int
     * @description 添加不同表中的数据
     */
    public function addApiData($data,$tableName =''){
        if(strlen($tableName) ==0){
            $table = $this->table;
        }else{
            $table = $tableName;
        }
        $id = parent::insert($table, $data, true, false);
        return $id;
    }



}
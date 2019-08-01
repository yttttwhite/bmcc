<?php
class model_ReportAd extends discuz_database{
    public $table = "ad_info";
    public function __construct(){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php");
        parent::init("db_driver_mysql", $config['db']);
        $this->table = 'ad_info';
    }
    
    public function getDataAll($condition=0, $start="", $limit="", $order="", $orderType="ASC", $sql=""){
        $where = "WHERE 1 ";
        if(is_array($condition) && count($condition)>0)
        {
            $condition = parent::implode($condition,"AND");
            $where .= " AND $condition ";
        }
        
        if(strlen($sql)>0)
        {
            $where .= " AND ".$sql;
        }
        $where .= " AND a.adType != 16 and a.play_status=1 ";
        
        if(strlen($start)>0 && strlen($limit)>0 && is_numeric($start) && is_numeric($limit)){
            $limit = parent::limit($start,$limit);
        }else{
            $limit = "";
        }
        
        if(strlen($order)>0)
        {
            if($orderType == 1 || strtolower($orderType) === 'desc')
            {
                $orderType = 'DESC';
            }else{
                $orderType = 'ASC';
            }
            $order = parent::order($order,$orderType);
            $order = " ORDER BY a.$order ";
        }else{
            $order = "";
        }
    
        $table = parent::table($this->table);
        $sqljoin = " inner join adp_stuff_info s on s.adid=a.adid and ((s.type<=3 and s.`landing_page`<>'' and s.`landing_page` is not null and landing_page_reachable=1) or s.type>3) ";
        $sqljoin .= " inner join adp_group_info g on a.group_id=g.group_id and g.enable = 1 ";
        $sqljoin .= " inner join adp_plan_info p on a.plan_id=p.plan_id and p.verified_or_not=2 and p.enable=1 ";
        $sqljoin .= " inner join adp_user_info u on a.uid = u.uid and u.account >= 0 and u.account_status = 1";
        
        $sqlfield = "p.smooth_control,p.all_day_or_not,p.intervals,p.time_interval,p.day_num,p.show_num,p.verified_or_not,p.frequency_control,p.budget,";
        $sqlfield .= "u.user_name,u.account,g.include_host,g.exclude_host,p.billing_type,p.day_cpm,p.day_cpc,g.area_list,g.area_label,s.type,s.width,s.height,s.addr,s.text,";
        $sqlfield .= "case p.verified_or_not when '2' then '审核通过' when '3' then '审核不通过' else '未审核' end as isverified,";
        $sqlfield .= "case p.enable when '1' then '有效' when '2' then '无效' when '3' then '过期' when '4' then '删除' when '5' then '冻结' when '6' then '预算暂停' end as strenable,";
        $sqlfield .= "case p.smooth_control when '1' then '匀速' when '2' then '标准' end as strsmooth,";
        $sqlfield .= "case p.all_day_or_not when '1' then '全天' when '0' then '分时段' end as strallday,";
        $sqlfield .= "case a.adType when '1' then '嵌入式' when '2' then '浮窗' when '4' then '背投' when '8' then '重定向' when '16' then '重定向DPC' when '32' then '通栏' when '64' then '无线APP' when '128' then '无线浮标' when '256' then '插页' when '512' then '对联' end as stradtype,";
        $sqlfield .= "case p.frequency_control when '0' then '根据IP' when '1' then '根据COOKIE' when '2' then '根据ADSL' else '不限' end as strfrequency,";
        $sqlfield .= "case s.type when '1' then '图片' when '2' then 'Flash' when '5' then '重定向' when '6' then '视频' when '7' then 'iFrame' when '8' then 'JS' when '9' then 'HTML' else '' end as strstufftype,";
        $sqlfield .= "case s.verified_or_not when '2' then '审核通过' when '3' then '审核不通过' else '未审核' end as stuffisverified,";
        $sqlfield .= "case g.enable when '1' then '有效' when '2' then '无效' when '3' then '过期' when '4' then '删除' when '5' then '冻结' end as strgroupenable,";
        $sqlfield .= "case g.mobile when '0' then '不限PC和mobile' when '1' then '仅投放PC' when '2' then '仅投放mobile' end as strmobile,";
        $sqlfield .= "case g.usertype when '0' then '不限ADSL和专线' when '1' then '仅投放ADSL用户' when '2' then '仅投放专线用户' end as strusertype,";
        $sqlfield .= "case p.release_type when '10' then '品牌类' when '20' then '普通类' when '30' then '财经类' when '40' then '游戏类' when '100' then '最低' when '101' then '内部支撑' end as strreleasetype";
         
        $sql = " SELECT a.adid,a.adname,a.group_id,g.group_name,a.plan_id,p.plan_name,a.uid,p.start_date,p.end_date,$sqlfield FROM `$table` a $sqljoin $where $order $limit";
        //var_dump($sql);exit;
        unset($result);
        $result = parent::fetch_all($sql);
        
        //结果集处理
        for($i=0;$i<count($result);$i++)
        {
            //开始日期处理
            $strstartdate = ($result[$i]['start_date']>0)?date('Y-m-d',$result[$i]['start_date']):"";
            $result[$i]['startdate'] = $strstartdate;
            
            //结束日期处理
            $strenddate = ($result[$i]['end_date']>0)?date('Y-m-d',$result[$i]['end_date']):"";
            $result[$i]['enddate'] = $strenddate;
            
            //每日预算处理
            if($result[$i]['budget'] == '-1')
            {
                $strbudgettotal = "不限预算";
            }else{
                $strbudgettotal = intval($result[$i]['budget']);
            }
            $result[$i]['strbudgettotal'] = $strbudgettotal;
            
            //投放区域处理
            $result[$i]['strarealabel'] = strlen($result[$i]['area_label'])>0?$result[$i]['area_label']:"全国";
            
            
            //素材处理
            $strstuff = "";
            if(intval($result[$i]['type'])==1)
            {//图片
                $strstuff = "<img src='".$result[$i]['addr']."' width='100'>";
            }elseif(intval($result[$i]['type'])>2){
                //其他素材
                $strstuff = "<textarea rows='3' cols='50'>".$result[$i]['text']."</textarea>";
            }
            $result[$i]['strstuff'] = $strstuff; 
        }
        return($result);
    }
    
    //获取数据
    public function getDataCount($condition=0, $order="", $orderType="ASC", $sql=""){
        $where = "WHERE 1 ";
        if(is_array($condition) && count($condition)>0)
        {
            $condition = parent::implode($condition,"AND");
            $where .= " AND $condition ";
        }
    
        if(strlen($sql)>0)
        {
            $where .= " AND ".$sql;
        }
        $where .= " AND a.adType != 16 and a.play_status=1";
    
        $limit = "";
        
        if(strlen($order)>0)
        {
            if($orderType == 1 || strtolower($orderType) === 'desc')
            {
                $orderType = 'DESC';
            }else{
                $orderType = 'ASC';
            }
            $order = parent::order($order,$orderType);
            $order = " ORDER BY a.$order ";
        }else{
            $order = "";
        }
    
        $table = parent::table($this->table);
        //$sqljoin = " inner join (adp_group_info g,adp_plan_info p, adp_stuff_info s, adp_user_info u) on s.adid=a.adid ";
        $sqljoin = " inner join adp_stuff_info s on s.adid=a.adid and ((s.type<=3 and s.`landing_page`<>'' and s.`landing_page` is not null and landing_page_reachable=1) or s.type>3) ";
        $sqljoin .= " inner join adp_group_info g on a.group_id=g.group_id and g.enable = 1 ";
        $sqljoin .= " inner join adp_plan_info p on a.plan_id=p.plan_id and p.verified_or_not=2 and p.enable=1 ";
        $sqljoin .= " inner join adp_user_info u on a.uid = u.uid and u.account >= 0 and u.account_status = 1";
         
        $sql = "SELECT count(a.adid) as num FROM `$table` a $sqljoin $where $order ";
        //var_dump($sql);exit;
        $result = parent::fetch_all($sql);
        return($result[0]['num']);
    }
    
    //获取广告的详细信息
    public function getAdDetailShow($adid)
    {
        if(intval($adid)>0)
        {
            //获取广告计划详情
            $whereplan = " WHERE a.adid=".intval($adid)." AND a.verified_or_not=2 AND a.adType != 16 and a.play_status=1 ";
            $orderplan = parent::order("adid","ASC");
            $orderplan = " ORDER BY a.$orderplan ";
    
            $joinplan = " inner join adp_stuff_info s on s.adid=a.adid and ((s.type<=3 and s.`landing_page`<>'' and s.`landing_page` is not null and landing_page_reachable=1) or s.type>3) ";
            $joinplan .= " inner join adp_group_info g on a.group_id=g.group_id and g.enable = 1 ";
            $joinplan .= " inner join adp_plan_info p on a.plan_id=p.plan_id and p.verified_or_not=2 and p.enable=1 ";
            $joinplan .= " inner join adp_user_info u on a.uid = u.uid and u.account >= 0 and u.account_status = 1";
    
            //$joinplan = " left join adp_plan_info b on a.plan_id=b.plan_id left join adp_group_info c on a.group_id=c.group_id";
            //$joinplan .= " left join adp_stuff_info d on a.adid=d.adid left join adp_user_info e on a.uid=e.uid";
    
            $table = parent::table($this->table);
            $sqlfield = "p.smooth_control,p.all_day_or_not,p.intervals,p.time_interval,p.day_num,p.show_num,p.verified_or_not,p.frequency_control,u.user_name,u.account,g.include_host,g.exclude_host,";
            $sqlfield .= "case p.verified_or_not when '2' then '审核通过' when '3' then '审核不通过' else '未审核' end as isverified,";
            $sqlfield .= "case p.enable when '1' then '有效' when '2' then '无效' when '3' then '过期' when '4' then '删除' when '5' then '冻结' when '6' then '预算暂停' end as strenable,";
            $sqlfield .= "case p.smooth_control when '1' then '匀速' when '2' then '标准' end as strsmooth,";
            $sqlfield .= "case p.all_day_or_not when '1' then '全天' when '0' then '分时段' end as strallday,";
            $sqlfield .= "case a.adType when '1' then '嵌入式' when '2' then '浮窗' when '4' then '背投' when '8' then '重定向' when '16' then '重定向DPC' when '32' then '通栏' when '64' then '无线APP' when '128' then '无线浮标' when '256' then '插页' when '512' then '对联' end as stradtype,";
            $sqlfield .= "case p.frequency_control when '0' then '根据IP' when '1' then '根据COOKIE' when '2' then '根据ADSL' else '不限' end as strfrequency,";
            $sqlfield .= "case s.type when '1' then '图片素材' when '2' then 'Flash素材' when '5' then '重定向' when '6' then '视频广告' when '7' then 'iFrame广告' when '8' then 'JS广告' when '9' then 'HTML广告' else '' end as strstufftype,";
            $sqlfield .= "case s.verified_or_not when '2' then '审核通过' when '3' then '审核不通过' else '未审核' end as stuffisverified,";
            $sqlfield .= "case g.enable when '1' then '有效' when '2' then '无效' when '3' then '过期' when '4' then '删除' when '5' then '冻结' end as strgroupenable,";
            $sqlfield .= "case u.account_status when '1' then '正常' when '2' then '冻结' end as struserstatus";
            $sql = "SELECT a.adid,a.adname,a.group_id,g.group_name,a.plan_id,p.plan_name,a.uid,p.start_date,p.end_date, $sqlfield FROM `$table` a $joinplan $whereplan $orderplan";
            //var_dump($sql);exit;
            $resultdetail = parent::fetch_all($sql);
            unset($result);
            $result = (object)$resultdetail[0];
    
            //时间处理
            $pushtime = $this->getintervaltime($result->intervals);
            $result->strintervals = $pushtime;
    
            //域名白名单处理
            $includehost = str_replace(",", "<br />", $result->include_host);
            $result->includehost = $includehost;
    
            //域名黑名单处理
            $excludehost = str_replace(",", "<br />", $result->exclude_host);
            $result->excludehost = $excludehost;
    
            //开始日期处理
            $strstartdate = ($result->start_date>0)?date('Y-m-d',$result->start_date):"";
            $result->startdate = $strstartdate;
    
            //结束日期处理
            $strenddate = ($result->end_date>0)?date('Y-m-d',$result->end_date):"";
            $result->enddate = $strenddate;
    
            /*获取推送广告量*/
            $curdate = date("Ymd");
            $wheread = " WHERE adid=".intval($adid)." AND date like '".$curdate."%' ";
    
            //选出广告量
            $tablesel = parent::table("pushinfo");
            $sql = "SELECT adid,sum(pv) as allnum FROM `$tablesel` $wheread order by date desc";
            $resultad1 = parent::fetch_all($sql);
            $selnum = 0;    //选出广告数
            if(!is_null($resultad1['allnum']))
            {
                $selnum = intval($resultad1['allnum']);
            }
            $result->selnum = $selnum;
    
            //推送量
            $tablepush = parent::table("jsinfo");
            $sql = "SELECT adid,sum(pv) as numn FROM `$tablepush` $wheread order by id desc";
            $tablepush = parent::fetch_all($sql);
            $pushnum = 0;    //选出广告数
            if(!is_null($tablepush['numn']))
            {
                $pushnum = intval($tablepush['numn']);
            }
            $result->pushnum = $pushnum;
    
            return($result);
        }else{
            $result = (object)array();
        }
    }
    
    //获取广告的详细信息
    public function getAdDetail($adid,$planid)
    {
        if(intval($adid)>0 && intval($planid)>0)
        {
            //获取广告计划详情
            $whereplan = " WHERE a.adid=".intval($adid)." AND a.verified_or_not=2 AND a.adType != 16 and a.play_status=1 ";
            $orderplan = parent::order("adid","ASC");
            $orderplan = " ORDER BY a.$orderplan ";
            
            $joinplan = " inner join adp_stuff_info s on s.adid=a.adid and ((s.type<=3 and s.`landing_page`<>'' and s.`landing_page` is not null and landing_page_reachable=1) or s.type>3) ";
            $joinplan .= " inner join adp_group_info g on a.group_id=g.group_id and g.enable = 1 ";
            $joinplan .= " inner join adp_plan_info p on a.plan_id=p.plan_id and p.verified_or_not=2 and p.enable=1 ";
            $joinplan .= " inner join adp_user_info u on a.uid = u.uid and u.account >= 0 and u.account_status = 1";
            
            //$joinplan = " left join adp_plan_info b on a.plan_id=b.plan_id left join adp_group_info c on a.group_id=c.group_id";
            //$joinplan .= " left join adp_stuff_info d on a.adid=d.adid left join adp_user_info e on a.uid=e.uid";
            
            $table = parent::table($this->table);
            $sqlfield = "p.smooth_control,p.all_day_or_not,p.intervals,p.time_interval,p.day_num,p.show_num,p.verified_or_not,p.frequency_control,u.user_name,u.account,g.include_host,g.exclude_host,";
            $sqlfield .= "case p.verified_or_not when '2' then '审核通过' when '3' then '审核不通过' else '未审核' end as isverified,";
            $sqlfield .= "case p.enable when '1' then '有效' when '2' then '无效' when '3' then '过期' when '4' then '删除' when '5' then '冻结' when '6' then '预算暂停' end as strenable,";
            $sqlfield .= "case p.smooth_control when '1' then '匀速' when '2' then '标准' end as strsmooth,";
            $sqlfield .= "case p.all_day_or_not when '1' then '全天' when '0' then '分时段' end as strallday,";
            $sqlfield .= "case a.adType when '1' then '嵌入式' when '2' then '浮窗' when '4' then '背投' when '8' then '重定向' when '16' then '重定向DPC' when '32' then '通栏' when '64' then '无线APP' when '128' then '无线浮标' when '256' then '插页' when '512' then '对联' end as stradtype,";
            $sqlfield .= "case p.frequency_control when '0' then '根据IP' when '1' then '根据COOKIE' when '2' then '根据ADSL' else '不限' end as strfrequency,";
            $sqlfield .= "case s.type when '1' then '图片素材' when '2' then 'Flash素材' when '5' then '重定向' when '6' then '视频广告' when '7' then 'iFrame广告' when '8' then 'JS广告' when '9' then 'HTML广告' else '' end as strstufftype,";
            $sqlfield .= "case s.verified_or_not when '2' then '审核通过' when '3' then '审核不通过' else '未审核' end as stuffisverified,";
            $sqlfield .= "case g.enable when '1' then '有效' when '2' then '无效' when '3' then '过期' when '4' then '删除' when '5' then '冻结' end as strgroupenable,";
            $sqlfield .= "case u.account_status when '1' then '正常' when '2' then '冻结' end as struserstatus";
            $sql = "SELECT a.adid,a.adname,a.group_id,g.group_name,a.plan_id,p.plan_name,a.uid,p.start_date,p.end_date, $sqlfield FROM `$table` a $joinplan $whereplan $orderplan";
            //var_dump($sql);exit;
            $resultdetail = parent::fetch_all($sql);
            unset($result);
            $result = (object)$resultdetail[0];
            
            //时间处理
            $pushtime = $this->getintervaltime($result->intervals);
            $result->strintervals = $pushtime;
            
            //域名白名单处理
            $includehost = str_replace(",", "<br />", $result->include_host);
            $result->includehost = $includehost;
            
            //域名黑名单处理
            $excludehost = str_replace(",", "<br />", $result->exclude_host);
            $result->excludehost = $excludehost;
            
            //开始日期处理
            $strstartdate = ($result->start_date>0)?date('Y-m-d',$result->start_date):"";
            $result->startdate = $strstartdate;
            
            //结束日期处理
            $strenddate = ($result->end_date>0)?date('Y-m-d',$result->end_date):"";
            $result->enddate = $strenddate;
            
            /*获取推送广告量*/
            $curdate = date("Ymd");
            $wheread = " WHERE adid=".intval($adid)." AND date like '".$curdate."%' ";
            
            //选出广告量
            $tablesel = parent::table("pushinfo");
            $sql = "SELECT adid,sum(pv) as allnum FROM `$tablesel` $wheread order by date desc";
            $resultad1 = parent::fetch_all($sql);
            $selnum = 0;    //选出广告数
            if(!is_null($resultad1['allnum']))
            {
                $selnum = intval($resultad1['allnum']);
            }
            $result->selnum = $selnum;
            
            //推送量
            $tablepush = parent::table("jsinfo");
            $sql = "SELECT adid,sum(pv) as numn FROM `$tablepush` $wheread order by id desc";
            $tablepush = parent::fetch_all($sql);
            $pushnum = 0;    //选出广告数
            if(!is_null($tablepush['numn']))
            {
                $pushnum = intval($tablepush['numn']);
            }
            $result->pushnum = $pushnum;
            
            return($result);
        }else{
            $result = (object)array();
        }
    }
    
    //获取推送时间
    public function getintervaltime($interals)
    {
        //投放时间获取
        $arrInterval = explode(";",$interals);
        $strinterval = "";
        $arrweek = array("一","二","三","四","五","六","日");
        foreach($arrInterval as $value)
        {
            $arrItemValue = explode(":", substr($value,0,strlen($value)-1));
            $strinterval .= "星期".$arrweek[$arrItemValue[0]-1].":".str_replace(",","点,",$arrItemValue[1])."<br>";  
        }
        return $strinterval;
    }
}

?>
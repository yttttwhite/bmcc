<?php
/***
 * 广告位排期相关功能
 */
 class media_schedule extends STpl
{

    public function __construct($inPath)
    {
        /*
         * $exclude_arr = array("getwebsites","getpositions","getprice");
         * if(!user_api::auth("media")&& !in_array($inPath[2],$exclude_arr)){
         * $this->success("没有权限",'/user',3);
         * exit();
         * }
         */
    }

    /**
     * 广告位标签列表
     *
     * @param unknown $inPath            
     */
     public function pageEntry($inPath)
    {    
        if(isset($_GET['date'])){
            $start_date = $_GET['date'];
        } else {
            $start_date = date('Y-m-d',time());
        }
        $time = strtotime($start_date);
        $positionModel = new model_sspPosition();
        $all_data = $positionModel->getData();
        foreach($all_data as $em){
            if($em['plan_id'] >0){   //plan_id大于0表示广告位被占用在投
                $data[] = $em;
            }
        }
        if ($data) {
            $schedule = $data;
            //筛选数据
        } else {
            $schedule = array();
        }
        foreach ($schedule as $k => $v) {
            $mediaName = $this->getMeidaName($v['media_id']);
            $schedule[$k]['media_name'] = $mediaName;
            $channelName = $this->getChannelName($v['channel_id']);
            $schedule[$k]['channel_name'] = $channelName;
            $countData = $this->getWeekData($v['tag_identification'], $time);
            $count = $countData['count'];
            $cpm = $countData['cpm'];
            $cpt = $countData['cpt'];
            $n = 0;
            foreach($count as $k1=>$v1){
                 $schedule[$k][$n] =array("cpt"=>$cpt[$k1],"cpm"=>$cpm[$k1],"count"=>$count[$k1]);
                 $n++;
            }
            
        }
        // 根据key筛选
        foreach ($schedule as $key => $tempSchedule) {
            if (isset($_GET['media_name']) && strlen($_GET['media_name']) > 0 && stripos($tempSchedule['media_name'], $_GET['media_name']) === false) {
                unset($schedule[$key]);
            }
        }
        // 根据key筛选
        foreach ($schedule as $key => $tempSchedule) {
            if (isset($_GET['channel_name']) && strlen($_GET['channel_name']) > 0 && stripos($tempSchedule['channel_name'], $_GET['channel_name']) === false) {
                unset($schedule[$key]);
            }
        }
        foreach ($schedule as $key => $tempSchedule) {
            if (isset($_GET['position_name']) && strlen($_GET['position_name']) > 0 && stripos($tempSchedule['position_name'], $_GET['position_name']) === false) {
                unset($schedule[$key]);
            }
        }
        // 根据key筛选
        foreach ($schedule as $key => $tempSchedule) {
            if (isset($_GET['position_key']) && strlen($_GET['position_key"']) > 0 && stripos($tempSchedule['position_name'], $_GET['position_name']) === false) {
                unset($schedule[$key]);
            }
        }
        // 根据key筛选
        foreach ($schedule as $key => $tempSchedule) {
            if (isset($_GET['tag']) && strlen($_GET['tag']) > 0 && stripos($_GET['tag'], $tempSchedule['tag_identification']) === false) {
                unset($schedule[$key]);
            }
        }
        // 分页处理
        $total = count($schedule);
        if ($_GET['pageNum']) {
            $pageNum = $_GET['pageNum'];
        } else {
            $pageNum = 1;
        }
        $pageSize = 20;
        if ($pageNum * $pageSize - 1 <= $total) {
            $start = ($pageNum - 1) * $pageSize;
            $end = $pageNum * $pageSize - 1;
        } else {
            $start = ($pageNum - 1) * $pageSize;
            $end = $total - 1;
        }
        $schedule = array_slice($schedule, $start, $pageSize);
        $totalPage = ceil($total / $pageSize);
        $dateWeek = $this->getOneweek($time);
        $week = $dateWeek['week'];
        $date = $dateWeek['date'];

        $tags = $this->getTag();
        $this->assign('tags', $tags);
        $this->assign("week", $week);
        $this->assign('date',$date);
        $this->assign('start_date',$start_date);
        $this->assign("totalPage", $totalPage);
        $this->assign("pageNum", $pageNum);
        $this->assign("schedule", $schedule);
        return $this->render("v2/meiti/schedule.html");
   
    }

    public function pageGet($inPath)
    {
        $slot_id = $inPath[3];
        $slot = media_db::getSlotCache($slot_id);
    }

    public function pageNav($inPath)
    {
        if (! empty($inPath[3])) {
            $this->assign("nav", $inPath[3]);
        }
        if (! empty($inPath[4])) {
            $this->assign("nav_sub", $inPath[4]);
        }
        return $this->render("v2/meiti/nav.tpl");
    }

    /**
     * *
     * 获取媒体的名称
     */
    public function getMeidaName($mediaId)
    {
        $media_thrift = new thrift_admedia_main();
        $media = $media_thrift->getMediaById($mediaId);
        $mediaName = '';
        if ($media) {
            $mediaName = $media->media_name;
        }
        return $mediaName;
    }

    /**
     * *
     * 获取频道名称
     */
    public function getChannelName($channelId)
    {
        $media_thrift = new thrift_admedia_main();
        $media = $media_thrift->getChannelById($channelId);
        $channelName = '';
        if ($media) {
            $channelName = $media->channel_name;
        }
        return $channelName;
    }

    /**
     * *
     * 从当前日期往后数一周时间
     */
    public function getOneweek($time)
    {    
        $timeList = array(
            $time,
            $time+3600*24,
            $time+2*3600*24,
            $time+3*3600*24,
            $time+4*3600*24,
            $time+5*3600*24,
            $time+6*3600*24
        );
        foreach ($timeList as $v) {
            $time = $v;
            $weekarray = array(
                "日",
                "一",
                "二",
                "三",
                "四",
                "五",
                "六"
            );
            $week[] = "星期" . $weekarray[date("w", $time)];
            $date[] = date('Y-m-d', $time);
        }
        $dateweek = array(
            'week' => $week,
            'date' => $date
        );
        return $dateweek;
    }

    /**
     * 获取所有标签用于页面渲染
     */
    public function getTag()
    {
        $tagModel = new model_poTag();
        $data = $tagModel->getData();
        $tags = array();
        if ($data) {
            $tags = $data;
        }
        
        return $tags;
    }

    /**
     * *
     * 获取一个星期的广告计划排期统计结果
     */
    public function getWeekData($tagId=0, $time)
    {
        $planModel = new model_planInfo();
        $condition = array();
        $condition['tag_identification'] = $tagId;
        $plans = $planModel->getData($condition,0,-1);
        $weekdate = $this->getOneweek($time);
        $date = $weekdate['date'];
        $count = array();
        $cpm = array();
        $cpt = array();
         if (!empty($plans)) {
            foreach ($date as $k => $v) {
                foreach ($plans as $k1 => $v1) {
                    if (date('Y-m-d', $v1['ctime']) == $v) {
                        if (isset($count[$v])) {
                            $count[$v] += 1;
                            if($v1['total_cpm']>0){
                                $cpm[$v] +=$v1['total_cpm'];
                            }
                            if($v1['total_cpt']>0){
                                $cpt[$v] ="有";
                            }
                            
                        } else {
                            $count[$v] = 1;
                            $cpm[$v] = 1;
                            $cpt[$v] = "有";
                            
                        }
                    } else {
                        $count[$v] = 0;
                        $cpm[$v] = 0;
                        $cpt[$v] = "无";
                    }
                }
            }
        } else {
            foreach ($date  as $v3){
                $count[$v3] = 0;
                $cpm[$v3] = 0;
                $cpt[$v3] = "无";
            }
        }
        return  array('count'=>$count,'cpm'=>$cpm,'cpt'=>$cpt);
    }
    
}

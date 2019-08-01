<?php
header('Access-Control-Allow-Origin: *');
header('Content-type:text/json');
class api_ad extends STpl{

    public $planInfoModel,$userInfoModel;

	public function __construct($inPath){
        $config = SConfig::getConfigArray(ROOT_CONFIG."/config.php" , 'version');
        $planInfoModel = new model_planInfo();
        $planInfoModel->authorize($_REQUEST,$config['api']);
	}

    /**
     * @param $inPath
     * @return string
     * @description 新增广告计划信息
     */
    public function pageAddPlan($inPath){
        $post_data      = $_POST;
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->AddPlan($post_data);
        return SJson::encode($res);
    }
    /**
     * @param $inPath
     * @return string
     * @description 新增广告组及广告信息
     */
    public function pageAddGroup($inPath){
        $post_data      = $_POST;
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->AddGroup($post_data);
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 新增素材
     */
    public function pageAddStuff($inPath){
        $post_data      = $_POST;
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->AddStuff($post_data);
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 获取行业信息
     */
    public function pagegetIndustryList($inPath){
        $planInfoModel = new model_planInfo();
        $res = $planInfoModel->getIndustryInfo();
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 获取素材列表信息
     */
    public function pagegetStuffList($inPath)
    {
        $page           = $_GET['page'];
        $page_count     = $_GET['page_count'];
        $status         = $_GET['status'];
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->getStuffInfo($page,$page_count,$status);
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 获取广告计划列表信息
     */
    public function pagegetPlanList($inPath)
    {
        $page           = $_GET['page'];
        $page_count     = $_GET['page_count'];
        $status         = $_GET['status'];
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->getPlanInfo($page,$page_count,$status);
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 获取媒体信息列表
     */
    public function pagegetMediaList($inPath)
    {
        $page           = $_GET['page'];
        $page_count     = $_GET['page_count'];
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->getMediaInfo($page,$page_count);
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 获取频道信息列表
     */
    public function pagegetChannelList($inPath)
    {
        $page           = $_GET['page'];
        $page_count     = $_GET['page_count'];
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->getChannelInfo($page,$page_count);
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 获取广告位信息列表
     */
    public function pagegetAdPositionList($inPath)
    {
        $page           = $_GET['page'];
        $page_count     = $_GET['page_count'];
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->getAdPositionInfo($page,$page_count);
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 获取广告位信息列表
     */
    public function pagegetMediaTagList($inPath)
    {
        $page           = $_GET['page'];
        $page_count     = $_GET['page_count'];
        $planInfoModel  = new model_planInfo();
        $res = $planInfoModel->getMediaTagInfo($page,$page_count);
        return SJson::encode($res);
    }

    /**
     * @param $inPath
     * @return string
     * @description 获取地区信息列表
     */
    public function pagegetAreaList($inPath)
    {
        $planInfoModel = new model_planInfo();
        $res = $planInfoModel->getAreaInfo();
        return SJson::encode($res);
    }



}

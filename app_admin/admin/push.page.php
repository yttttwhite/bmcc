<?php
class admin_push extends STpl{
    public $adminPushModel;

    function __construct($inPath){
        if(!user_api::auth("dpc")){
            $this->success("没有权限",'/baichuan_advertisement_manage/user',3);
            exit();
        }
    
        $this->init();
    }

    public function init()
    {
        $this->adminPushModel = new model_AdminPush();
    }

    public function pageLeft(){
        return $this->render("admin/push_left.html");
    }
    
    /**
     * 结果列表
     * */
    public function pageList()
    {
        $date = date('Ymd',time());

        $url = array();
        $url['this'] = parent::setGet("/baichuan_advertisement_manage/admin.push.list",$_GET);
        $get = parent::unsetGet(array('pushDate','page'));
        $url['date'] = parent::setGet("/baichuan_advertisement_manage/admin.push.list",$get);

        $sql = "";
        $condition = array();
        $order = 1;
        $title = "默认排序";
        $getAll = true;
        unset($PushList);
        if( isset($_GET['pushDate']) && strlen($_GET['pushDate'])>0 ){
            $timePush = strtotime($_GET['pushDate'].' 00:00:00');
            $datePush = date("Ymd",$timePush);
            $condition['Complaint_Date'] = $datePush;
            $PushList = $this->adminPushModel->getDataBySql($condition,NULL,30,"domain","ASC",$sql);
        }else{
            $PushList = array();
        }
        
        //分页查询
        $page = array();
        $perpage = 30;
        $count = count($PushList);
        $page['amount'] = $count;
        $page['count'] = ceil($count/$perpage);
        if(isset($_GET['page']))
        {
            $page['current'] = $_GET['page'];
        }else{
            $page['current'] = 1;
        }
        $get = parent::unsetGet('page');
        $page['url'] = parent::setGet("/baichuan_advertisement_manage/admin.push.List",$page);

        $indexStart = ($page['current']-1)*$perpage;
        $indexEnd = ($page['current'])*$perpage;
        
        unset($PushList2);
        $PushList2 = array();
        if($count>0)
        {
            $PushList2 = array_slice($PushList,$indexStart,30);
        }

        //分页查询结束
        $this->assign('stat',$PushList2);
        $this->assign("url",$url);
        $this->assign("page",$page);
        $this->assign("title",$title);
        $this->assign("pushDate",$_GET['pushDate']);
        return $this->render("/admin/push_list.html");
    }
}
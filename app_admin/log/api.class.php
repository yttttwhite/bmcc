<?php
class log_api{
    public function __construct(){
    }

    /// 定义日志解析，不需要记录可不写
    private static $operationList = array(
        'account' => '个人中心',
        'account.main.detail' => '个人中心',
        'account.main.update' => '个人中心：修改信息',
        'account.main.updatePWD' => '个人中心：修改密码',
        'ad.group.add' => '广告组：添加广告组',
        'ad.group.list' => '广告组：广告素材列表',
        'ad.group.status' => '广告组：设置广告组状态',
        'ad.plan' => '广告计划：广告计划列表',
        'ad.plan.add' => '广告计划：新增广告计划',
        'ad.plan.list' => '广告计划：查看广告计划',
        'ad.plan.status' => '广告计划：设置广告计划状态',
        'ad.preview.entry' => '广告：预览',
        'ad.stuff.add' => '广告：批量管理素材',
        'ad.stuff.addone' => '广告：添加素材',
        'ad.stuff.del' => '广告：删除素材',
        'ad.stuff.delete' => '广告：删除素材',
        'ad.stuff.save' => '广告：保存素材',
        'ad.stuff.status' => '广告：设置素材状态',
        'admin.shenhe.plan' => '管理：广告计划审核',
        'admin.shenhe.planSet' => '管理：广告计划审核，设置审核状态',
        'admin.shenhe.stuff' => '管理：广告素材审核，设置审核状态',
        'admin.shenhe.stuffSet' => '管理：广告素材审核，设置审核状态',
        'admin.user.add' => '管理：添加用户',
        'admin.user.edit' => '管理：编辑用户',
        'admin.user.list' => '管理：用户列表',
        'admin.user.topup' => '管理：充值',
        'caiwu' => '财务管理',
        'dpc' => 'DPC管理：数据库列表',
        'dpc.main.add' => 'DPC管理：管理列表',
        'dpc.main.adsl' => 'DPC管理：ADSL黑白名单',
        'dpc.main.getAreaPushInterval' => 'DPC管理：地域',
        'dpc.main.host' => 'DPC管理：HOST黑白名单',
        'dpc.main.hostGroup' => 'DPC管理：HOST分组',
        'dpc.main.list' => 'DPC管理：数据库列表',
        'dpc.main.template' => 'DPC管理：编辑内容',
        'dpc.manage' => 'DPC管理：新版，mongo列表',
        'report.main.dataEcharts' => '广告计划页面：统计报表',
        'report.stat.detail' => '数据统计：数据详情（图表）',
        'report.stat.host' => '数据统计：数据列表',
        //'user' => '用户：登陆页',
        'user.main.login' => '用户：登录'
    );

    private static $log_data;

    public static function log(){
        //if(!user_api::auth('system')){
        if(true){
            $get = json_encode($_GET);
            $post = json_encode($_POST);
            self::$log_data = array();
            self::$log_data['uid'] = user_api::id();
            self::$log_data['uname'] = user_api::name();
            self::$log_data['time'] = time();
            self::$log_data['url'] = $_SERVER['REQUEST_URI'];
            self::$log_data['ip'] = $_SERVER['REMOTE_ADDR'];
            self::$log_data['get'] = strlen($get)>1000?'max':$get;
            self::$log_data['post'] = strlen($post)>1000?'max':$post;
            
            $needLog = self::getOperation();
            if( $needLog ){ // 不需要记录所有操作
                $logModel = new model_Log();
                if($_SERVER['REQUEST_URI']!='/user'){
                    $logModel->addData(self::$log_data);
                }
            }
        }
    }

    public static function getOperation(){
        $needLog = true;
        $operation = str_replace('/', '', self::$log_data['url']);
        if(stripos($operation, '?') !== false){
            $operation = substr($operation, 0,stripos($operation, '?'));
        }
        $temp = explode('.', $operation);
        if(count($temp)>3){
            $operation = $temp[0].'.'.$temp[1].'.'.$temp[2];
        }

        self::$log_data['operation'] = $operation;
        $op_name = self::$operationList[$operation];
        if( is_string($op_name) ){
            self::$log_data['operation_name'] = $op_name;
        }elseif (is_callable($op_name)) {
            try {
                self::$log_data['operation_name'] = $op_name(self::$log_data);
            } catch (Exception $e) {
                self::$log_data['operation_name'] = '';
            }
        }else {
            self::$log_data['operation_name'] = '';
        }

        return $needLog;
    }
    
}

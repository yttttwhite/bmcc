<?php
$config = array();
$config['partner'] = "zhejiang";
//数据库配置
//ADP
$config['db']['1']['dbhost']    = '115.29.173.59:3306';
$config['db']['1']['dbuser']    = 'root';
$config['db']['1']['dbpw']      = 'Mypassword@2qq';
$config['db']['1']['dbcharset'] = 'utf8';
$config['db']['1']['pconnect']  = '0';
$config['db']['1']['dbname']    = 'adp_bmcc';
$config['db']['1']['tablepre']  = 'adp_';
//rmc
$config['db']['2']['dbhost']    = '112.124.46.89:33966';
$config['db']['2']['dbuser']    = 'root';
$config['db']['2']['dbpw']      = 'mypassword2qq';
$config['db']['2']['dbcharset'] = 'utf8';
$config['db']['2']['pconnect']  = '0';
$config['db']['2']['dbname']    = 'rmc';
$config['db']['2']['tablepre']  = 'rmc_';
//137
$config['db']['3']['dbhost']    = '115.239.138.137:33966';
$config['db']['3']['dbuser']    = 'root';
$config['db']['3']['dbpw']      = 'bcdata@2701';
$config['db']['3']['dbcharset'] = 'utf8';
$config['db']['3']['pconnect']  = '0';
$config['db']['3']['dbname']    = 'push_flow_monitor';
$config['db']['3']['tablepre']  = 'BC_';
//complain
$config['db']['4']['dbhost'] = '192.168.6.13:3306';
$config['db']['4']['dbuser']    = 'zwdong';
$config['db']['4']['dbpw']      = '12345678';
$config['db']['4']['dbcharset'] = 'latin1';
$config['db']['4']['pconnect']  = '0';
$config['db']['4']['dbname'] = 'Complaint_Database';
$config['db']['4']['tablepre'] = 'Complaint_';
//数据库映射关系
$config['db']['map']=array(
                                'user_tag'  =>  2,
                                'creative'  =>  3,
                                'push'      =>  3,
                                'pushed'    =>  3,
                                'pushinfo'  =>  3,
                                'host'      =>  3,
                                'log'       =>  3,
                                'redirection'=> 3,

								'Details'=>4,
                                'domain'=>4
                            );
$config['role'] = array(
    10000   =>array('name'=>"系统管理员",   'auth_list'=>'system,admin,ad,dpc,financial,stat,user,media,shenhe,dc,dsp,audient'),
    1000    =>array('name'=>"运营",  'auth_list'=>'admin,ad,dpc,financial,stat,user,shenhe,dc,dsp,audient'),
    18      =>array('name'=>"子运营商",  'auth_list'=>'ad,dpc,financial,stat,user,shenhe,dc,dsp,audient'),
    11      =>array('name'=>"客服",   'auth_list'=>'ad,dpc,financial,stat,dc,dsp'),
    12      =>array('name'=>"客户经理", 'auth_list'=>'stat,ad,dc,dsp'),
    13      =>array('name'=>"广告商",  'auth_list'=>'ad,dsp'),
    14      =>array('name'=>"运维",   'auth_list'=>'it'),
    15      =>array('name'=>"黑白名管理员", 'auth_list'=>'dpcRule'),
    16      =>array('name'=>"稽核员",  'auth_list'=>'ad,adReadonly'),
    17      =>array('name'=>"产品经理", 'auth_list'=>'ad,adReadonly,adGroupEdit'),
    
);
$config['auth'] = array(
    'ad'        =>'广告管理',
    'dpc'       =>'DPC管理',
    'dpcRule'   =>'DPC规则配置',
    'financial' =>'财务管理',
    'dc'        =>'数据中心',
    'stat'      =>'数据统计',
    'user'      =>'用户管理',
    'shenhe'    =>'审核',
    'media'     =>'媒体管理',
    'audient'   =>'人群管理',
    'dps'       =>'DSP管理',
    'system'    =>'系统',
);

$config['bidder'] = array();
$config['bidder'][] = "112.124.46.89:7701";
$config['bidder'][] = "www.202m.com";
$config['bidder'][] = "61.160.200.172:7788";

//start：可配置项默认值
$config['log'] = false;
$config['theme'] = "default";
$config['logo'] = "/assets_admin/images/logo/logo_10086.png";
$config['copyright'] = "2015 &copy; 百川通联精准广告营销平台";
$config['icp'] = "";
$config['config']['delete'] = 0;    //0:用户可以删除自己的广告; 1：只有管理员可以删除
$config['mongo'] = array(
    'domain'=>'beijing_unicom',
    'dpc'=>'beijing_unicom',
);

//功能配置
$version = array("1"=>"operator", "2"=>"dsp");
$config['version']['adp']['group_sp'] = 1;    //广告组局点控制功能
$config['version']['adp']['group_exchange'] = 1;    //广告组Exchange
$config['version']['adp']['plan_redirect'] = 1;    //开放背投，跳转广告
$config['version']['adp']['stuff_text'] = 1;    //开放文本素材
$config['version']['dc']['manage'] = 1;    //对admin用户放开数据中心管理
$config['version']['dpc']['manage'] = 1;    //对admin用户放开dpc管理
$config['version']['dsp']['manage'] = 1;    //DSP管理
$config['version']['dsp']['media'] = 1;    //DSP媒体管理
$config['version']['dsp']['people'] = 0;    //人群管理
$config['version']['stuff']['shenhe'] = 1;    //素材需要审核
$config['version']['crm']['display'] = 0;
$config['version']['report']['stat'] = 1;
$config['version']['partner'] = "jiangsu";
$config['version']['version'] = $version[1];    //系统版本
$config['version']['dev'] = false;    //是否可开发调试
//end：可配置项默认值

switch ($_SERVER['HTTP_HOST']) {
    case '115.239.138.137:9994':
        //信息
        $config['log'] = true;
        $config['logo'] = "/assets_admin/images/logo/logo-shutong.png";
        $config['copyright'] = "2015 &copy; 精准广告营销平台";
        $config['icp'] = "";
        $config['config']['delete'] = 1;
        $config['mongo'] = array('domain'=>'zhejiang_telecom');

        //功能
        $config['version']['dsp']['manage'] = 0;    //DSP管理
        $config['version']['dsp']['media'] = 0;    //DSP媒体管理
        $config['version']['dsp']['people'] = 0;    //人群管理
        $config['version']['version'] = $version[1];    //系统版本

        //数据库：ADP
        $config['db']['1']['dbhost']    = '192.168.6.13';
        $config['db']['1']['dbuser']    = 'bc';
        $config['db']['1']['dbpw']      = 'bc!@#Q4';
        $config['db']['1']['dbcharset'] = 'utf8';
        $config['db']['1']['pconnect']  = '0';
        $config['db']['1']['dbname']    = 'baichuandb';
        $config['db']['1']['tablepre']  = 'adp_';
        //数据库：RMC
        $config['db']['2']['dbhost']    = '192.168.6.13';
        $config['db']['2']['dbuser']    = 'bc';
        $config['db']['2']['dbpw']      = 'bc!@#Q4';
        $config['db']['2']['dbcharset'] = 'utf8';
        $config['db']['2']['pconnect']  = '0';
        $config['db']['2']['dbname']    = 'rmc';
        $config['db']['2']['tablepre']  = 'rmc_';
        break;

    case '112.124.65.86:10086':
        $config['logo'] = "/assets_admin/images/logo/logo_chinamobile.png";
        $config['copyright'] = "2015 &copy; 中国移动集团";
        $config['icp'] = "";
        break;

    case 'migu.m.im':
        $config['version']['version'] = $version[2];    //系统版本
        $config['version']['dpc']['manage'] = 0;    //对admin用户放开dpc管理
        $config['report']['stat'] = 0;
        $config['logo'] = "/assets_admin/images/logo/logo-migu.png";
        $config['copyright'] = "2015 &copy; 咪咕数字传媒有限公司";
        $config['icp'] = "";
        break;

    case 'zhuoxin.m.im':
        $config['version']['version'] = $version[1];    //系统版本
        $config['version']['dpc']['manage'] = 1;    //对admin用户放开dpc管理
        $config['report']['stat'] = 0;
        $config['logo'] = "/assets_admin/images/logo/logo_zhuoxin.png";
        $config['copyright'] = "2015 - 2016 &copy; 浙江欣网卓信科技股份有限公司";
        $config['icp'] = "";
        break;

    case '61.130.247.180:7703':
        $config['version']['version'] = $version[2];    //系统版本
        $config['version']['dpc']['manage'] = 0;    //对admin用户放开dpc管理
        $config['report']['stat'] = 0;
        $config['logo'] = "/assets_admin/images/logo/logo-tyread.png";
        $config['copyright'] = "2015 &copy; 天翼阅读文化传播有限公司";
        $config['icp'] = "";
        break;

    default:
        break;
}
$config['ta'] = array(
    'BALL'              =>array('id'=>'BALL'            ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'天气球入口',       'style'=>'悬浮窗'),
    'NAME'              =>array('id'=>'NAME'            ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'广告频道',         'style'=>'频道冠名专题'),
    'NAME1'             =>array('id'=>'NAME1'           ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'广告频道',         'style'=>'首页'),
    'NEWS'              =>array('id'=>'NEWS'            ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'新闻频道',         'style'=>'首页'),
    'BEIJING'           =>array('id'=>'BEIJING'         ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'北京频道',         'style'=>'首页'),
    'PLAY'              =>array('id'=>'PLAY'            ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'娱乐频道',         'style'=>'首页'),
    'SOCIETY'           =>array('id'=>'SOCIETY'         ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'社会频道',         'style'=>'首页'),
    'FE'                =>array('id'=>'FE'              ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'财经频道',         'style'=>'首页'),
    'ST'                =>array('id'=>'ST'              ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'科技频道',         'style'=>'首页'),
    'SPORTS'            =>array('id'=>'SPORTS'          ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'体育频道',         'style'=>'首页'),
    'NBA'               =>array('id'=>'NBA'             ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'NBA频道',          'style'=>'首页'),
    'MILITARY'          =>array('id'=>'MILITARY'        ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'军事频道',         'style'=>'首页'),
    'HISTORY'           =>array('id'=>'HISTORY'         ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'历史频道',         'style'=>'首页'),
    'FASHION'           =>array('id'=>'FASHION'         ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'时尚频道',         'style'=>'首页'),
    'CAR'               =>array('id'=>'CAR'             ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'汽车频道',         'style'=>'首页'),
    'TRAVEL'            =>array('id'=>'TRAVEL'          ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'旅游频道',         'style'=>'首页'),
    'HUMOR'             =>array('id'=>'HUMOR'           ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'段子频道',         'style'=>'首页'),
    'ESTATE'            =>array('id'=>'ESTATE'          ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'房产频道',         'style'=>'首页'),
    'POLITICS'          =>array('id'=>'POLITICS'        ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'时政频道',         'style'=>'首页'),
    'CONSTELLATION'     =>array('id'=>'CONSTELLATION'   ,'width'=>520, 'height'=>520, 'size'=>300, 'fontsize'=>0,   'priority'=>'A', 'pos'=>'星座频道',         'style'=>'首页'),
    'NEWS1'             =>array('id'=>'NEWS1'           ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'新闻列表页',       'style'=>'焦点图1'),
    'NEWS2'             =>array('id'=>'NEWS2'           ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'新闻列表页',       'style'=>'焦点图2'),
    'NEWS3'             =>array('id'=>'NEWS3'           ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'新闻列表页',       'style'=>'焦点图3'),
    'NEWS4'             =>array('id'=>'NEWS4'           ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'新闻列表页',       'style'=>'焦点图4'),
    'NEWS5'             =>array('id'=>'NEWS5'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'新闻列表页',       'style'=>'信息流(图+文)1'),
    'NEWS6'             =>array('id'=>'NEWS6'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'新闻列表页',       'style'=>'信息流(图+文)2'),
    'NEWS7'             =>array('id'=>'NEWS7'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'新闻列表页',       'style'=>'信息流(图+文)3'),
    'NEWS8'             =>array('id'=>'NEWS8'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'新闻列表页',       'style'=>'信息流(图+文)4'),
    'NEWS9'             =>array('id'=>'NEWS9'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'新闻列表页',       'style'=>'信息流(图+文)5'),
    'NEWS10'            =>array('id'=>'NEWS10'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'新闻列表页',       'style'=>'信息流(图+文)6'),
    'NEWS11'            =>array('id'=>'NEWS11'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'新闻列表页',       'style'=>'信息流(图+文)7'),
    'NEWS12'            =>array('id'=>'NEWS12'          ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'新闻列表页',       'style'=>'信息流(图+文)8'),
    'BEIJING1'          =>array('id'=>'BEIJING1'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'北京列表页',       'style'=>'焦点图1'),
    'BEIJING2'          =>array('id'=>'BEIJING2'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'北京列表页',       'style'=>'焦点图2'),
    'BEIJING3'          =>array('id'=>'BEIJING3'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'北京列表页',       'style'=>'焦点图3'),
    'BEIJING4'          =>array('id'=>'BEIJING4'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'北京列表页',       'style'=>'焦点图4'),
    'BEIJING5'          =>array('id'=>'BEIJING5'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'北京列表页',       'style'=>'信息流(图+文)1'),
    'BEIJING6'          =>array('id'=>'BEIJING6'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'北京列表页',       'style'=>'信息流(图+文)2'),
    'BEIJING7'          =>array('id'=>'BEIJING7'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'北京列表页',       'style'=>'信息流(图+文)3'),
    'BEIJING8'          =>array('id'=>'BEIJING8'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'北京列表页',       'style'=>'信息流(图+文)4'),
    'BEIJING9'          =>array('id'=>'BEIJING9'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'北京列表页',       'style'=>'信息流(图+文)5'),
    'BEIJING10'         =>array('id'=>'BEIJING10'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'北京列表页',       'style'=>'信息流(图+文)6'),
    'BEIJING11'         =>array('id'=>'BEIJING11'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'北京列表页',       'style'=>'信息流(图+文)7'),
    'BEIJING12'         =>array('id'=>'BEIJING12'       ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'北京列表页',       'style'=>'信息流(图+文)8'),
    'PLAY1'             =>array('id'=>'PLAY1'           ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'娱乐列表页',       'style'=>'焦点图1'),
    'PLAY2'             =>array('id'=>'PLAY2'           ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'娱乐列表页',       'style'=>'焦点图2'),
    'PLAY3'             =>array('id'=>'PLAY3'           ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'娱乐列表页',       'style'=>'焦点图3'),
    'PLAY4'             =>array('id'=>'PLAY4'           ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'娱乐列表页',       'style'=>'焦点图4'),
    'PLAY5'             =>array('id'=>'PLAY5'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'娱乐列表页',       'style'=>'信息流(图+文)1'),
    'PLAY6'             =>array('id'=>'PLAY6'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'娱乐列表页',       'style'=>'信息流(图+文)2'),
    'PLAY7'             =>array('id'=>'PLAY7'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'娱乐列表页',       'style'=>'信息流(图+文)3'),
    'PLAY8'             =>array('id'=>'PLAY8'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'娱乐列表页',       'style'=>'信息流(图+文)4'),
    'PLAY9'             =>array('id'=>'PLAY9'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'娱乐列表页',       'style'=>'信息流(图+文)5'),
    'PLAY10'            =>array('id'=>'PLAY10'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'娱乐列表页',       'style'=>'信息流(图+文)6'),
    'PLAY11'            =>array('id'=>'PLAY11'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'娱乐列表页',       'style'=>'信息流(图+文)7'),
    'PLAY12'            =>array('id'=>'PLAY12'          ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'娱乐列表页',       'style'=>'信息流(图+文)8'),
    'SOCIETY1'          =>array('id'=>'SOCIETY1'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'社会列表页',       'style'=>'焦点图1'),
    'SOCIETY2'          =>array('id'=>'SOCIETY2'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'社会列表页',       'style'=>'焦点图2'),
    'SOCIETY3'          =>array('id'=>'SOCIETY3'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'社会列表页',       'style'=>'焦点图3'),
    'SOCIETY4'          =>array('id'=>'SOCIETY4'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'社会列表页',       'style'=>'焦点图4'),
    'SOCIETY5'          =>array('id'=>'SOCIETY5'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'社会列表页',       'style'=>'信息流(图+文)1'),
    'SOCIETY6'          =>array('id'=>'SOCIETY6'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'社会列表页',       'style'=>'信息流(图+文)2'),
    'SOCIETY7'          =>array('id'=>'SOCIETY7'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'社会列表页',       'style'=>'信息流(图+文)3'),
    'SOCIETY8'          =>array('id'=>'SOCIETY8'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'社会列表页',       'style'=>'信息流(图+文)4'),
    'SOCIETY9'          =>array('id'=>'SOCIETY9'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'社会列表页',       'style'=>'信息流(图+文)5'),
    'SOCIETY10'         =>array('id'=>'SOCIETY10'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'社会列表页',       'style'=>'信息流(图+文)6'),
    'SOCIETY11'         =>array('id'=>'SOCIETY11'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'社会列表页',       'style'=>'信息流(图+文)7'),
    'SOCIETY12'         =>array('id'=>'SOCIETY12'       ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'社会列表页',       'style'=>'信息流(图+文)8'),
    'FE1'               =>array('id'=>'FE1'             ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'财经列表页',       'style'=>'焦点图1'),
    'FE2'               =>array('id'=>'FE2'             ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'财经列表页',       'style'=>'焦点图2'),
    'FE3'               =>array('id'=>'FE3'             ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'财经列表页',       'style'=>'焦点图3'),
    'FE4'               =>array('id'=>'FE4'             ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'财经列表页',       'style'=>'焦点图4'),
    'FE5'               =>array('id'=>'FE5'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'财经列表页',       'style'=>'信息流(图+文)1'),
    'FE6'               =>array('id'=>'FE6'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'财经列表页',       'style'=>'信息流(图+文)2'),
    'FE7'               =>array('id'=>'FE7'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'财经列表页',       'style'=>'信息流(图+文)3'),
    'FE8'               =>array('id'=>'FE8'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'财经列表页',       'style'=>'信息流(图+文)4'),
    'FE9'               =>array('id'=>'FE9'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'财经列表页',       'style'=>'信息流(图+文)5'),
    'FE10'              =>array('id'=>'FE10'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'财经列表页',       'style'=>'信息流(图+文)6'),
    'FE11'              =>array('id'=>'FE11'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'财经列表页',       'style'=>'信息流(图+文)7'),
    'FE12'              =>array('id'=>'FE12'            ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'财经列表页',       'style'=>'信息流(图+文)8'),
    'ST1'               =>array('id'=>'ST1'             ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'科技列表页',       'style'=>'焦点图1'),
    'ST2'               =>array('id'=>'ST2'             ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'科技列表页',       'style'=>'焦点图2'),
    'ST3'               =>array('id'=>'ST3'             ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'科技列表页',       'style'=>'焦点图3'),
    'ST4'               =>array('id'=>'ST4'             ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'科技列表页',       'style'=>'焦点图4'),
    'ST5'               =>array('id'=>'ST5'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'科技列表页',       'style'=>'信息流(图+文)1'),
    'ST6'               =>array('id'=>'ST6'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'科技列表页',       'style'=>'信息流(图+文)2'),
    'ST7'               =>array('id'=>'ST7'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'科技列表页',       'style'=>'信息流(图+文)3'),
    'ST8'               =>array('id'=>'ST8'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'科技列表页',       'style'=>'信息流(图+文)4'),
    'ST9'               =>array('id'=>'ST9'             ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'科技列表页',       'style'=>'信息流(图+文)5'),
    'ST10'              =>array('id'=>'ST10'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'科技列表页',       'style'=>'信息流(图+文)6'),
    'ST11'              =>array('id'=>'ST11'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'科技列表页',       'style'=>'信息流(图+文)7'),
    'ST12'              =>array('id'=>'ST12'            ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'科技列表页',       'style'=>'信息流(图+文)8'),
    'SPORTS1'           =>array('id'=>'SPORTS1'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'体育列表页',       'style'=>'焦点图1'),
    'SPORTS2'           =>array('id'=>'SPORTS2'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'体育列表页',       'style'=>'焦点图2'),
    'SPORTS3'           =>array('id'=>'SPORTS3'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'体育列表页',       'style'=>'焦点图3'),
    'SPORTS4'           =>array('id'=>'SPORTS4'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'体育列表页',       'style'=>'焦点图4'),
    'SPORTS5'           =>array('id'=>'SPORTS5'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'体育列表页',       'style'=>'信息流(图+文)1'),
    'SPORTS6'           =>array('id'=>'SPORTS6'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'体育列表页',       'style'=>'信息流(图+文)2'),
    'SPORTS7'           =>array('id'=>'SPORTS7'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'体育列表页',       'style'=>'信息流(图+文)3'),
    'SPORTS8'           =>array('id'=>'SPORTS8'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'体育列表页',       'style'=>'信息流(图+文)4'),
    'SPORTS9'           =>array('id'=>'SPORTS9'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'体育列表页',       'style'=>'信息流(图+文)5'),
    'SPORTS10'          =>array('id'=>'SPORTS10'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'体育列表页',       'style'=>'信息流(图+文)6'),
    'SPORTS11'          =>array('id'=>'SPORTS11'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'体育列表页',       'style'=>'信息流(图+文)7'),
    'SPORTS12'          =>array('id'=>'SPORTS12'        ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'体育列表页',       'style'=>'信息流(图+文)8'),
    'NBA1'              =>array('id'=>'NBA1'            ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'NBA列表页',       'style'=>'焦点图1'),
    'NBA2'              =>array('id'=>'NBA2'            ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'NBA列表页',       'style'=>'焦点图2'),
    'NBA3'              =>array('id'=>'NBA3'            ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'NBA列表页',       'style'=>'焦点图3'),
    'NBA4'              =>array('id'=>'NBA4'            ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'NBA列表页',       'style'=>'焦点图4'),
    'NBA5'              =>array('id'=>'NBA5'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'NBA列表页',       'style'=>'信息流(图+文)1'),
    'NBA6'              =>array('id'=>'NBA6'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'NBA列表页',       'style'=>'信息流(图+文)2'),
    'NBA7'              =>array('id'=>'NBA7'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'NBA列表页',       'style'=>'信息流(图+文)3'),
    'NBA8'              =>array('id'=>'NBA8'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'NBA列表页',       'style'=>'信息流(图+文)4'),
    'NBA9'              =>array('id'=>'NBA9'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'NBA列表页',       'style'=>'信息流(图+文)5'),
    'NBA10'             =>array('id'=>'NBA10'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'NBA列表页',       'style'=>'信息流(图+文)6'),
    'NBA11'             =>array('id'=>'NBA11'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'NBA列表页',       'style'=>'信息流(图+文)7'),
    'NBA12'             =>array('id'=>'NBA12'           ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'NBA列表页',       'style'=>'信息流(图+文)8'),
    'MILITARY1'         =>array('id'=>'MILITARY1'       ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'军事列表页',       'style'=>'焦点图1'),
    'MILITARY2'         =>array('id'=>'MILITARY2'       ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'军事列表页',       'style'=>'焦点图2'),
    'MILITARY3'         =>array('id'=>'MILITARY3'       ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'军事列表页',       'style'=>'焦点图3'),
    'MILITARY4'         =>array('id'=>'MILITARY4'       ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'军事列表页',       'style'=>'焦点图4'),
    'MILITARY5'         =>array('id'=>'MILITARY5'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'军事列表页',       'style'=>'信息流(图+文)1'),
    'MILITARY6'         =>array('id'=>'MILITARY6'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'军事列表页',       'style'=>'信息流(图+文)2'),
    'MILITARY7'         =>array('id'=>'MILITARY7'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'军事列表页',       'style'=>'信息流(图+文)3'),
    'MILITARY8'         =>array('id'=>'MILITARY8'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'军事列表页',       'style'=>'信息流(图+文)4'),
    'MILITARY9'         =>array('id'=>'MILITARY9'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'军事列表页',       'style'=>'信息流(图+文)5'),
    'MILITARY10'        =>array('id'=>'MILITARY10'      ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'军事列表页',       'style'=>'信息流(图+文)6'),
    'MILITARY11'        =>array('id'=>'MILITARY11'      ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'军事列表页',       'style'=>'信息流(图+文)7'),
    'MILITARY12'        =>array('id'=>'MILITARY12'      ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'军事列表页',       'style'=>'信息流(图+文)8'),
    'HISTORY1'          =>array('id'=>'HISTORY1'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'历史列表页',       'style'=>'焦点图1'),
    'HISTORY2'          =>array('id'=>'HISTORY2'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'历史列表页',       'style'=>'焦点图2'),
    'HISTORY3'          =>array('id'=>'HISTORY3'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'历史列表页',       'style'=>'焦点图3'),
    'HISTORY4'          =>array('id'=>'HISTORY4'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'历史列表页',       'style'=>'焦点图4'),
    'HISTORY5'          =>array('id'=>'HISTORY5'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'历史列表页',       'style'=>'信息流(图+文)1'),
    'HISTORY6'          =>array('id'=>'HISTORY6'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'历史列表页',       'style'=>'信息流(图+文)2'),
    'HISTORY7'          =>array('id'=>'HISTORY7'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'历史列表页',       'style'=>'信息流(图+文)3'),
    'HISTORY8'          =>array('id'=>'HISTORY8'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'历史列表页',       'style'=>'信息流(图+文)4'),
    'HISTORY9'          =>array('id'=>'HISTORY9'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'历史列表页',       'style'=>'信息流(图+文)5'),
    'HISTORY10'         =>array('id'=>'HISTORY10'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'历史列表页',       'style'=>'信息流(图+文)6'),
    'HISTORY11'         =>array('id'=>'HISTORY11'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'历史列表页',       'style'=>'信息流(图+文)7'),
    'HISTORY12'         =>array('id'=>'HISTORY12'       ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'历史列表页',       'style'=>'信息流(图+文)8'),
    'FASHION1'          =>array('id'=>'FASHION1'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'时尚列表页',       'style'=>'焦点图1'),
    'FASHION2'          =>array('id'=>'FASHION2'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'时尚列表页',       'style'=>'焦点图2'),
    'FASHION3'          =>array('id'=>'FASHION3'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'时尚列表页',       'style'=>'焦点图3'),
    'FASHION4'          =>array('id'=>'FASHION4'        ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'时尚列表页',       'style'=>'焦点图4'),
    'FASHION5'          =>array('id'=>'FASHION5'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'时尚列表页',       'style'=>'信息流(图+文)1'),
    'FASHION6'          =>array('id'=>'FASHION6'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时尚列表页',       'style'=>'信息流(图+文)2'),
    'FASHION7'          =>array('id'=>'FASHION7'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时尚列表页',       'style'=>'信息流(图+文)3'),
    'FASHION8'          =>array('id'=>'FASHION8'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时尚列表页',       'style'=>'信息流(图+文)4'),
    'FASHION9'          =>array('id'=>'FASHION9'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时尚列表页',       'style'=>'信息流(图+文)5'),
    'FASHION10'         =>array('id'=>'FASHION10'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时尚列表页',       'style'=>'信息流(图+文)6'),
    'FASHION11'         =>array('id'=>'FASHION11'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时尚列表页',       'style'=>'信息流(图+文)7'),
    'FASHION12'         =>array('id'=>'FASHION12'       ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时尚列表页',       'style'=>'信息流(图+文)8'),
    'CAR1'              =>array('id'=>'CAR1'            ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'汽车列表页',       'style'=>'焦点图1'),
    'CAR2'              =>array('id'=>'CAR2'            ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'汽车列表页',       'style'=>'焦点图2'),
    'CAR3'              =>array('id'=>'CAR3'            ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'汽车列表页',       'style'=>'焦点图3'),
    'CAR4'              =>array('id'=>'CAR4'            ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'汽车列表页',       'style'=>'焦点图4'),
    'CAR5'              =>array('id'=>'CAR5'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'汽车列表页',       'style'=>'信息流(图+文)1'),
    'CAR6'              =>array('id'=>'CAR6'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'汽车列表页',       'style'=>'信息流(图+文)2'),
    'CAR7'              =>array('id'=>'CAR7'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'汽车列表页',       'style'=>'信息流(图+文)3'),
    'CAR8'              =>array('id'=>'CAR8'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'汽车列表页',       'style'=>'信息流(图+文)4'),
    'CAR9'              =>array('id'=>'CAR9'            ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'汽车列表页',       'style'=>'信息流(图+文)5'),
    'CAR10'             =>array('id'=>'CAR10'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'汽车列表页',       'style'=>'信息流(图+文)6'),
    'CAR11'             =>array('id'=>'CAR11'           ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'汽车列表页',       'style'=>'信息流(图+文)7'),
    'CAR12'             =>array('id'=>'CAR12'           ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'汽车列表页',       'style'=>'信息流(图+文)8'),
    'TRAVEL1'           =>array('id'=>'TRAVEL1'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'旅游列表页',       'style'=>'焦点图1'),
    'TRAVEL2'           =>array('id'=>'TRAVEL2'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'旅游列表页',       'style'=>'焦点图2'),
    'TRAVEL3'           =>array('id'=>'TRAVEL3'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'旅游列表页',       'style'=>'焦点图3'),
    'TRAVEL4'           =>array('id'=>'TRAVEL4'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'旅游列表页',       'style'=>'焦点图4'),
    'TRAVEL5'           =>array('id'=>'TRAVEL5'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'旅游列表页',       'style'=>'信息流(图+文)1'),
    'TRAVEL6'           =>array('id'=>'TRAVEL6'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'旅游列表页',       'style'=>'信息流(图+文)2'),
    'TRAVEL7'           =>array('id'=>'TRAVEL7'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'旅游列表页',       'style'=>'信息流(图+文)3'),
    'TRAVEL8'           =>array('id'=>'TRAVEL8'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'旅游列表页',       'style'=>'信息流(图+文)4'),
    'TRAVEL9'           =>array('id'=>'TRAVEL9'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'旅游列表页',       'style'=>'信息流(图+文)5'),
    'TRAVEL10'          =>array('id'=>'TRAVEL10'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'旅游列表页',       'style'=>'信息流(图+文)6'),
    'TRAVEL11'          =>array('id'=>'TRAVEL11'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'旅游列表页',       'style'=>'信息流(图+文)7'),
    'TRAVEL12'          =>array('id'=>'TRAVEL12'        ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'旅游列表页',       'style'=>'信息流(图+文)8'),
    'HUMOR1'            =>array('id'=>'HUMOR1'          ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'段子列表页',       'style'=>'焦点图1'),
    'HUMOR2'            =>array('id'=>'HUMOR2'          ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'段子列表页',       'style'=>'焦点图2'),
    'HUMOR3'            =>array('id'=>'HUMOR3'          ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'段子列表页',       'style'=>'焦点图3'),
    'HUMOR4'            =>array('id'=>'HUMOR4'          ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'段子列表页',       'style'=>'焦点图4'),
    'HUMOR5'            =>array('id'=>'HUMOR5'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'段子列表页',       'style'=>'信息流(图+文)1'),
    'HUMOR6'            =>array('id'=>'HUMOR6'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'段子列表页',       'style'=>'信息流(图+文)2'),
    'HUMOR7'            =>array('id'=>'HUMOR7'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'段子列表页',       'style'=>'信息流(图+文)3'),
    'HUMOR8'            =>array('id'=>'HUMOR8'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'段子列表页',       'style'=>'信息流(图+文)4'),
    'HUMOR9'            =>array('id'=>'HUMOR9'          ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'段子列表页',       'style'=>'信息流(图+文)5'),
    'HUMOR10'           =>array('id'=>'HUMOR10'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'段子列表页',       'style'=>'信息流(图+文)6'),
    'HUMOR11'           =>array('id'=>'HUMOR11'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'段子列表页',       'style'=>'信息流(图+文)7'),
    'HUMOR12'           =>array('id'=>'HUMOR12'         ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'段子列表页',       'style'=>'信息流(图+文)8'),
    'ESTATE1'           =>array('id'=>'ESTATE1'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'房产列表页',       'style'=>'焦点图1'),
    'ESTATE2'           =>array('id'=>'ESTATE2'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'房产列表页',       'style'=>'焦点图2'),
    'ESTATE3'           =>array('id'=>'ESTATE3'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'房产列表页',       'style'=>'焦点图3'),
    'ESTATE4'           =>array('id'=>'ESTATE4'         ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'房产列表页',       'style'=>'焦点图4'),
    'ESTATE5'           =>array('id'=>'ESTATE5'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'房产列表页',       'style'=>'信息流(图+文)1'),
    'ESTATE6'           =>array('id'=>'ESTATE6'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'房产列表页',       'style'=>'信息流(图+文)2'),
    'ESTATE7'           =>array('id'=>'ESTATE7'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'房产列表页',       'style'=>'信息流(图+文)3'),
    'ESTATE8'           =>array('id'=>'ESTATE8'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'房产列表页',       'style'=>'信息流(图+文)4'),
    'ESTATE9'           =>array('id'=>'ESTATE9'         ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'房产列表页',       'style'=>'信息流(图+文)5'),
    'ESTATE10'          =>array('id'=>'ESTATE10'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'房产列表页',       'style'=>'信息流(图+文)6'),
    'ESTATE11'          =>array('id'=>'ESTATE11'        ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'房产列表页',       'style'=>'信息流(图+文)7'),
    'ESTATE12'          =>array('id'=>'ESTATE12'        ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'房产列表页',       'style'=>'信息流(图+文)8'),
    'POLITICS1'         =>array('id'=>'POLITICS1'       ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'时政列表页',       'style'=>'焦点图1'),
    'POLITICS2'         =>array('id'=>'POLITICS2'       ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'时政列表页',       'style'=>'焦点图2'),
    'POLITICS3'         =>array('id'=>'POLITICS3'       ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'时政列表页',       'style'=>'焦点图3'),
    'POLITICS4'         =>array('id'=>'POLITICS4'       ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'时政列表页',       'style'=>'焦点图4'),
    'POLITICS5'         =>array('id'=>'POLITICS5'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'时政列表页',       'style'=>'信息流(图+文)1'),
    'POLITICS6'         =>array('id'=>'POLITICS6'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时政列表页',       'style'=>'信息流(图+文)2'),
    'POLITICS7'         =>array('id'=>'POLITICS7'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时政列表页',       'style'=>'信息流(图+文)3'),
    'POLITICS8'         =>array('id'=>'POLITICS8'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时政列表页',       'style'=>'信息流(图+文)4'),
    'POLITICS9'         =>array('id'=>'POLITICS9'       ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时政列表页',       'style'=>'信息流(图+文)5'),
    'POLITICS10'        =>array('id'=>'POLITICS10'      ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时政列表页',       'style'=>'信息流(图+文)6'),
    'POLITICS11'        =>array('id'=>'POLITICS11'      ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时政列表页',       'style'=>'信息流(图+文)7'),
    'POLITICS12'        =>array('id'=>'POLITICS12'      ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'时政列表页',       'style'=>'信息流(图+文)8'),
    'CONSTELLATION1'    =>array('id'=>'CONSTELLATION1'  ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'A', 'pos'=>'星座列表页',       'style'=>'焦点图1'),
    'CONSTELLATION2'    =>array('id'=>'CONSTELLATION2'  ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'B', 'pos'=>'星座列表页',       'style'=>'焦点图2'),
    'CONSTELLATION3'    =>array('id'=>'CONSTELLATION3'  ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'星座列表页',       'style'=>'焦点图3'),
    'CONSTELLATION4'    =>array('id'=>'CONSTELLATION4'  ,'width'=>640, 'height'=>360, 'size'=>200, 'fontsize'=>28,  'priority'=>'C', 'pos'=>'星座列表页',       'style'=>'焦点图4'),
    'CONSTELLATION5'    =>array('id'=>'CONSTELLATION5'  ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'A', 'pos'=>'星座列表页',       'style'=>'信息流(图+文)1'),
    'CONSTELLATION6'    =>array('id'=>'CONSTELLATION6'  ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'星座列表页',       'style'=>'信息流(图+文)2'),
    'CONSTELLATION7'    =>array('id'=>'CONSTELLATION7'  ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'星座列表页',       'style'=>'信息流(图+文)3'),
    'CONSTELLATION8'    =>array('id'=>'CONSTELLATION8'  ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'星座列表页',       'style'=>'信息流(图+文)4'),
    'CONSTELLATION9'    =>array('id'=>'CONSTELLATION9'  ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'星座列表页',       'style'=>'信息流(图+文)5'),
    'CONSTELLATION10'   =>array('id'=>'CONSTELLATION10' ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'星座列表页',       'style'=>'信息流(图+文)6'),
    'CONSTELLATION11'   =>array('id'=>'CONSTELLATION11' ,'width'=>154, 'height'=>110, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'星座列表页',       'style'=>'信息流(图+文)7'),
    'CONSTELLATION12'   =>array('id'=>'CONSTELLATION12' ,'width'=>196, 'height'=>130, 'size'=>40,  'fontsize'=>48,  'priority'=>'B', 'pos'=>'星座列表页',       'style'=>'信息流(图+文)8'),
);
return $config;

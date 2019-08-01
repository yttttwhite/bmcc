<?php
$config = array();
$config['partner'] = "zhejiang";
//数据库配置
//ADP
$config['db']['1']['dbhost']    = '112.124.46.89:33966';
$config['db']['1']['dbuser']    = 'root';
$config['db']['1']['dbpw']      = 'mypassword2qq';
$config['db']['1']['dbcharset'] = 'utf8';
$config['db']['1']['pconnect']  = '0';
$config['db']['1']['dbname']    = 'adp';
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
    10000   =>array('name'=>"系统",   'auth_list'=>'system,admin,ad,dpc,financial,stat,user,media,shenhe,dc,dsp,audient'),
    1000    =>array('name'=>"管理员",  'auth_list'=>'admin,ad,dpc,financial,stat,dc,shenhe,dsp'),
    11      =>array('name'=>"客服",   'auth_list'=>'ad,dpc,financial,stat,dc,dsp'),
    12      =>array('name'=>"客户经理", 'auth_list'=>'stat,dc,dsp'),
    13      =>array('name'=>"广告商",  'auth_list'=>'ad,dsp'),
    14      =>array('name'=>"运维",   'auth_list'=>'it'),
);
$config['auth'] = array(
    'ad'        =>'广告管理',
    'dpc'       =>'DPC管理',
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

//start：可配置项默认值
$config['log'] = false;
$config['theme'] = "default";
$config['logo'] = "/assets_admin/images/logo/logo_bcdata_2.png";
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
$config['version']['dsp']['people'] = 1;    //人群管理
$config['version']['stuff']['shenhe'] = 1;    //素材需要审核
$config['version']['crm']['display'] = 0;
$config['version']['report']['stat'] = 1;
$config['version']['partner'] = "jiangsu";
$config['version']['version'] = $version[1];    //系统版本
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
return $config;
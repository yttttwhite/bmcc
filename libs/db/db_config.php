<?php
/*
 * 数据库配置
 */
$db_config = array();
//数据库配置文件-1
$db_config['db']['1']['dbhost'] = '112.124.46.89:33966';
$db_config['db']['1']['dbuser'] = 'root';
$db_config['db']['1']['dbpw'] = 'mypassword2qq';
$db_config['db']['1']['dbcharset'] = 'utf8';
$db_config['db']['1']['pconnect'] = '0';
$db_config['db']['1']['dbname'] = 'crm';
$db_config['db']['1']['tablepre'] = 'crm_';
//数据库配置文件-2
/*
$db_config['db']['2']['dbhost'] = '112.124.46.89:33966';
$db_config['db']['2']['dbuser'] = 'root';
$db_config['db']['2']['dbpw'] = 'mypassword2qq';
$db_config['db']['2']['dbcharset'] = 'utf8';
$db_config['db']['2']['pconnect'] = '0';
*/
$db_config['db']['2']['dbname'] = 'rmc';
$db_config['db']['2']['tablepre'] = 'rmc_';
//数据库映射关系
$db_config['db']['map']=array(
                                'interest'=>'2',
                                'interest_report'=>'2',
                                'interest_summary'=>'2'
 
                            );

return $db_config;
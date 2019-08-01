<?php
require_once dirname(__FILE__).'/DbException.class.php';
require_once dirname(__FILE__).'/discuz_database.php';
require_once dirname(__FILE__).'/db_driver_mysql.php';
require_once dirname(__FILE__).'/db_driver_mysql_slave.php';

$crmDbConfig = SConfig::getConfigArray(ROOT_CONFIG."/config.php",'db');
class discuzDB extends discuz_database {}
//discuzDB::init("db_driver_mysql", $crmDbConfig['db']);

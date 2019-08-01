<?php


/**
 * Autogenerated by Thrift Compiler (0.9.1)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


final class OrderPolicy {
  const MEDIA_BUYER = 1;
  const HERD_BUYER = 2;
  const BACKBONES_BUYER = 3;
  static public $__names = array(
    1 => 'MEDIA_BUYER',
    2 => 'HERD_BUYER',
    3 => 'BACKBONES_BUYER',
  );
}

final class OperType {
  const ADD = 1;
  const DEL = 2;
  const MOD = 3;
  static public $__names = array(
    1 => 'ADD',
    2 => 'DEL',
    3 => 'MOD',
  );
}

final class AdSource {
  const INNER = 1;
  const YAXIN = 2;
  const ZHIZHEN = 3;
  const DSPAD = 4;
  static public $__names = array(
    1 => 'INNER',
    2 => 'YAXIN',
    3 => 'ZHIZHEN',
    4 => 'DSPAD',
  );
}

final class AdStatus {
  const RUNNING = 1;
  const STOPPED = 2;
  const EXPIRED = 3;
  const DELETED = 4;
  const FROZEN = 5;
  static public $__names = array(
    1 => 'RUNNING',
    2 => 'STOPPED',
    3 => 'EXPIRED',
    4 => 'DELETED',
    5 => 'FROZEN',
  );
}

final class AuditStatus {
  const READY_TO_AUDIT = 1;
  const PASS_TO_AUDIT = 2;
  const FAILED_TO_AUDIT = 3;
  static public $__names = array(
    1 => 'READY_TO_AUDIT',
    2 => 'PASS_TO_AUDIT',
    3 => 'FAILED_TO_AUDIT',
  );
}

final class AdChargeType {
  const CPC = 1;
  const CPM = 2;
  const CPD = 3;
  const CPT = 4;
  static public $__names = array(
    1 => 'CPC',
    2 => 'CPM',
    3 => 'CPD',
    4 => 'CPT',
  );
}

final class CurrencyType {
  const RMB = 1;
  const EUR = 2;
  const USA = 3;
  static public $__names = array(
    1 => 'RMB',
    2 => 'EUR',
    3 => 'USA',
  );
}

final class NetWorkType {
  const HARD_LINK = 1;
  const MOBILE_LINK = 2;
  static public $__names = array(
    1 => 'HARD_LINK',
    2 => 'MOBILE_LINK',
  );
}

final class FlowSrc {
  const all = 0;
  const tanx = 1;
  const google = 2;
  const baidu = 3;
  const sax = 4;
  const tencent = 5;
  const youku = 6;
  const self_media = 7;
  static public $__names = array(
    0 => 'all',
    1 => 'tanx',
    2 => 'google',
    3 => 'baidu',
    4 => 'sax',
    5 => 'tencent',
    6 => 'youku',
    7 => 'self_media',
  );
}

final class PlanStatus {
  const RUNNING = 1;
  const STOPPED = 2;
  const EXPIRED = 3;
  const DELETED = 4;
  const FROZEN = 5;
  const NOBUDGET = 6;
  const TERMINATED = 7;
  static public $__names = array(
    1 => 'RUNNING',
    2 => 'STOPPED',
    3 => 'EXPIRED',
    4 => 'DELETED',
    5 => 'FROZEN',
    6 => 'NOBUDGET',
    7 => 'TERMINATED',
  );
}

final class ReleaseType {
  const AD_BRAND = 10;
  const AD_GENERAL = 20;
  const AD_FINANCE = 30;
  const AD_GAME = 40;
  const AD_LONG_TAIL = 50;
  const AD_SPECIAL = 60;
  const AD_SURPLUS = 100;
  const AD_INNERSUPPORT = 101;
  static public $__names = array(
    10 => 'AD_BRAND',
    20 => 'AD_GENERAL',
    30 => 'AD_FINANCE',
    40 => 'AD_GAME',
    50 => 'AD_LONG_TAIL',
    60 => 'AD_SPECIAL',
    100 => 'AD_SURPLUS',
    101 => 'AD_INNERSUPPORT',
  );
}

final class AdPriority {
  const PRIORITY_HIGHEST = 1;
  const PRIORITY_HIGH = 2;
  const PRIORITY_BASIC = 3;
  const PRIORITY_LOW = 4;
  const PRIORITY_LOWEST = 5;
  const PRIORITY_LONG_TAIL = 6;
  static public $__names = array(
    1 => 'PRIORITY_HIGHEST',
    2 => 'PRIORITY_HIGH',
    3 => 'PRIORITY_BASIC',
    4 => 'PRIORITY_LOW',
    5 => 'PRIORITY_LOWEST',
    6 => 'PRIORITY_LONG_TAIL',
  );
}

final class StuffType {
  const AD_IMAGE = 1;
  const AD_FLASH = 2;
  const AD_FLASH_DYNAMIC = 3;
  const AD_TEXT = 4;
  const AD_WORDCHAIN = 5;
  const AD_VIDEO = 6;
  const AD_IFRAME = 7;
  const AD_JS = 8;
  const AD_HTML = 9;
  const AD_200_OK = 10;
  const AD_IFRAME_UNTRUST = 11;
  const AD_IFRAME_HTML = 16;
  const AD_LINGJI_DYNAMIC = 17;
  static public $__names = array(
    1 => 'AD_IMAGE',
    2 => 'AD_FLASH',
    3 => 'AD_FLASH_DYNAMIC',
    4 => 'AD_TEXT',
    5 => 'AD_WORDCHAIN',
    6 => 'AD_VIDEO',
    7 => 'AD_IFRAME',
    8 => 'AD_JS',
    9 => 'AD_HTML',
    10 => 'AD_200_OK',
    11 => 'AD_IFRAME_UNTRUST',
    16 => 'AD_IFRAME_HTML',
    17 => 'AD_LINGJI_DYNAMIC',
  );
}


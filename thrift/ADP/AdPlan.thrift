namespace java com.adp.java

include "Shared.thrift"
include "AdInfoService.thrift"
include "AdGroup.thrift"
include "StuffInfo.thrift"

struct AdPlanType
{
    1:      i32                type_id,
    2:      string             type_name,
    3:      string             cate_name
}

struct AdPlan
{
    1: i32  plan_id,
    2: string plan_name,
    3: i32 uid,
    4: string vocation,
    5: Shared.AdChargeType billing_type=Shared.AdChargeType.CPC,
    6: double budget,
    7: Shared.CurrencyType currency=Shared.CurrencyType.RMB,
    8: i32 start_date,
    9: i32 end_date,
    10: i32 is_date_limit,
    11: i32 day_max,
    12: string adtime,
    13: Shared.PlanStatus enable=Shared.PlanStatus.RUNNING,
    14: i32 ctime,
    15: i32 mtime,
    16: i32 pop_result, #投放结果,0:投放完成，1：未完成
    17: Shared.ReleaseType release_type=Shared.ReleaseType.AD_GENERAL,
    18: i32 smooth_control,#平滑控制，0：平滑控制，1：平均投放，2：不限制
    19: Shared.AdPriority priority=Shared.AdPriority.PRIORITY_BASIC,
    20: Shared.NetWorkType net_type=Shared.NetWorkType.HARD_LINK,
    21: double cpm,
    22: double daily_consum,
    23: double real_consum,
    24: double cost,
    25: double cpc,
    26: i32 colum1,
    27: string colum2,
    28: string media_name,
    29: i32 version,
    30: Shared.OrderPolicy order_policy=Shared.OrderPolicy.MEDIA_BUYER,  #订单策略
    31: i32 all_day_or_not, #0:intervals, 1:allday
    32: string intervals,
    33: i32 time_interval,
    34: i32 day_num,
    35: i32 show_num,
    36: i32 type_id,
    37: i32 verified_or_not, #0:no, 1:yes
    38: string type_name,
    39: i32 frequency_control=-1, #频次控制 frequency_control（默认-1） -1：不限，0：ip控制，1：cookie控制
    40: i32 day_cpm=-1, #每日投放CPM上限，-1无限制
    41: i32 day_cpc=-1, #每日投放CPC上限，-1无限制
    42: string user_name, #用户名
    43: i32 total_cpm=-1, #计划排期内投放CPM上限，-1无限制
    44: i32 total_cpc=-1, #计划排期内投放CPC上限，-1无限制
    45: string last_operator="Unknown",
    46: i32 platform=1,#广告计划投放平台，1=>TA；2=>TANX；后面有平台再加
    47: i32 ad_pos_id, #广告位id
    48: double ctr_click_rate,#保底点击率
    49: i32 bind_id, #绑定广告主id
    50: double setting_price, #位置定价
    51: double cpt, #cpt计费
    52: i32 total_cpt, #cpt天数上线
    53: double total_rmb,#总金额
    54: string tag_identification, #标签标识
    55: Shared.AdSource adsource = Shared.AdSource.INNER, #广告来源 1 内部 2 亚信 3 直真 4 外部dsp广告
    56: i32 contract_type, #合同类型，1:竞价 2:合约
    57: i32 unit_id,	#北京移动，单价id，合同扣钱用作
    58: i32 contract_id,    #合同id
}

struct AdDetail
{
    1: list<AdInfoService.AdInfo> adInfos,
    2: AdGroup.AdGroup adGroups,
    3: list<StuffInfo.StuffInfo> stuffs,
    4: AdPlan adPlan,
    5: string username
}

struct GroupResponse {
    1: i32 totalSize,
    2: i32 currentSize,
    3: i32 pageSize,
    4: i32 pageNumber,
    5: list<AdPlan> data
}

struct AdPlanResponse {
    1: i32 totalSize,
    2: i32 currentSize,
    3: i32 pageSize,
    4: i32 pageNumber,
    5: list<AdPlan> data
}

service AdPlanService
{
    #返回uid列表下的所有状态为st的广告 uid为空时返回所有广告主的
    GroupResponse getGroupByStatus(1:list<i32> uid, 2:Shared.AuditStatus st, 3:i32 pageSize, 4:i32 pageNumber); 
    
    AdPlanResponse getAdPlanByUserid(1:i32 userid, 2:i32 status, 3:i32 pageSize, 4:i32 pageNumber); // status 为负数时表示不限制，取所有status
    
    i32 addAdPlan(1: AdPlan adPlan);
    
    i32 delAdPlanById(1: i32 plan_id);
    
    i32 updateAdPlanStatus(1: i32 plan_id, 2: Shared.PlanStatus status);
    
    
    i32 updateAdPlan(1: AdPlan adplan);
    
    //根据广告计划id获取广告组信息
    AdPlan getAdPlanByPid(1: i32 plan_id);
    
    list<AdPlanType> getAllAdPlanTypes();

    //根据广告主id获取所有广告计划名称
    list<AdPlan> getAdPlansByUid(1: i32 uid);

    //根据bind_id获取所有广告计划
    list<AdPlan> getAdPlansByBindid(1:i32 bindid);

    i32 updateVerifiedStatus(1: i32 plan_id, 2: i32 verified_status, 3: string operator);
    
}

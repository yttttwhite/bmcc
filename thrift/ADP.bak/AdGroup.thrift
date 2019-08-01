namespace java com.adp.java

include "Shared.thrift"

struct AdGroupPolicy
{
    1: i32 id,
    2: i32 group_id,
    3: i32 herd_id,
    4: double bid_price
}

struct AdGroupHost
{
    1: i32 id;
    2: string host,
    3: i32 group_id,
    4: double bid_price
}

struct AdGroup{ 
    1: i32 group_id,
    2: string name,
    3: i32 uid,
    4: i32 version,#版本号
    5: i32 plan_id,
    6: i32 start_date,
    7: i32 end_date,
    8: i32 freq,
    9: i32 is_first_page,
    10: string include_host,
    11: string exclude_host,
    12: string area_value,
    13: string area_lable,
    14: Shared.PlanStatus enabled=Shared.PlanStatus.RUNNING,
    15: i32 ctime,
    16: i32 mtime,
    17: Shared.NetWorkType media_type=Shared.NetWorkType.HARD_LINK,
    18: double bid_price,
    19: Shared.FlowSrc flow_src=Shared.FlowSrc.tanx,
    20: i32 colum1,
    21: string colum2,
    22: string media_name,
    23: list<AdGroupPolicy> policys,
    24: list<AdGroupHost> hosts,
    25: i32 time_interval,
    26: i32 day_num,
    27: i32 show_num,
    28: string host_set_object,
    29: string include_useragent,
    30: string include_useragent_set_object,
    31: string sp_list, #局点号，多个用逗号分开
    32: string keyword_list, #关键词，多个用逗号分开
    33: i32 mobile,
    34: string exchanges,
    35: string include_ip, #白名单IP，多个逗号,分号或回车分隔
    36: string exclude_ip, #白名单IP，多个逗号,分号或回车分隔
    37: string include_adsl, #白名单adsl，多个逗号,分号或回车分隔
    38: string exclude_adsl, #白名单adsl，多个逗号,分号或回车分隔
    39: i32 usertype, #0是all， 1是adsl， 2是ip
    40: list<string> usertags,
    41: list<i32> domain_group_id, #域名分组ID
    42: string channels,     #广告组投放的channel列表
    43: list<string> base_props,  #基础属性
    44: list<string> residence_locations, #居住地
    45: list<string> work_locations,  #工作地
}
struct AdGroupResponse {
    1: i32 totalSize,
    2: i32 currentSize,
    3: i32 pageSize,
    4: i32 pageNumber,
    5: list<AdGroup> data
}
service AdGroupService{

    AdGroupResponse getAdGroupByPlanid(1:i32 planid, 2:i32 status, 3:i32 pageSize, 4:i32 pageNumber); // status 为负数时表示不限制，取所有status
    
    //添加广告组
    i32 addAdgroup(1: AdGroup adGroup);
    
    //删除广告组
    i32 delAdGroup(1: i32 group_id);
    
    //根据group_id查询广告组
    AdGroup findAdGroupById(1: i32 group_id);
    
    //根据字符串类型属性查询AdGroup信息
    list<AdGroup> findAdGroupByInt(1: map<string, i32> int_params);
    
    //根据广告组id更新广告组状态
    i32 updateStatusByGid(1: i32 group_id, 2: Shared.PlanStatus status);
    
    i32 updateAdGroup(1: AdGroup adGroup);
}


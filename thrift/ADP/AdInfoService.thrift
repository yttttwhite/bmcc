namespace java com.adp.java

include "Shared.thrift"

struct AdInfo{
    1: i32 adid,
    2: string adname,
    3: i32 uid,
    4: i32 group_id,
    5: i32 plan_id,
    6: i32 has_text,
    7: i32 width,
    8: i32 height,
    9: string show_js,
    10: string click_js,
    11: i32 approvaldate,
    12: Shared.PlanStatus play_status=Shared.PlanStatus.RUNNING,
    13: Shared.NetWorkType media_type=Shared.NetWorkType.HARD_LINK,
    14: i32 ctime,
    15: i32 mtime,
    16: double ad_price,
    /**
      forms of advertisement: view type
      0x01 Popup Browser
      0x02 Embedded advertisement
      *0x03 Embedded advertisement && Popup Browser
      0x04 Super Pop Under
      0x08 jump ad(Redirect advertising)
      0x10 jump ad(DPC)
    */
    17: i32 view_type,
    18: i32 colum1,
    19: string colum2,
    20: string media_name,   #媒体名称(最好用域名中可唯一标示的单词标示)
    21: i32 version,          #版本号
    22: i32 time_interval,
    23: i32 day_num,
    24: i32 show_num
}
struct AdInfoResponse {
    1: i32 totalSize,
    2: i32 currentSize,
    3: i32 pageSize,
    4: i32 pageNumber,
    5: list<AdInfo> data
}
service AdInfoService{
    
    //根据广告组id查找广告
    // status / play_status 为 4 的广告是 已删除状态 当 status不为 4 时，不会取出已删除广告，即使status传的是 -1， 也不会取出为4的广告
    // 当status为4 时，会取出所有已删除广告。
    AdInfoResponse getAdInfoByGroupid(1:i32 groupid, 2:i32 status, 3:i32 pageSize, 4:i32 pageNumber); // status 为负数时表示不限制，取所有status
    
    
    //根据广告id获取广告信息
    AdInfo getAdInfoById(1: i32 adid);
    
    //更新广告信息
    i32 updateAdInfo(1: AdInfo adInfo);
    
    //根据广告id删除广告（伪删除，并不是将广告从数据库删除，只是将其状态置为不可用）
    i32 delAdInfoById(1: i32 adid);
    
    //添加广告
    i32 addAdInfo(1: AdInfo adInfo);
    
    //根据广告组id更新广告组下广告状态
    i32 updateStatusByGid(1: i32 group_id, 2: Shared.PlanStatus status);
    
    //根据uid查找广告
    list<AdInfo> findAdInfoByUid(1: i32 uid);
    
    //根据广告组id查找广告
    list<AdInfo> findAdInfoByGid(1: i32 group_id);
    
    //根据广告计划id查找广告
    list<AdInfo> findAdInfoByPid(1: i32 plan_id);
    
}

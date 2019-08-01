namespace java com.adp.java

include "Shared.thrift"


struct MediaPrice{
    1:      string              media,                   #媒体host
    2:      double              price                   #价格
}

struct PolicyData
{
    1:      i32                policy_id,               #策略id
    2:      i32                adid,                    #广告id
    3:      double             bid_price,               #竞价价格
    4:      string             dsp_name                #媒体名称（部署adp系统媒体名称） 
}

struct AdData
{
    1:     i32                 ad_id,                   #广告ID
    2:     Shared.ReleaseType  business_type=Shared.ReleaseType.AD_GENERAL,           #广告商业类型
    3:     i32                 width,                   #宽度
    4:     i32                 height,                  #长度
    /**
      forms of advertisement: view type
      0x01 Popup Browser
      0x02 Embedded advertisement
      *0x03 Embedded advertisement && Popup Browser
      0x04 Super Pop Under
    */
    5:     i32 viewtype,
    6:     Shared.AdPriority   priority=Shared.AdPriority.PRIORITY_BASIC,                #广告优先级
    7:     list<string>        blackurl,                #黑名单url,去除?后的参数
    8:     list<string>        whiteurl,                #白名单url,去除?后的参数
    9:     list<string>        regions,                 #地域列表(地域id列表)
   10:     list<Shared.FlowSrc>  acceptflows,             #可接受的流量来源, tanx和（或）google等
   11:     Shared.StuffType    creative_type=Shared.StuffType.AD_IMAGE,          #创意类型即素材类型
   12:     i32                 ad_category,            #广告行业分类
   13:     i32                 sensitive_category,     #广告敏感分类（传默认值0就可以）
   14:     string              click_through_url,      #点击广告跳转页面（写landing page就可以）
   15:     string              destination_url,        #最终广告跳转页面（写landing page就可以）
   16:     Shared.AdChargeType charge_type=Shared.AdChargeType.CPC,            #计费方式, 0:CPM, 1:CPC
   17:     double              charge_price,           #默认价格
   18:     i32                 is_general,             #是否普投（即不需要用户匹配）
   19:     list<MediaPrice>    media_price,            #需要按媒体精准投放的出价列表
   20:     string              sp_id,                  #属于哪家媒体
   21:     i32                 has_text,               #是否含有文本
   22:     string              params,                 #json格式的字符串, ki:vi是广告分析材的参数, 如: stuff:[{k1:v1,...}...]
   23:     i32                 time_interval,          #停投, 广告两次展示时间间隔
   24:     i32                 day_num,                #停投, 广告展示时长
   25:     i32                 show_num,               #停投, 广告展示次数
   26:     i32                 type_id,
   27:     string              show_js,
   28:     string              click_js,
   29:     i32                 is_first_page,           #广告位位置, 首屏, 非首屏
   30:     i32                 group_id,                #广告所在组id
   31:     double              budget=-1,               #平滑控制, 日预算, -1: 不限
   32:     i32                 plan_id,                 #广告所在计划id  
   33:     i32                 smooth_control,          #平滑控制, 0: 平滑控制; 1:平均投放; 2:不限制
   34:     i32                 frequency_control=-1,    #频次控制, -1: 不限, 0：ip控制, 1: cookie控制
   35:     i32                 day_cpm=-1,              #平滑控制, 日cpm, -1: 不限; > 0, 单位/千
   36:     i32                 day_cpc=-1,              #平滑控制, 日cpc, -1: 不限; > 0, 单位/个
   37:     string              user_agent,              #平台定向, 系统/平台/浏览器, 逗号隔开
   38:     string              sp_list,                 #运营商, 局点列表, 逗号隔开
   39:     i32                 viewtype4_ratio=0,       #背投,比例[0,100], 0不投, 100全投
   40:     i32                 viewtype8_ratio=0,       #跳转广告,比例[0,100], 0不投, 100全投
   41:     list<string>        terms={}  ,             # 广告的关键词
   42:     i32 mobile,
   43:     list<i32> exchanges,
   44:     i32 isdelay = 0,
   45:     list<string>        include_ip,                
   46:     list<string>        exclude_ip,                
   47:     list<string>        include_adsl,              
   48:     list<string>        exclude_adsl             
   49:     i32 usertype, #0是all， 1是adsl， 2是ip
   50:     list<string> usertags,
   51:     string intervals, #广告投放时间段
   52:     i32 view_position, #显示的位置
   53:     string view_time, #显示的时间
   54:     string webunion_org, #网盟组织
   55:     string webunion_text,#网盟展示文本
   56:     string title, #广告素材文字标题
   57:     string description, #广告素材文字内容描述
   58:     list<i32> domain_group_id,
   59:     list<string> channel_list, #广告投放的channel列表
   60:     string adname,   #广告名称
   61:     i32 webunion_switch, #是否使用网盟标志
   62:     list<string> base_props,  #基础属性
   63:     list<string> residence_locations, #居住地
   64:     list<string> work_locations,  #工作地
   65:     string icon_addr,   #图标地址
   66:     i32 icon_width,     #图标宽度
   67:     i32 icon_height,    #图标高度
   68:     string icon_mime_type,   #图标mime类型
   69:     string mime_type,   #素材mime类型
   70:     i32 duration,       #视频时长
   71:     i32 bitrate,        #视频比特率
   72:     i32 frame_rate,     #视频每秒帧数
   73:	   Shared.AdSource adsource=Shared.AdSource.INNER,	#广告来源
   74:     i32 contract_type,   #合同类型 1竞价，2合约
   75:     string deeplinkurl,   #deeplink url
   76:     i32 logo_width,	#logo宽度
   77:	   i32 logo_height,	#logo高度
   78:	   string logo_addr,    #logo地址
   79:	   i32 ad_action	#1下载类广告，2打开落地页

}


enum DataType
{
    RTB = 1,
    OAS = 2
}

struct AdVersion
{
    1:            i32               id,                    #id
    2:            i32               version,               #版本号
    3:            string            media_name,            #媒体名称，区分版本号的归属
    4:            DataType          dataType               #数据类型，用来区分版本号对应的数据是提供给RTB还是OAS
}

service AdDataService
{
    //获取所有有效广告计划下所有有效广告组中的有效广告
    list<AdData> getAllAdData();
    list<AdData> getApkAd();
    list<AdData> getAllAdDatas();
    list<AdData> getAllAdDataWithSp(1:i32 spid);

    //获取dpc有效广告组中的有效广告
    list<AdData> getDpcAdData();
    list<AdData> getSpDpcAdData(1:i32 spid);

    //获取数据版本号
    i32 getAdDataVersion();
    
    //获取所有广告 getAllAdData + getDpcAdData
    list<AdData> getAllAd();
    
    //更新数据版本号
    i32 updateDataVersion(1: i32 module_id);
    
    //获取所有的policy数据
    i32 getAllPolicyData();
    
    //获取所有频道标识
    list<string> getAllChannels();
}

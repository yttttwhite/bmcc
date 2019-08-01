namespace cpp Baic

struct SlotSize
{
    1:required i32 height;
    2:required i32 width;
}

struct DSPInfo
{
    1:required i32      dsp_id;         #dsp编号
    2:optional string   dsp_cms_url;
    3:required string   dsp_bid_url;
    4:optional string   dsp_notice_url;
    5:required i32      dsp_max_qps;    #dsp qps, -1:不限制 0:不投放

    6:required i32      status;         #暂停、停止
    7:required i32      enabled;        #审核状态
    8:required string   token;

    9:optional i32      _inserttime;    # 时间戳形式
    10:optional i32     _updatetime;

    # 策略相关字段
    11:optional list<SlotSize>     access_slot_size;    #允许推广位尺寸(200x300 ...)
    12:optional list<i32>          access_view_types;   #允许推广位类型（固定、弹窗、背投...)
    13:optional list<i32>          access_view_screens; #允许推广位屏数(首屏、一屏...)
    14:optional list<i32>          access_site_types;   #允许网站类型（娱乐、影视、音乐、软件、数码...)
    15:optional list<string>       exclude_urls;        #屏蔽网址

    # 程序内部使用
    16:optional string   _bid_ip;    #dps竞价ip
    17:optional string   _bid_host;  #dsp竞价的host
    18:optional i32      _bid_port;  #dsp竞价端口号
    19:optional string   _bid_path;  #dsp竞价路径
}


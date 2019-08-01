#业务系统没有使用

namespace java com.adp.java

include "Shared.thrift"

struct AdStuff{

    1: i32 ad_stuff_id,
    2: i32 uid,
    3: i32 plan_id,
    4: i32 group_id,
    5: Shared.AdStatus status,
    6: string name,
    7: string media_name,
    8: Shared.NetWorkType media_type,
    9: Shared.StuffType type,
    10: i32 width,
    11: i32 height,
    12: string title,
    13: string description,
    14: string image_url,
    15: string thumb_url,
    16: string crop_url,
    17: string landing_page,
    18: i32 ctime,
    19: i32 mtime,
    20: i32 size,
    21: i32 version,
    22: i32 has_text,
    23: string show_js,
    24: string click_js,
    25: i32 apply_date,
    26: i32 column1,
    27: string column2,
    28: string text     #广告内容，当type为如下值时有意义：AD_JS，JS代码，包含script标签 AD_HTML，HTML代码 AD_TEXT，文本代码 AD_VIDEO，视频嵌入代码
    
}

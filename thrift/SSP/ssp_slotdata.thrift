namespace java com.adp.java

struct WebSite
{
    1:required    i32               website_id,
    2:required    string            website_name,
    3:required    i32               media_id,
    4:required    string            media_name,
    5:required    i32               uid,
    6:required    string            description,
    7:required    string            website_url, 
	8:required    i32               status;
   17:optional    string            insert_time,            #"2013-12-05 20:43:52"
   18:optional    string            update_time,            #"2013-12-05 20:43:52" 
}

struct SspSlotAdnetwork
{
    1:required    i32               slot_id,
	2:required    i32               network_id,
    3:required    string            network_name,          #新加的
    4:required    double            network_ratio,
    5:required    string            network_code	
}

struct SlotData
{
    1:required    i32               slot_id,
    2:required    string            slot_name,
    3:required    i32               uid,
    4:required    i32               website_id,
    5:required    i32               width,
    6:required    i32               height,
    7:optional    i32               style, 
    8:optional    string            url, 
    9:required    i32               view_screen, 
   10:required    i32               min_price, 
   11:required    i32               priority,
   12:optional    i32               creative_type,
   13:optional    string            ad_list,                #用逗号分开的多个默认广告ID
   14:optional    i32               status, 
   15:optional    i32               ad_type,
   16:optional    string            comment, 
   17:optional    string            insert_time,            #"2013-12-05 20:43:52"
   18:optional    string            update_time,            #"2013-12-05 20:43:52" 
   19:required    list<SspSlotAdnetwork>   ad_network,      #流量分配
   20:optional    list<i32>         channel,
   21:optional    list<string>      ban_urls,
   22:optional    list<i32>      ban_dsp,                #屏蔽的DSP
   23:optional    list<i32>         ban_category,            #屏蔽的分类
   24:optional    i32               view_type,
   25:required    double            priority_ratio
}

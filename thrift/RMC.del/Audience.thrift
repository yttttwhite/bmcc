struct Website {
1: i32 wid;
2: string name;
3: string domain_name;
4: bool is_working;//是否被启用
5: string create_time;
6: string code;
7: i32 uid;
}

struct Crowd {
    1: i32 cid;
    2: string name;
    3: i32 status;//人群状态
    4: i32 number;
    5: i32 valid_time;
    6: string create_time;
    7: i32  wid;
}

service AudienceService {
//根据用户id获取网站列表，后续可能会加上查询条件
list<Website> getWebsiteByUserId(1: i32 uid),
//新建网站
i32 createWebsite(1: Website web),
//修改网站信息
i32 updateWebsite(1: Website web),
//删除网站信息，不直接删除，将有效位复位
i32 deleteWebsiteByWid(1: i32 wid),
//根据webid获取网站信息
Website getWebsite(1: i32 wid),
//根据网站id取得人群列表
list<Crowd> getCrowdByWebsiteId(1: i32 wid),
//新建人群
i32 createCrowd(1: Crowd crd),
//修改人群信息
i32 updateCrowd(1: Crowd crd),
//删除人群，不直接删除，将人群有效位复位
i32 deleteCrowdByCid(1:i32 cid),
}

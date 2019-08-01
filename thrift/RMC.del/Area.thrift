#地域
struct Area {
    1:string id;
    2:string parentId;
    3:string parentName;
    4:string areaName;
    5:i64 areaLevel;
}

struct AreaIdName{
    1:string id;
    2:string area_name;
    3:i32    level;
    4:string region_name;
}

service AreaService {
    //返回所有的地域信息，参数0为中文，1为英文，2为西班牙语，不带参数默认为中文
    list<Area> getAllArea(1:i32 language),
    //根据地域ID返回一级地域简称，业务系统调用
	string getShortNameById(1:string id),
    //根据地域ID返回所有的二级物理地域
    list<map<string, string>> getAllPhySonAreasByParentId(1:string parent_id),
    //根据地域名称返回所有的二级物理地域
    list<map<string, string>> getAllPhySonAreasByParentName(1:string parent_id),
    //以两级的形式返回所有的地域信息，其中第一个节点代表省份信息，其后所有节点代表该省份下所有市的信息
    list<list<AreaIdName>> getAllIdName();
}

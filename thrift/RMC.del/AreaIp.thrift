#地域IP映射表
struct AreaIp {
    1:i64 id;
    2:string area_id;
    3:string area_name;
    4:string start_ip;
    5:string end_ip
}

service AreaIpService {
    list<AreaIp> getAllAreaIps(), //返回所有的地域IP映射数据
    string getIdByAreaIp(1:string ip) //根据地域ip返回对应的地域id
}

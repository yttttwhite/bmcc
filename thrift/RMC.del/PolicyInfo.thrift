struct PolicyInfo {
    1:i64 wid;
    2:i64 cid;
    3:i32 days;
    4:string url
}

service PolicyInfoService{
    //返回所有的策略信息
    list<PolicyInfo> getAllPolicy(),
}

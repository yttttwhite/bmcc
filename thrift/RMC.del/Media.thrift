#媒体
struct Media {
    1:i64 id;
    2:string name;
    3:i64 level;
    4:i64 parentId;
}


struct Host {
    1:i64 id;
    2:i64 parent_id;
    3:string name;
    4:string url;
    5:i64 media_id;
    6:i32 level;
    7:string traffic;
    8:string modified;
    9:i32 is_valid;
}


struct Adplace{
    1:i64  id;
    2:string name;
    3:i32 width;
    4:i32 high;
    5:i64 traffic;
    6:string rejected_ad_type;
    7:string rejected_dsp;
    8:i32 location;
    9:i32 style;
    10:i64 host_id;
}

struct MediaHostAd{
    1:i64 id;
    2:string name;
}

service MediaService {
   list<Media> getAllMediaInfo(),//获得所有媒体列表
   list<Media> getAllFirstMediaInfo(), //获取所有一级媒体列表
   list<Media> getAllSecondMediaInfo(),//获得所有二级媒体列表
   Media getMediaInfoById(1:i64 id), //根据id获得元素
   list<Media> getAllSecondMediaInfoByFirstId(1:i64 id),//获得 指定一级媒体下的所有二级媒体信息列表

   list<Host> getAllHostInfo(),   //获得所有的host信息
   Host getHostInfoById(1:i64 id), //根据id获得一条host记录


//   list<Host> getHostByUrl(1:string url),//模糊匹配url,获得host列表
//   Host getHost(1:string url), //精确匹配url查出对应host信息
//   i32 addHost(1:Host host); //添加或更新一个主机主机记录
//   list<string> getNoCateHost(); //返回所有没有标记的host列表

    list<Adplace> getAllAdplaceInfo();//获取所有广告位信息
    list<MediaHostAd> getAllInfo();//获取所有的媒体信息。。何涛用
}

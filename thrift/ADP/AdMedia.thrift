namespace java com.adp.java

include "Shared.thrift"


struct Media{
	1: i32 id, #媒体id
	2: string media_name,
	3: string identification, #媒体标识
	4: string media_type,
	5: i32 career_type, #行业类型
	6: string reference_addr, #引流地址
	7: i32 media_status, #媒体状态 0关 1开
	8: string comment, #媒体信息备注
	9: string media_account, #媒体账号
	10: string public_key, #媒体公钥
	11: string private_key, #媒体公钥
	12: string contact_name, #联系人用户名
	13: string contact_mobile, #电话
	14: string contact_email, 
	15: string contact_address,
	16: string contact_zipcode, #邮编
	17: string contact_website, #公司网址
	18: string contact_comment, #联系人备注
	19: i32 create_time, 
	20: i32 alter_time,
	21: i32 creator_id,
	22: string available_uid #媒体支持的uid列表
}

struct Channel{
	1: i32 channel_id,
	2: i32 media_id,
	3: string channel_name,
	4: string channel_identification, #频道标识
	5: i32 channel_status, #频道状态 0关1开
	6: string channel_comment #频道备注
	7: i32 creator_id,
	8: i32 create_time,
	9: i32 alter_time
}

struct AdPosition{
	1: i32 id,
	2: i32 channel_id,
	3: string position_name, #广告位名称
	4: string position_identification, #广告位标识
	5: i32 first_screen, #是否支持首屏
	6: string stuff_type, #支持素材的类型
	7: i32 width, #素材宽度
	8: i32 height, #素材高度
	9: double cpm, #展示单价cpm
	10: double cpc, #展示单价cpc
	11: i32 status, #是否启用 0否1是
	12: string position_comment, #备注
	13: i32 create_time, #创建时间
	14: i32 alter_time, #编辑时间
	15: i32 creator_id, #创建者id
	16: i32 media_id, #媒体id
	17: double cpt,
	18: string tag_identification,
	19: i32 plan_id,	#独占广告位id
}


service AdMediaService{
	//获取所有的media
	list<Media> getAllMedia();
	
	//根据id获取media信息
	Media getMediaById(1: i32 id)
	
	//新增媒体
	i32 addMedia(1: Media media);
	
	//更新媒体信息
	i32 updateMedia(1: i32 id,2: Media media);
	
	//获取所有的频道
	list<Channel> getAllChannel();
	
	//根据id获取频道
	Channel getChannelById(1: i32 id);
	
	//新增频道
	i32 addChannel(1:Channel channel);
	
	//更新频道信息
	i32 updateChannel(1: i32 id,2: Channel channel);
	
	//获取所有的Position
	list<AdPosition> getAllPo();
	
	//根据id获取media信息
	AdPosition getPoById(1: i32 id)
	
	//新增广告位
	i32 addPosition(1: AdPosition position);
	
	//更新广告位信息
	i32 updatePosition(1: i32 id,2: AdPosition position);
	
	
	
}

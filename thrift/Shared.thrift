namespace java com.adp.java

enum OrderPolicy
{
    MEDIA_BUYER = 1,
    HERD_BUYER = 2,
    BACKBONES_BUYER = 3
}

enum OperType
{
    ADD = 1,
    DEL = 2,
    MOD = 3
}

//广告状态
enum AdStatus {
    //运行
    RUNNING = 1,
    
    //停止
    STOPPED = 2,
    
    //过期
    EXPIRED = 3,
    
    //删除
    DELETED = 4,
    
    //冻结
    FROZEN = 5
}

enum AuditStatus {
    //待审核
    READY_TO_AUDIT = 1,
    
    //审核通过
    PASS_TO_AUDIT = 2,
    
    //审核不通过
    FAILED_TO_AUDIT = 3
}

enum AdChargeType {
    //cpc
    CPC = 1,
    
    //cpm
    CPM = 2,
    
    //cpd
    CPD = 3,

    //cpt
    CPT = 4
}

enum CurrencyType {
    //人民币
    RMB = 1,
    
    //欧元
    EUR = 2,
    
    //美元
    USA = 3
}

enum NetWorkType {
    //固网
    HARD_LINK = 1,
    
    //移动网络
    MOBILE_LINK = 2
}

//流量来源
enum FlowSrc {
    all = 0,
    
    //淘宝
    tanx = 1,
    
    //google
    google = 2,
    
    //baidu
    baidu = 3,
    
    //新浪
    sax = 4,
    
    //tencent
    tencent = 5,
    
    //youku
    youku = 6,
    
    //自有媒体
    self_media
}

enum PlanStatus {

    //有效
    RUNNING = 1,
    
    //无效
    STOPPED = 2,
    
    //过期
    EXPIRED = 3,
    
    //删除
    DELETED = 4,
    
    //冻结
    FROZEN = 5,
    
    // 没预算
    NOBUDGET = 6
}

enum ReleaseType {

    //品牌广告
    AD_BRAND = 10,
    
    //普通
    AD_GENERAL = 20,
    
    //财经类
    AD_FINANCE = 30,
    
    //游戏类
    AD_GAME = 40,
    
    //长尾广告
    AD_LONG_TAIL = 50,
    
    //剩余类
    AD_SURPLUS = 100,
    
    //内部支撑
    AD_INNERSUPPORT = 101,
}

enum AdPriority{
    
    //最高
    PRIORITY_HIGHEST = 1,
    
    //高
    PRIORITY_HIGH = 2,
    
    //普通
    PRIORITY_BASIC = 3,
    
    //低
    PRIORITY_LOW = 4,
    
    //最低
    PRIORITY_LOWEST = 5,
	
    //长尾
    PRIORITY_LONG_TAIL = 6,
}

enum StuffType{
    
    AD_IMAGE = 1,  // 需要landing_page

    
    AD_FLASH = 2,  // 需要landing_page
    
    
    AD_FLASH_DYNAMIC = 3,   // 需要landing_page

    
    AD_TEXT = 4,  // 无需langding
    
    
    AD_WORDCHAIN = 5,  // 暂未实现
    
    
    AD_VIDEO = 6,  // 无需langding
    
    
    AD_IFRAME = 7,  // 不需要landing_page
    
    
    AD_JS = 8,  // 无需langding
    
    AD_HTML = 9  // 无需langding

    AD_200_OK = 10 //自定义200OK内容
    
    AD_IFRAME_UNTRUST = 11,

    AD_IFRAME_HTML = 16 //iframe展示原URL，同时内嵌广告
    
}

/*
enum AdType{
      //背投广告
      AD_BEITOU = 1,
      
      //贴片
      AD_TIEPIAN = 2,
      
      //退弹
      AD_TUITAN = 3,
      
      //前投
      AD_QIANTOU = 4,
      
      //播放器背景
      AD_BFBJ = 5,
      
      //视频贴片
      AD_SPTP = 6,
      
      //视频暂停
      AD_SPZT = 7,
      
      //视频浮层
      AD_SPFUCENG = 8,
      
      //嵌入式
      AD_QIANRU = 9,
      
      //通栏广告
      AD_TLGG = 10,
      
      //画中画
      AD_HZH = 11,
      
      //飞扬视频
      AD_FYSHIPIN = 12,
      
      //泰山压顶
      AD_TSYD = 13,
      
      //撕页广告
      AD_SYGG = 14,
      
      //文字链
      AD_WZL = 15,
      
      //图片内嵌
      AD_TPNQ = 16,
      
      //html/js代码
      AD_JSCODE = 17,
      
      //浮窗
      AD_FUCHUANG = 18,
      
      //标准浮窗
      AD_BZFC =19,
      
      //异形视窗
      AD_YXFC = 20,
      
      //覆层广告
      AD_FCGG = 21,
      
      //对联广告
      AD_DLGG = 22,
      
      //悬浮按钮
      AD_XFAN = 23,
      
      //弹窗
      AD_TANC = 24,
      
      //视频流
      AD_SPL = 25
}
*/


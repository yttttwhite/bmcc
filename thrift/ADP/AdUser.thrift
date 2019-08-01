namespace java com.adp.java

include "Shared.thrift"

enum AccountStatus
{
    NORMAL=1,
    FROZEN=2,
    ALL = -1
}

struct AdUser
{
    1: i32 uid,
    2: string user_name,
    3: string passwd,
    4: string cell_phone,
    5: i32 role_id,
    6: string address,
    7: string tel,
    8: string user_local,
    9: double account,
    10: string zip_code,
    11: i32 colum1,
    12: string colum2,
    13: i32 reg_time,
    14: string host,
    15: AccountStatus account_status=AccountStatus.NORMAL,
    16: i32 up_time,
    17: i32 creator_id,
    18: i32 type = 1, # 结算方式 0.admin 1.普通 2.CPM 3.CPC
    19: double diffrate = 0, # 差价率
    20: double supportfee = 0, # 技术支持费
    21: double cpm_charge = 0, # 按CPM结算时每千次点击价格
    22: double cpc_charge = 0 # 按CPC结算时每次点击价格
    23: string webunion_org, #网盟组织
    24: string webunion_text,#网盟展示文本
    25: i32 webunion_switch, #是否使用网盟标志
    26: string email,# 邮件
    27: Shared.AdSource source = Shared.AdSource.INNER, #用户来源 1 普通用户 2 亚信 3 直真平台 4 外部dsp
}

struct AccountFlow{
	1: i32 id, #日志编号
	2: i32 operator_id, #财务人员id
	3: i32 target_uid, #操作对象
	4: double operate_num, #操作金额
	5: i32 operate_code, #'操作码，1：充值；2：补差；3：减额'
	6: i32 source, #操作来源，1：手动；2：同步'
	7: i32 op_time, #操作时间
	8: double flow_money, #流水余额
	9: double history_money, #历史余额
	10: string note, #操作备注
	11: string business_id, #业务单号
	12: string contract_id, #合同编号
	13: string contract_file, #合同照片地址
}

struct UserBilling{
	1: i32 id, #账单id
	2: i32 uid, #用户id
	3: string user_name, #用户名称
	4: i32 charge_type, #结算方式 0.admin 1.普通 2.CPM 3.CPC 4 CPT
	5: double cpm_charge, 
	6: double cpc_charge, 
	7: double cpt_charge, 
	8: double cost, #账单花费
	9: i32 billing_date, #出账日期
}


service AdUserService
{
    //添加广告主
    i32 addAdUser(1: AdUser adUser);
    
    //更新广告主信息
    i32 updateAdUserInfo(1: AdUser adUser);
    
    //根据广告主id删除广告主
    i32 delAdUserById(1: i32 uid);
    
    //根据广告主id获取广告主 信息
    AdUser getAdUserById(1: i32 uid);
    
    //根据广告主id更新广告主状态
    i32 updateAdUserStatus(1: i32 uid, 2: AccountStatus status);    
    
    //获取当前登录用户添加的所有广告主
    list<AdUser> getAdUsersByCid(1: i32 creator_id, 2: AccountStatus account_status);
    
    AdUser getAdUserByName(1: string user_name);
    
    //添加一条流水记录
    i32 addOneRecord(1: AccountFlow accFlow);
    
}


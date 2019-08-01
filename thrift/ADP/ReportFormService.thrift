namespace java com.adp.java

include "Shared.thrift"
include "AdUser.thrift"
include "AdPlan.thrift"
include "AdGroup.thrift"
include "AdInfoService.thrift"


service ReportFormService{
    list<AdUser.AdUser> getAllAdUsers();
    
    list<AdPlan.AdPlan> getAllAdPlans();
    list<AdPlan.AdPlan> getAdPlansByUid(1: i32 uid);
    
    list<AdGroup.AdGroup> getAllAdGroups();
    list<AdGroup.AdGroup> getAdGroupsByPlanId(1: i32 plan_id);
    
    list<AdInfoService.AdInfo> getAllAdInfos();
    list<AdInfoService.AdInfo> getAdInfosByGroupId(1: i32 group_id);
    
    i32 updateAdUserStatus(1: i32 uid, 2: AdUser.AccountStatus status);
    i32 updateAdPlanStatus(1: i32 plan_id, 2: Shared.PlanStatus status);
    i32 updateAdGroupStatus(1: i32 group_id, 2: Shared.PlanStatus status);
    i32 updateAdInfoStatus(1: i32 adid, 2: Shared.PlanStatus status);

	
	
	i32 addOneBilling(1:AdUser.UserBilling userBilling);
    
    //根据uid和date查询账单
    AdUser.UserBilling getOneBilling(1: i32 uid, 2:i32 date);
    
    //根据uid查询账单
    list<AdUser.UserBilling> getBillingsByUid(1: i32 uid);
    
}
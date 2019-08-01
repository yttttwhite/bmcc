namespace java com.adp.java

include "Shared.thrift"
include "AdGroup.thrift"
include "AdPlan.thrift"
include "AdInfoService.thrift"

service StatusService{
    list<AdPlan.AdPlan> getAllAdPlans();
    
    list<AdGroup.AdGroup> getAllGroupsByPlanId(1: i32 plan_id);
    
    list<AdInfoService.AdInfo> getAllAdInfosByGroupId(1: i32 group_id);
    
    i32 updateAdPlanStatus(1: i32 plan_id, 2: Shared.PlanStatus status);
    
    i32 updateAdGroupStatus(1: i32 group_id, 2: Shared.PlanStatus status);
    
    i32 updateAdInfoStatus(1: i32 adid, 2: Shared.PlanStatus status)
}
namespace cpp Baic

include "ssp_slotdata.thrift"
include "ssp_userinfo.thrift"


struct AdxRequest
{
    1:required ssp_slotdata.SlotData slot_data,
    2:required ssp_userinfo.UserInfo user_info
}



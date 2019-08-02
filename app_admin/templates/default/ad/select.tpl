<h2>广告主选择</h2>
<div id="users_select" ></div>
<div id="adplans_select" class="selMenu"></div>
<div id="adgroups_select" class="selMenu"></div>
<script>
    var user_info = new Array();
    {foreach $user_info as $v}
        user_info.push({SJson::encode($v)});
    {/foreach}
    var dddata_user = new Array();
    var dddata_adplan = new Array();
    var dddata_adgroup = new Array();
   // dddata_user.push({
   //            text:"所有广告主",
   //            value:0,
   //            selected:false

   //         });
    dddata_adplan.push({
               text:"选择广告计划",
               value:0,
               selected:false

            });

    dddata_adplan.push({
               text:"选择广告组",
               value:0,
               selected:false

            });

    $.each(user_info,function(n,val){
                var cur_uid = {$cur_uid};
                var select_flag = null;
                cur_uid == val.uid ? select_flag=true:select_flag=false;
                dddata_user.push({
                        text:val.user_name,
                        value:val.uid,
                        selected:select_flag
                    });
            });                


    $("#users_select").ddslick({
       data:dddata_user,
       width:200,
       selectText:"广告主选择",
       onSelected:function(selectedData){
                   var para = {
                                   'uid':selectedData.selectedData.value,
                                   'start':"{$start}",
                                   'end':"{$end}"
                              };
 //                  report_dc("#chartShow",para);//hightchar
//                   getAreaReport("#list2",para);//table
    }})
</script>
<script>
    var user_info = new Array();
    {foreach $user_info as $v}
        user_info.push({SJson::encode($v)});
    {/foreach}
    var dddata = new Array();
    dddata.push({
               text:"所有广告主",
               value:0,
               selected:true

            });
    $.each(user_info,function(n,val){
                dddata.push({
                        text:val.user_name,
                        value:val.uid,
                        selected:false
                    });
            });                


    $("#users_select").ddslick({
       data:dddata,
       width:200,
       selectText:"广告主选择",
       onSelected:function(selectedData){
                 //  console.log(selectedData.selectedData.value);
                   var para = {
                                   'uid':selectedData.selectedData.value
                               };
                 //  console.log(para);
                   $.ajax({
                       url:"/baichuan_advertisement_manage/dc.main.ajaxresplans",
                       data:para,
                       type:"GET",
                       success:function(data){
                               console.log(data);
                               }
                   })
    }})
</script>
<script>
     var dddata = [
            {
                text:"所有广告主",
                value:0,
                selected:true,
            },
            {
                text:"第一个计划",
                value:1,
                selected:false,
            },
            {
                text:"第二个计划",
                value:2,
                selected:false,
            }
        ]        
     $("#users").ddslick({
        data:dddata,
        width:200,
        selectText:"广告主选择",
        onSelected:function(selectedData){
                  //  console.log(selectedData.selectedData.value);
                    var para = {
                                    'plan_id':selectedData.selectedData.value
                                };
                  //  console.log(para);
                    $.ajax({
                        url:"/baichuan_advertisement_manage/dc.main.ajaxRes",
                        data:para,
                        type:"GET",
                        success:function(data){
                                console.log(data);
                                }
                    })
        }})
</script>


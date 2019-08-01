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
//                   console.log(selectedData.selectedData.value);
                   var paras = { };
                   paras.start="{$start}";
                   paras.end="{$end}";
                   paras.uid=selectedData.selectedData.value;
                   report_dc("#chartShow",paras);//hightchar
                   paras.type="table";
                   getAreaReportTable(paras);//table
    }})
</script>


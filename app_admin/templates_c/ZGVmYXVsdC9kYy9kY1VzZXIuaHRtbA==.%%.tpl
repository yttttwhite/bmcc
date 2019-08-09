<!DOCTYPE html>
<html>
<head>
<meta https-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
<link type="text/css" rel="stylesheet" href="/baichuan_advertisement_manage/assets_admin/css/jquery.vector-map.css" />
<script src="/baichuan_advertisement_manage/assets_admin/js/jquery.vector-map.js" type="text/javascript"></script>
<script src="/baichuan_advertisement_manage/assets_admin/js/china-zh.js" type="text/javascript"></script>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.dc"), ENT_QUOTES); ?>
<!--main-->
<style>
.selMenu ul {
    z-index: 999;
}
.accordion {
    margin-top: 0px;
}
.tbgBtn {
    cursor: pointer;
}
</style>
    <div class="main">
        <div class="side">
            <div class="accordion" style="margin-top:0;">
                <!--<h2>综合维度统计</h2>-->
                <h2>广告报表</h2>
                <a href="/baichuan_advertisement_manage/dc.main.ad?nav=3&menu_left=1">
                    <h3 class="bort <?php if(Tpl::$_tpl_vars["_GET"]['menu_left'] ==1){; ?>active<?php }; ?>">广告统计</h3>
                </a>
                <a href="/baichuan_advertisement_manage/dc.main.media?nav=3&menu_left=2">
                    <h3 class="bort <?php if(Tpl::$_tpl_vars["_GET"]['menu_left'] ==2){; ?>active<?php }; ?>">媒体统计</h3>
                </a>
            </div>
        </div>
        <!--mcon start-->
        <div class="mcon">
            <div class="toolbar-bc fl mb-10">
                <div class="fl sub-title  sc-title">
                    <a href="javascript: void(0)">广告报表 </a>
                    <i class="fa fa-angle-double-right" ></i>
                    广告统计
                </div>
            </div>
            <div class="clear"></div>
            <!--toolbar start-->
            <div class="toolbar" style="height:initial;max-height: initial;border: none;">
                <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18,17,12])){; ?>
                <div class="tbGroup">
                    <span style="line-height: 34px;float: left;">账户筛选：</span>
                    <div class="selMenu ml10">
<?php /* 注释 权限说明 
  10000 =>"系统管理员", 
  1000 =>"运营账户", 
  18 =>"子运营账户", 
  11 =>"客服", 
  12 =>"客户经理", 
  13 =>"广告主", 
  14 =>"运维", 
  15 =>"黑白名管理员", 
  16 =>"稽核员", 
  17 =>"产品经理", 
*/?> 
                        <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18,12])){; ?>
                        <div class="smtbg" id="account_type">
                            <select name="account_type">
                                <option <?php if(empty(Tpl::$_tpl_vars["uid"])){; ?>selected<?php }; ?> value="0">--账户类型--</option>
                                <?php foreach(array(18=>"子运营账户", 12=>"客户经理", 13=>"广告主") as Tpl::$_tpl_vars["__k1"]=> Tpl::$_tpl_vars["__v1"] ){; ?>
                                    <?php if(Tpl::$_tpl_vars["info"]->role_id==10000 or
                                        (Tpl::$_tpl_vars["info"]->role_id==1000 and in_array(Tpl::$_tpl_vars["__k1"],[18,17,13,12]) ) or
                                        (Tpl::$_tpl_vars["info"]->role_id==18 and in_array(Tpl::$_tpl_vars["__k1"],[17,13,12]) ) or
                                        (Tpl::$_tpl_vars["info"]->role_id==12 and in_array(Tpl::$_tpl_vars["__k1"],[17,13]) )){; ?>
                                    <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__k1"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["user"]->role_id==Tpl::$_tpl_vars["__k1"]){; ?>selected="selected"<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["__v1"], ENT_QUOTES); ?></option>
                                    <?php }; ?>
                                <?php }; ?>
                            </select>
                        </div>
                        <?php }; ?>
                        <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18,13,12])){; ?>
                        <div class="smtbg" id="account_provider" style="display: none;">
                            <select name="account_provider">
                                <option <?php if(empty(Tpl::$_tpl_vars["uid"])){; ?>selected<?php }; ?> value="0">--子运营商账户--</option>
                                <?php foreach(Tpl::$_tpl_vars["account_provider"] as Tpl::$_tpl_vars["__provider_user"]){; ?>
                                <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__provider_user"]->uid, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__provider_user"]->user_name, ENT_QUOTES); ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <?php }; ?>
                        <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18,17,13,12])){; ?>
                        <div class="smtbg" id="account_manager" style="display: none;">
                            <select name="account_manager">
                                <option <?php if(empty(Tpl::$_tpl_vars["uid"])){; ?>selected<?php }; ?> value="0">--客户经理账户--</option>
                                <?php foreach(Tpl::$_tpl_vars["account_manager"] as Tpl::$_tpl_vars["__manager_user"]){; ?>
                                <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__manager_user"]->uid, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["_GET"][ 'account_manager']==Tpl::$_tpl_vars["__manager_user"]){; ?>selected="selected" <?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["__manager_user"]->user_name, ENT_QUOTES); ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <?php }; ?> <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18,17,13,12])){; ?>
                        <div class="smtbg" id="account_master" style="display: none;">
                            <select class="paras" name="uid">
                                <option <?php if(empty(Tpl::$_tpl_vars["uid"])){; ?>selected<?php }; ?> value="0">--广告主账户--</option>
                                <?php foreach(Tpl::$_tpl_vars["account_advertiser"] as Tpl::$_tpl_vars["__user"]){; ?>
                                <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__user"]->uid, ENT_QUOTES); ?>" data-creator_id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__user"]->creator_id, ENT_QUOTES); ?>" data-role_id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__user"]->role_id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["select_uid"]==Tpl::$_tpl_vars["__user"]->uid){; ?>selected="selected"<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["__user"]->user_name, ENT_QUOTES); ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <?php }; ?> 
                        <?php /*
                        <div class="smtbg">
                            选择用户
                            <select class="paras" name="uid" style="max-width: 100px;">
                                <?php if(Tpl::$_tpl_vars["adminFlag"] == true){; ?>
                                <option <?php if(empty(Tpl::$_tpl_vars["uid"])){; ?>selected<?php }; ?> value="0">所有用户</option><?php }; ?> 
                                <?php foreach(Tpl::$_tpl_vars["_users"] as Tpl::$_tpl_vars["__user"]){; ?>
                                <option <?php if(Tpl::$_tpl_vars["uid"]==Tpl::$_tpl_vars["__user"][ 'uid']){; ?>selected<?php }; ?> value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__user"]['uid'], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__user"]['uid'], ENT_QUOTES); ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["__user"]['user_name'], ENT_QUOTES); ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        */?>
                    </div>
                </div>
                <div style="height:20px" class="clear"></div>
                <?php }; ?>
                <div class="tbGroup">
                    <span style="line-height: 34px;float: left;">广告筛选：</span>
                    <div class="selMenu ml10">
                        <div class="smtbg" id="account_plan">
                            选择广告计划
                            <select class="" name="plan_id" style="max-width: 103px;">
                                <option <?php if(empty(Tpl::$_tpl_vars["plan_id"])){; ?>selected<?php }; ?> value="0">所有计划</option>
                                 <!--<?php foreach(Tpl::$_tpl_vars["_plans"] as Tpl::$_tpl_vars["__plan"]){; ?>-->
                                <!--<option <?php if(Tpl::$_tpl_vars["plan_id"]==Tpl::$_tpl_vars["__plan"][ 'plan_id']){; ?>selected<?php }; ?> value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__plan"]['plan_id'], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__plan"]['plan_id'], ENT_QUOTES); ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["__plan"]['plan_name'], ENT_QUOTES); ?></option>-->
                                <!--<?php }; ?> -->
                            </select>
                        </div>
                    </div>
                    <div class="selMenu ml10">
                        <div class="smtbg">
                            选择广告组
                            <select class="paras" name="group_id" style="max-width: 103px;">
                                <option <?php if(empty(Tpl::$_tpl_vars["group_id"])){; ?>selected<?php }; ?> value="0">所有广告组</option>
                                <?php foreach(Tpl::$_tpl_vars["_groups"] as Tpl::$_tpl_vars["__group"]){; ?>
                                <option <?php if(Tpl::$_tpl_vars["group_id"]==Tpl::$_tpl_vars["__group"][ 'group_id']){; ?>selected<?php }; ?> value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__group"]['group_id'], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__group"]['group_id'], ENT_QUOTES); ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["__group"]['group_name'], ENT_QUOTES); ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="selMenu ml10">
                        <div class="smtbg">
                            选择素材 
                            <select class="paras" name="ad_id" style="max-width: 103px;">
                                <option <?php if(empty(Tpl::$_tpl_vars["ad_id"])){; ?>selected<?php }; ?> value="0">所有广告素材</option>
                                <?php foreach(Tpl::$_tpl_vars["_ads"] as Tpl::$_tpl_vars["__ad"]){; ?>
                                <option <?php echo htmlspecialchars(Tpl::$_tpl_vars["adid"], ENT_QUOTES); ?> <?php if(Tpl::$_tpl_vars["ad_id"]==Tpl::$_tpl_vars["__ad"]['adid']){; ?>selected<?php }; ?> value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__ad"]['adid'], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__ad"]['adid'], ENT_QUOTES); ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["__ad"]['adname'], ENT_QUOTES); ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="height:20px" class="clear"></div>
                <div class="tbGroup ">
                    <span style="line-height: 34px;float: left;">统计方式：</span>
                    <span id="r_menu" class="tbgBtn ml10">
          <a  class="tbgba type" val="all">汇总</a>
          <a  class="tbgba type" val="week">按周</a>
          <a  class="tbgba type" val="day">按天</a>
          <a  class="tbgba type" val="hour">按小时</a>
        </span>
                    <span id="r_menu" class="tbgBtn ml10">
          <a  class="tbgba type" val="area">地域</a>
        </span>
                    <span id="r_menu" class="tbgBtn ml10">
          <a class="tbgba type" val="source">来源</a>
          <a class="tbgba type" val="media">媒体</a>
         <!-- <a class="tbgba type" val="ta">TA频道</a>-->
        </span>
                </div>
                <div style="height:20px" class="clear"></div>
                <div class="tbGroup">
                    <span style="line-height: 34px;float: left;">时间范围：</span>
                    <div class="selMenu ml10">
                        <div class="smtbg">
                            <input type="text" class="itxt_1 fl idate" id="startdate" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["start"],'开始时间'), ENT_QUOTES); ?>" size="15" />
                            <input type="text" class="itxt_1 fl idate" id="enddate" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["end"],'结束时间'), ENT_QUOTES); ?>" size="15" />
                        </div>
                        <div class="tbGroup">
                            <span id="r_menu" class="tbgBtn">
          <a id="r_today" class="tbgba">今天</a>
          <a id="r_yesterday" class="tbgba">昨天</a>
          <a id="r_week" class="tbgba">本周</a>
          <a id="r_lastweek" class="tbgba">上周</a>
          <a id="r_month" class="tbgba">本月</a>
          <a id="r_lastmoth" class="tbgba nobr">上月</a>
        </span>
                        </div>
                    </div>
                    <?php if(Tpl::$_tpl_vars["isPie"]){; ?>
                    <div class="selMenu ml10">
                        <div class="smtbg">
                            选择指标
                            <select class="paras" name="index_id">
                                <option <?php if(empty(Tpl::$_tpl_vars["index_id"])){; ?>selected<?php }; ?> value="pv">(PV)</option>
                                <option <?php if(Tpl::$_tpl_vars["index_id"]=="pc" ){; ?>selected<?php }; ?> value="pc">(PC)</option>
                                <option <?php if(Tpl::$_tpl_vars["index_id"]=="uv" ){; ?>selected<?php }; ?> value="uv">(UV)</option>
                                <option <?php if(Tpl::$_tpl_vars["index_id"]=="uc" ){; ?>selected<?php }; ?> value="uc">(UC)</option>
                                <option <?php if(Tpl::$_tpl_vars["index_id"]=="ipv" ){; ?>selected<?php }; ?> value="ipv">(IP)</option>
                                <option <?php if(Tpl::$_tpl_vars["index_id"]=="ipc" ){; ?>selected<?php }; ?> value="ipc">(IPC)</option>
                            </select>
                        </div>
                    </div>
                    <?php }; ?>
                </div>
                <div class="clear"></div>
            </div>
            <!--toolbar end-->

            <!-- <iframe width="100%" height="100%" style="border: 0;padding: 0;overflow: show;" src="#"></iframe> -->
            <div class="chartCon mt20">
                <div class="chartShow" style="height:420px" id="chartShow"><?php /*<img src="/baichuan_advertisement_manage/assets_admin/img/tmp_chart.gif" />*/?></div>
            </div>
            <div style="float:right" class="tbGroup ml30">
                <span>
    <a href="#"  style="padding-left:10px;padding-right:10px;height: 33px; line-height: 33px; font-size: 12px;" class="nobr" onclick="tableToExcel('report_dat','数据报表');return false;">导出</a>
        </span>
            </div>
            <table id="report_dat" width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt20">
                <thead>
                <tr>
                    <th>ID</th>
                    <th class="tac" style="cursor:pointer" >页面展示量 <i class="glyphicon glyphicon-sort"></i></th>
                    <th class="tac" style="cursor:pointer" >页面点击量 <i class="glyphicon glyphicon-sort"></i></th>
                    <th class="tac" style="cursor:pointer" >用户展示量 <i class="glyphicon glyphicon-sort"></i></th>
                    <th class="tac" style="cursor:pointer" >用户点击量 <i class="glyphicon glyphicon-sort"></i></th>
                    <th class="tac" style="cursor:pointer" >ip展示量 <i class="glyphicon glyphicon-sort"></i></th>
                    <th class="tac" style="cursor:pointer" >ip点击量 <i class="glyphicon glyphicon-sort"></i></th>
                    <th class="tac" style="cursor:pointer" >花费 <i class="glyphicon glyphicon-sort"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach(Tpl::$_tpl_vars["r"]->data as Tpl::$_tpl_vars["__data"]){; ?>
                <tr>
                    <td>
                        <?php if(Tpl::$_tpl_vars["patchName"]=="user"){; ?>
                        <a class="paras_a" href="#" name="uid" val="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->id, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->id, ENT_QUOTES); ?> <?php if(!empty(Tpl::$_tpl_vars["__data"]->name)){; ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->name, ENT_QUOTES); ?><?php }; ?></a> <?php }elseif( Tpl::$_tpl_vars["patchName"]=="plan"){; ?>
                        <a class="paras_a" href="#" name="plan_id" val="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->id, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->id, ENT_QUOTES); ?> <?php if(!empty(Tpl::$_tpl_vars["__data"]->name)){; ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->name, ENT_QUOTES); ?><?php }; ?></a> <?php }elseif( Tpl::$_tpl_vars["patchName"]=="group"){; ?>
                        <a class="paras_a" href="#" name="group_id" val="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->id, ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->id, ENT_QUOTES); ?> <?php if(!empty(Tpl::$_tpl_vars["__data"]->name)){; ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->name, ENT_QUOTES); ?><?php }; ?></a> <?php }elseif( Tpl::$_tpl_vars["patchName"]=="ad"){; ?>
                        <a target="_blank" href="/baichuan_advertisement_manage/ad.preview.entry.<?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->id, ENT_QUOTES); ?>" title="预览"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->name, ENT_QUOTES); ?></a> <?php }else{; ?>
                        <a target="_blank" href="#" title="预览"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->name, ENT_QUOTES); ?></a> <?php }; ?>
                    </td>
                    <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->pv, ENT_QUOTES); ?></td>
                    <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->pc, ENT_QUOTES); ?></td>
                    <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->uv, ENT_QUOTES); ?></td>
                    <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->uc, ENT_QUOTES); ?></td>
                    <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->ipv, ENT_QUOTES); ?></td>
                    <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->ipc, ENT_QUOTES); ?></td>
                    <td class="tac"><?php echo htmlspecialchars(Tpl::$_tpl_vars["__data"]->cost, ENT_QUOTES); ?>元</td>
                </tr>
                <?php }; ?>
                </tbody>
            </table>




        </div>
        <!--mcon end-->
    </div>

<script>
$(document).ready(function() {
    $(".idate").datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: 1
    });
});

var paras={ };
paras.start="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['start'], ENT_QUOTES); ?>";
paras.end="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['end'], ENT_QUOTES); ?>";
paras.uid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["uid"], ENT_QUOTES); ?>";
paras.plan_id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>";
paras.group_id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>";
paras.ad_id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad_id"], ENT_QUOTES); ?>";
paras.type="<?php echo htmlspecialchars(Tpl::$_tpl_vars["type"], ENT_QUOTES); ?>";
paras.index_id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["index_id"], ENT_QUOTES); ?>";
paras.sort_id="<?php echo htmlspecialchars(Tpl::$_tpl_vars["sort_id"], ENT_QUOTES); ?>";
paras.nav=3;
paras.menu_left=1;
paras.sort_order= <?php echo htmlspecialchars(Tpl::$_tpl_vars["sort_order"], ENT_QUOTES); ?>;
paras.month = <?php echo htmlspecialchars(Tpl::$_tpl_vars["month"], ENT_QUOTES); ?>;
paras.week = <?php echo htmlspecialchars(Tpl::$_tpl_vars["week"], ENT_QUOTES); ?>;
function rel(n){
      var url="/dc.main.ad?"+jQuery.param(paras); 
//      debugger
      location.href= url;
}
$(document).ready(function(){
    <?php if(Tpl::$_tpl_vars["month"] >0){; ?>
    var ret = getInfo(<?php echo htmlspecialchars(Tpl::$_tpl_vars["month"], ENT_QUOTES); ?>,1);
        var week_count = ret[2];
        var h = "";
        h+="<option value='0'>请选择</option>";
        for(i=1;i<week_count+1;i++){
            h+="<option value='"+i+"'>"+i+"周</option>";
        }
        $("#Uweek").html(h);
        $("#Uweek option").each(function(){
            if($(this).val() == <?php echo htmlspecialchars(Tpl::$_tpl_vars["week"], ENT_QUOTES); ?>){
                $(this).attr("selected", "selected");
            }
        });   
    <?php }; ?>
  $(".paras").change(function(){
      var n = $(this).attr("name");
      var v = $(this).val();//attr("name");
      paras[n]=v;
      rel(n);
      });
  $(".paras_a").click(function(){
      var n = $(this).attr("name");
      var v = $(this).attr("val");
      paras[n]=v;
      rel();
      return false;
      });
  $(".type").click(function(){
      paras.type=$(this).attr("val");
      rel();
    return false;
    });
  $(".type").each(function(i,item){
      if($(item).attr("val")==paras.type){
        $(item).addClass("sel");
      }
    });

  });

  function getInfo(month,week) {
      var d = new Date();
      var year = d.getFullYear()
      // what day is first day
      d.setFullYear(year, month-1, 1);
      var w1 = d.getDay();
      if (w1 == 0) w1 = 7;
      // total day of month
      d.setFullYear(year, month, 0);
      var dd = d.getDate();
      // first Monday
      if (w1 != 1) d1 = 7 - w1 + 2;
      else d1 = 1;
      week_count = Math.ceil((dd-d1+1)/7);

      var monday = d1+(week-1)*7;
      var sunday = monday + 6;
      var from = year.toString()+"-"+PrefixInteger(month)+"-"+PrefixInteger(monday);
      var to;
      if (sunday <= dd) {
          to = year.toString()+"-"+PrefixInteger(month)+"-"+PrefixInteger(sunday);
      } else {
          d.setFullYear(year, month-1, sunday);
          to = year.toString()+"-"+PrefixInteger(d.getMonth()+1)+"-"+PrefixInteger(d.getDate());
      }
      return [from,to,week_count];
      
  }
  function PrefixInteger(num) {
      return (num/Math.pow(10,2)).toFixed(2).substr(2);
  }

function appendOptions(jqel, data, clear, def) {
    if (clear) jqel.empty();
    if (def) jqel.append(def);
    for (var i = data.length - 1; i >= 0; i--) {
        jqel.append( $('<option ></option>').text(data[i]['plan_name']||data[i]['user_name']).attr('value', data[i]['plan_id']||data[i]['uid']) );
    }
}

var account_type_el = $('.toolbar #account_type');
var account_provider_el = $('.toolbar #account_provider');
var account_manager_el = $('.toolbar #account_manager');
var account_master_el = $('.toolbar #account_master');
var plan_el = $('.toolbar #account_plan');

account_provider_el.find('select').on('change', function() {
    paras.account_provider = $(this).val();
    paras.uid=0;
    paras.account_manager=0;
    if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_provider']? Tpl::$_tpl_vars["_GET"]['account_provider']:0, ENT_QUOTES); ?>!=paras.account_provider) rel();
    $.ajax({
        cache: true,
        type: "GET",
        url: "/baichuan_advertisement_manage/admin.user.Getcarriers." + paras.account_provider + '1',
        async: false,
        tiemout: 6,
        error: function(request) {
            alert("获取客户经理账户出错");
        },
        success: function(data) {
            try{
            appendOptions(account_manager_el.find('select'), JSON.parse(data), true, '<option value="0">--客户经理账户--</option>');
            }catch(ex){
                console.log("未获取到客户经理账户数据",ex);
            }
            account_manager_el.show();
        }
    });
});
account_manager_el.find('select').on('change', function() {
    paras.account_manager = $(this).val();
    paras.uid=0;
   /* console.log($(this).val());
    console.log(1111);*/
    /**by zx**/
    /*var account_type_val=account_type_el.find("select").val(),
    prevSelectVal="";
    if(18==account_type_val){
        prevSelectVal=account_provider_el.find("select").val();
    }
    else if(12==account_type_val){
        prevSelectVal=account_type_val;
    }
    paras.account_manager=prevSelectVal;*/
    /**by zx**/
   // paras.account_manager = account_type_el.find('select').val();
    /*console.log(paras.account_manager);
    console.log(666);
    console.log(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_manager'], ENT_QUOTES); ?>);
    console.log(777);
    return false;*/
     if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_manager']? Tpl::$_tpl_vars["_GET"]['account_manager']:0, ENT_QUOTES); ?>!=paras.account_manager) rel();
    $.ajax({
        cache: true,
        type: "GET",
        url: !paras.account_manager? '/dc.main.GetAdevertiser' : ("/admin.user.Getcarriers." + paras.account_manager + '2'),
        async: false,
        timeout: 6,
        error: function(request) {
            alert("获取广告主账户出错");
        },
        success: function(data) {
            try{
            appendOptions(account_master_el.find('select'), JSON.parse(data), true, '<option value="0">--广告主账户--</option>');
            }catch(ex){
                console.log("未获取到广告主账户数据",ex);
            }
            account_master_el.show();
        }
    });
});
account_master_el.find('select').on('change', function() {
    paras.uid = $(this).val();
    if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['uid']? Tpl::$_tpl_vars["_GET"]['uid']:0, ENT_QUOTES); ?>!=paras.uid) rel();
    getPlan(paras.uid);
});
function getPlan(uid){
    $.ajax({
        cache: true,
        type: "GET",
        url: "/baichuan_advertisement_manage/dc.main.getplan?uid=" + uid,
        async: false,
        tiemout: 6,
        error: function(request) {
            alert("获取广告计划出错");
        },
        success: function(data) {
            try{
            appendOptions(plan_el.find('select'), JSON.parse(data), true, '<option value="">所有广告计划</option>');
            }catch(ex){
                console.log("未获取广告计划数据",ex);
            }
        }
    });
}
plan_el.find('select').on('change', function() {
    paras.plan_id = $(this).val();
    rel();
});

function hide_account_stree(){
        account_provider_el.hide() ;
        account_manager_el.hide() ;
        account_master_el.hide() ;
}
account_type_el.find('select').on('change', function() {
    paras.account_type = $(this).val();
    if (this.value == 12) {
        paras.account_provider = 0;
        paras.account_manager = 0;
        /***/
        paras.uid=0;
        paras.group_id=0;
        paras.plan_id=0;
        paras.ad_id=0;
        /***/
        account_provider_el.find('select').val(0).trigger('change');
        hide_account_stree();
        account_manager_el.show();
    } else if (this.value == 13) {
        paras.account_provider = 0;
        paras.account_manager = 0;
        /***/
        paras.uid=0;
        paras.plan_id=0;
        paras.group_id=0;
        paras.ad_id=0;
        /***/
        account_manager_el.find('select').val(0).trigger('change');
        hide_account_stree();
        account_master_el.show();
    } else if (this.value == 18) {
        hide_account_stree();
        account_provider_el.show();
    } else {
       
        paras.account_provider = 0;
        paras.account_manager = 0;
        /***/
        paras.uid=0;
        paras.group_id=0;
        paras.plan_id=0;
        paras.ad_id=0;
        /***/
        rel();
        
        // account_provider_el.hide().find('select').val('');
        // account_manager_el.hide().find('select').val('');
    }
})

//account_type_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_type'], ENT_QUOTES); ?>").trigger('change');
if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_type']? 1:0, ENT_QUOTES); ?>) {
	account_type_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_type'], ENT_QUOTES); ?>");
	 paras.account_type="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_type'], ENT_QUOTES); ?>";
	if("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_type'], ENT_QUOTES); ?>"=="12"){
		account_provider_el.find('select').val(0).trigger('change');
		hide_account_stree();
		account_manager_el.show();
	}
	else if("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_type'], ENT_QUOTES); ?>"=="13"){
		account_manager_el.find('select').val(0).trigger('change');
		hide_account_stree();
        account_master_el.show();
	}
	else if ("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_type'], ENT_QUOTES); ?>" == "18") {
        hide_account_stree();
        account_provider_el.show();
    } else {
    	rel();
    }
}
if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_provider']? 1:0, ENT_QUOTES); ?>) account_provider_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_provider'], ENT_QUOTES); ?>").trigger('change');
/*if(1) account_manager_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_manager'], ENT_QUOTES); ?>").trigger('change');*/
if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_manager']? 1:0, ENT_QUOTES); ?>) account_manager_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_manager'], ENT_QUOTES); ?>").trigger('change');
/*if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['uid']? 1:0, ENT_QUOTES); ?>&&<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['uid']>0, ENT_QUOTES); ?>){
    account_master_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['uid'], ENT_QUOTES); ?>"); 
    if(account_master_el.find('select').val()) account_master_el.find('select').trigger('change');
}*/
var account_manager_val="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_manager'], ENT_QUOTES); ?>",
account_provider_val="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['account_provider'], ENT_QUOTES); ?>",
uid_val="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['uid'], ENT_QUOTES); ?>",
roleId ="<?php echo htmlspecialchars(Tpl::$_tpl_vars["info"]->role_id, ENT_QUOTES); ?>";

if(uid_val&&uid_val!=0){
    account_master_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['uid'], ENT_QUOTES); ?>"); 
    if(account_master_el.find('select').val()) account_master_el.find('select').trigger('change');
}
else if (account_manager_val&&account_manager_val!=0){
    getPlan(account_manager_val);
}
else if(account_provider_val&&account_provider_val!=0){
    getPlan(account_provider_val);
} 
else{
    account_master_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['uid'], ENT_QUOTES); ?>"); 
    if(account_master_el.find('select').val()) account_master_el.find('select').trigger('change');
}
if(roleId==="13"){
  getPlan("<?php echo htmlspecialchars(Tpl::$_tpl_vars["info"]->uid, ENT_QUOTES); ?>");
}
if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['plan_id']? 1:0, ENT_QUOTES); ?>) plan_el.find('select').val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["_GET"]['plan_id'], ENT_QUOTES); ?>");





$("#Umonth").change(function() {
    Umonth = $(this).val();
    var ret = getInfo(Umonth, 1);
    var week_count = ret[2];
    var h = "";
    h += "<option value='0'>请选择</option>";
    for (i = 1; i < week_count + 1; i++) {
        h += "<option  <?php if(Tpl::$_tpl_vars["week"]==Tpl::$_tpl_vars["i"]){; ?>selected<?php }; ?> value='" + i + "'>" + i + "周</option>";
    }
    $("#Uweek").html(h);
});
$("#Uweek").change(function() {
    Umonth = $("#Umonth").val();
    Uweek = $(this).val();
    var ret = getInfo(Umonth, Uweek);
    paras.start = ret[0];
    paras.end = ret[1];
    paras.month = Umonth;
    paras.week = Uweek;
    rel();

});
//$(document).ready(function(){
 // debugger
if (paras.start == paras.end && paras.end == "<?php echo htmlspecialchars(date('Y-m-d'), ENT_QUOTES); ?>") {
    $("#r_today").addClass('sel');
}
if (paras.start == paras.end && paras.end == "<?php echo htmlspecialchars(date('Y-m-d',time()-3600*24), ENT_QUOTES); ?>") {
    $("#r_yesterday").addClass('sel');
}
if (paras.start == "<?php echo htmlspecialchars(date('Y-m-d',strtotime('-1 week Monday')), ENT_QUOTES); ?>" && paras.end == "<?php echo htmlspecialchars(date('Y-m-d',strtotime('+0 week Sunday')), ENT_QUOTES); ?>") {
    $("#r_week").addClass("sel");
}
if (paras.start == "<?php echo htmlspecialchars(date('Y-m-d',strtotime('-2 week Monday')), ENT_QUOTES); ?>" && paras.end == "<?php echo htmlspecialchars(date('Y-m-d',strtotime('-1 week Sunday')), ENT_QUOTES); ?>") {
    $("#r_lastweek").addClass("sel");
}
if (paras.start == "<?php echo htmlspecialchars(date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y'))), ENT_QUOTES); ?>" && paras.end == "<?php echo htmlspecialchars(date('Y-m-d',time()), ENT_QUOTES); ?>") {
    $("#r_month").addClass("sel");
}
if (paras.start == "<?php echo htmlspecialchars(date('Y-m-d',mktime(0, 0 , 0,date('m')-1,1,date('Y'))), ENT_QUOTES); ?>" && paras.end == "<?php echo htmlspecialchars(date('Y-m-d',mktime(23,59,59,date('m') ,0,date('Y'))), ENT_QUOTES); ?>") {
    $("#r_lastmoth").addClass("sel");
}

//});
function setV() {
    $("#startdate").val(paras.start);
    $("#enddate").val(paras.end);
    rel();
}
$("#report_Category a").click(function() {
    $(this).parent().find("A").removeClass("sel");
    $(this).addClass("sel");
});

$("#area").click(function() {
    paras.report_category = "area";
    setV();
    //report("#chartShow",paras);
});
$("#r_menu a").click(function() {
    $(this).parent().find("A").removeClass("sel");
    $(this).addClass("sel");
});

$("#startdate").change(function() {
    paras.start = $(this).val();
    setV();
    //report("#chartShow",paras);
});
$("#enddate").change(function() {
    paras.end = $(this).val();
    setV();
    //report("#chartShow",paras);
});
$("#r_today").click(function() {
    paras.start = "<?php echo htmlspecialchars(date('Y-m-d'), ENT_QUOTES); ?>";
    paras.end = "<?php echo htmlspecialchars(date('Y-m-d'), ENT_QUOTES); ?>";
    setV();
    //report("#chartShow",paras);
});
$("#r_yesterday").click(function() {
    paras.start = "<?php echo htmlspecialchars(date('Y-m-d',time()-3600*24), ENT_QUOTES); ?>";
    paras.end = "<?php echo htmlspecialchars(date('Y-m-d',time()-3600*24), ENT_QUOTES); ?>";
    setV();
    //report("#chartShow",paras);
});
$("#r_week").click(function() {
    paras.start = "<?php echo htmlspecialchars(date('Y-m-d',strtotime('-1 week Monday')), ENT_QUOTES); ?>";
    paras.end = "<?php echo htmlspecialchars(date('Y-m-d',strtotime('+0 week Sunday')), ENT_QUOTES); ?>";
    setV();
    //report("#chartShow",paras);
});
$("#r_lastweek").click(function() {
    paras.start = "<?php echo htmlspecialchars(date('Y-m-d',strtotime('-2 week Monday')), ENT_QUOTES); ?>";
    paras.end = "<?php echo htmlspecialchars(date('Y-m-d',strtotime('-1 week Sunday')), ENT_QUOTES); ?>";
    setV();
    //report("#chartShow",paras);
});
$("#r_month").click(function() {
    paras.start = "<?php echo htmlspecialchars(date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y'))), ENT_QUOTES); ?>";
    paras.end = "<?php echo htmlspecialchars(date('Y-m-d',time()), ENT_QUOTES); ?>";
    setV();
    //report("#chartShow",paras);
});
$("#r_lastmoth").click(function() {
    paras.start = "<?php echo htmlspecialchars(date('Y-m-d',mktime(0, 0 , 0,date('m')-1,1,date('Y'))), ENT_QUOTES); ?>";
    paras.end = "<?php echo htmlspecialchars(date('Y-m-d',mktime(23,59,59,date('m') ,0,date('Y'))), ENT_QUOTES); ?>";
    setV();
    //report("#chartShow",paras);
});
$("#r_yesterday").click(function() {
    paras.start = "<?php echo htmlspecialchars(date('Y-m-d',time()-3600*24), ENT_QUOTES); ?>";
    paras.end = "<?php echo htmlspecialchars(date('Y-m-d',time()-3600*24), ENT_QUOTES); ?>";
    setV();
    //report("#chartShow",paras);
});
</script>
<script>
// 绘图
if(paras.type=="day" || paras.type=="all" || paras.type=="hour"||paras.type=="ta"||paras.type=="week"){
    options = {
        title : {
            text: '数据报表',
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['PV(cpm)','PC(次)','UV(cpm)','UC(次)','IPV(cpm)','IPC(次)','花费(元)']
        },
        toolbox: {
            show : true,
            feature : {
                mark : { show: true},
                dataView : { show: true, readOnly: true, lang: ['数据视图', '关闭', '刷新']},
                magicType : { show: true, type: ['line', 'bar']},
                restore : { show: true},
                saveAsImage : { show: true}
            }
        },
        calculable : true,
      <?php if(!empty(Tpl::$_tpl_vars["data_json"]['id'])){; ?>
        xAxis : [
            {
                type : 'category',
                data : <?php echo tpl_modifier_default(Tpl::$_tpl_vars["data_json"]['name'],'[""]'); ?>//['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
          <?php if(!empty(Tpl::$_tpl_vars["data_json"]['pv'])){; ?>
                name:'PV(cpm)',
                type:'bar',
                data:<?php echo Tpl::$_tpl_vars["data_json"]['pv']; ?>,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                markPoint : {
                    data : [
                        { type : 'max', name: '最大值'},
                        { type : 'min', name: '最小值'}
                    ]
                },
                markLine : {
                    data : [
                        { type : 'average', name: '平均值'}
                    ]
                }
           <?php }; ?>
            } 
                ,{
                    <?php if(!empty(Tpl::$_tpl_vars["data_json"]['pc'])){; ?>
                    name:'PC(次)',
                    type:'bar',
                    data:<?php echo tpl_modifier_default(Tpl::$_tpl_vars["data_json"]['pc'],'[]'); ?>,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    markPoint : {
                        data : [
                            { type : 'max', name: '最大值'},
                            { type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            { type : 'average', name: '平均值'}
                        ]
                    }
                     <?php }; ?>
                }
                ,{
                    <?php if(!empty(Tpl::$_tpl_vars["data_json"]['uv'])){; ?>
                    name:'UV(cpm)',
                    type:'bar',
                    data:<?php echo tpl_modifier_default(Tpl::$_tpl_vars["data_json"]['uv'],'[]'); ?>,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    markPoint : {
                        data : [
                            { type : 'max', name: '最大值'},
                            { type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            { type : 'average', name: '平均值'}
                        ]
                    }
                     <?php }; ?>
                }
                ,{
                    <?php if(!empty(Tpl::$_tpl_vars["data_json"]['uc'])){; ?>
                    name:'UC(次)',
                    type:'bar',
                    data:<?php echo tpl_modifier_default(Tpl::$_tpl_vars["data_json"]['uc'],'[]'); ?>,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    markPoint : {
                        data : [
                            { type : 'max', name: '最大值'},
                            { type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            { type : 'average', name: '平均值'}
                        ]
                    }
                     <?php }; ?>
                }
                ,{
                    <?php if(!empty(Tpl::$_tpl_vars["data_json"]['ipv'])){; ?>
                    name:'IPV(cpm)',
                    type:'bar',
                    data:<?php echo tpl_modifier_default(Tpl::$_tpl_vars["data_json"]['ipv'],'[]'); ?>,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    markPoint : {
                        data : [
                            { type : 'max', name: '最大值'},
                            { type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            { type : 'average', name: '平均值'}
                        ]
                    }
                     <?php }; ?>
                }
        ,{
          <?php if(!empty(Tpl::$_tpl_vars["data_json"]['ipc'])){; ?>
                name:'IPC(次)',
                type:'bar',
                data:<?php echo tpl_modifier_default(Tpl::$_tpl_vars["data_json"]['ipc'],'[]'); ?>,//[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                markPoint : {
                    data : [
                        { type : 'max', name: '最大值'},
                        { type : 'min', name: '最小值'}
                    ]
                },
                markLine : {
                    data : [
                        { type : 'average', name : '平均值'}
                    ]
                }
          <?php }; ?>
            }
        ,{
          <?php if(!empty(Tpl::$_tpl_vars["data_json"]['cost'])){; ?>
                name:'花费(元)',
                type:'bar',
                data:<?php echo tpl_modifier_default(Tpl::$_tpl_vars["data_json"]['cost'],'[]'); ?>,//[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                markPoint : {
                    data : [
                        { type : 'max', name: '最大值'},
                        { type : 'min', name: '最小值'}
                    ]
                },
                markLine : {
                    data : [
                        { type : 'average', name : '平均值'}
                    ]
                }
             <?php }; ?>
            }
        ]
      <?php }; ?>
    };
}else{
    options = {
        title : {
            text: '来源分布图-展示',
            x:'left'
        },
        tooltip : {
            trigger: 'item',
        },
        legend: {
            x : 'center',
            y : 'bottom',
            data:[<?php echo Tpl::$_tpl_vars["data_json"]['title']; ?>]//}'rose1','rose2','rose3','rose4','rose5','rose6','rose7','rose8']
        },
        toolbox: {
            show : true,
            feature : {
                mark : { show: true},
                dataView : { show: true, readOnly: true, lang: ['数据视图', '关闭', '刷新']},
                restore : { show: true},
                saveAsImage : { show: true}
            }
        },
        calculable : true,
        series : [
            {
                name:'媒体分布',
                type:'pie',
                radius : [20, 110],
                roseType : 'radius',
                itemStyle :　{
                    normal : {
                        label : {
                            show : true
                        },
                        labelLine : {
                            show : true
                        }
                    },
                    emphasis : {
                        label : {
                            show : true
                        },
                        labelLine : {
                            show : true
                        }
                    }
                },
                data:[<?php echo tpl_modifier_default(Tpl::$_tpl_vars["data_json"]['data'],'[]'); ?>/*
                    { value:10, name:'rose1'},
                    { value:5, name:'rose2'},
                    { value:15, name:'rose3'},
                    { value:25, name:'rose4'},
                    { value:20, name:'rose5'},
                    { value:35, name:'rose6'},
                    { value:30, name:'rose7'},
                    { value:40, name:'rose8'}*/
                ]
            }
        ]
    };
}               
    var myChart = echarts.init(document.getElementById("chartShow"));
    myChart.setOption(options);
</script>
<script type="text/javascript">
// 表格排序
(function($) {
  var State = (function(){
    function State(indexes){
      this.index = null;
      this.order = 1;
      this.indexes = indexes;
    }

    State.prototype = {
      getOrder: function(index){
        if (this.index === index) {
          return this.order;
        } else {
          return 1;
        }
      },
      updateOrder: function(index){
        if (this.index === index) {
          this.order *= -1;
        } else {
          this.index = index;
          this.order = -1;
        }
      },
      getIndex: function(){
        return this.index;
      },
      indexCheck: function(index){
        if (this.indexes.indexOf(index) !== -1){
          return true;
        } else {
          return false;
        }
      },
    };

    return State;
  })();

  $.fn.tableSort = function(params){
    var defaults = {
      indexes: $(this).find("thead").find("th").map(function(){
        return $(this).index();
      }).get(),
      compare: function(){ },
      after: function(){ },
    };

    var settings = $.extend(defaults, params);
    var state = new State(settings.indexes);
    var $target = $(this);

    var compare = function(a, b, type, index) {
      var _a = $(a).find("td").eq(index).text();
      var _b = $(b).find("td").eq(index).text();

      switch (type){
      case "integer":
        _a *= 1;
        _b *= 1;
        return _a - _b;
      case "date":
        var _date_a = new Date(_a).getTime();
        var _date_b = new Date(_b).getTime();
        if (_date_a < _date_b) {
          return -1;
        } else if (_date_a > _date_b) {
          return 1;
        }
        return 0;
      case "custom":
        return settings.compare(_a, _b);
      default:
        if (_a < _b) {
          return -1;
        } else if (_a > _b) {
          return 1;
        }
        return 0;
      }
    };

    var removeClass = function(target){
      $(target).find('> i').removeClass("glyphicon-arrow-up  glyphicon-arrow-down glyphicon-sort");
    };

    var addClass = function(target){
      var $inner = $(target);
      var index = $inner.index();

      if (state.getIndex() === index){
        if (state.getOrder(index) === -1){
          $inner.find('> i').addClass("glyphicon-arrow-up");
        } else {
          $inner.find('> i').addClass("glyphicon-arrow-down");
        }
      } else {
        $inner.find('> i').addClass("glyphicon-sort");
      }
    };

    var refreshClass = function(target){
      $(target).find("thead").find("th").each(function(){
        if (state.indexCheck($(this).index())){
          removeClass(this);
          addClass(this);
        }
      });
    };

    var sort = function(){
      var type = $(this).data("type");
      var index = $(this).index();
      var $rows = $target.find("tbody>tr");

      $rows.sort(function(a, b){
        return compare(a, b, type, index) * state.getOrder(index);
      });

      $target.find("tbody").empty().append($rows);

      state.updateOrder(index);
      refreshClass($target);
      settings.after(this);
    };

    $target.find("thead").find("th").each(function(){
      if (state.indexCheck($(this).index())){
        $(this).on("click", sort);
      }
    });
    refreshClass($target);

    return this;
  };

  $.fn.tableMove = function(params){
    var defaults = {
      after: function(){ },
    };

    var settings = $.extend(defaults, params);

    var moveUp = function(){
      var $row = $(this).closest("tr");
      if ($row.prev("tr").length){
        $row.insertBefore($row.prev("tr"));
        settings.after($row);
      }
    };

    var moveDown = function(){
      var $row = $(this).closest("tr");
      if ($row.next("tr").length){
        $row.insertAfter($row.next("tr"));
        settings.after($row);
      }
    };

    $(this).find("tbody>tr").find(".up").on("click", moveUp);
    $(this).find("tbody>tr").find(".down").on("click", moveDown);

    return this;
  };
})(jQuery);

$("#report_dat").tableSort();
</script>

    <?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>

</body>
</html>

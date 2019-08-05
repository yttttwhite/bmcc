<!DOCTYPE html>
<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<!--<script src="https://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<link href="https://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"/>-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/font-awesome-4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/ContractInformation.css" />
<html>
<head>
    <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
    
<script type="text/javascript" src="/baichuan_advertisement_manage/assets_admin/js/bootstrap-select.js"></script>
<link href="/baichuan_advertisement_manage/assets_admin/css/bootstrap-select.css" rel="stylesheet">
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<style>
    span.poinTime{
        height: 28px;
    }
    .dtli {
        height: 460px;
    }
    .ContractInformation .form-control {
        width: 160px;
    }
</style>
<!--main-->
<div class="main">
    <div class="side">
        <?php echo htmlspecialchars(tpl_function_part("/ad.plan.listpart.".Tpl::$_tpl_vars["plan_id"]), ENT_QUOTES); ?>
    </div>
    <!--mcon-->

    <div class="mcon">
        <div class="step">
            <div class="step1" style="padding:0px;">
                <div id="prevplan" class="pull-left" style="height:100%;width:227px;"></div>
                <div id="nextgroup" class="pull-left" style="height:100%;width:227px;">
                    <a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["backgroup"], ENT_QUOTES); ?>" style="height:100%;width:100%;display:block"></a>
                </div>
                <div id="nextstaff" class="pull-left" style="height:100%;width:227px;">
                    <a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["backstaff"], ENT_QUOTES); ?>" style="height:100%;width:100%;display:block"></a>
                </div>
            </div>
        </div>
        <form method="post" action="/baichuan_advertisement_manage/ad.plan.add.<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->plan_id,0), ENT_QUOTES); ?>"  id="plan_form">
            <input type="hidden" name="plan_id" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->plan_id,0), ENT_QUOTES); ?>" />
            <input type="hidden"  value="0" id="hidden_price"/>
            <!-- <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['channel_id'], ENT_QUOTES); ?>" id="hidden_channel_id"/> -->
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["adpostion"]->media_id, ENT_QUOTES); ?>" id="hidden_media_id"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["adpostion"]->channel_id, ENT_QUOTES); ?>" id="hidden_channel_id"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['ad_pos_id'], ENT_QUOTES); ?>" id="hidden_ad_pos_id"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['bind_id'], ENT_QUOTES); ?>" id="hidden_bind_id"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->manager, ENT_QUOTES); ?>" id="hidden_market_id"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->media_id, ENT_QUOTES); ?>" id="hidden_media_id"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->channel_id, ENT_QUOTES); ?>" id="hidden_channel_id"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->position_id, ENT_QUOTES); ?>" id="hidden_position_id"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['position_identification'], ENT_QUOTES); ?>" id="hidden_position_identification"/>
            <input type="hidden"  value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["roleId"], ENT_QUOTES); ?>" id="hidden_role_id"/>
            <div class="comForm clear">
                <!--基本信息-->
                <h1>基本信息</h1>
                <dl>
                    <dt>计划名称：</dt>
                    <dd><input id="plan_name" name="plan_name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_name, ENT_QUOTES); ?>" type="text" class="itxt" size="30" required <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>/></dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                    <dd class="tips_correct" style="display:none"></dd>
                    <?php if(!empty(Tpl::$_tpl_vars["error"]['plan_name'])){; ?>
                    <dd class="tips_error"></dd>
                    <?php }; ?>
                </dl>
                <!--广告来源  start-->
                <dl style="display: none;">
                    <dt>广告来源：</dt>
                    <dd>
                        <select  <?php if(isset(Tpl::$_tpl_vars["plan_id"])){; ?>disabled<?php }; ?> id="selYear" name="source">
                            <option value="0">--选择广告来源--</option>
                           <?php foreach(Tpl::$_tpl_vars["sourceInfo"] as Tpl::$_tpl_vars["source"]){; ?>
                            <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["source"]['id'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["source"]['id']==Tpl::$_tpl_vars["plan"]->adsource){; ?> selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["source"]["source_name"], ENT_QUOTES); ?></option>
                            <?php }; ?>
                            
                            <!--<?php foreach(Tpl::$_tpl_vars["plans"] as Tpl::$_tpl_vars["_plan"]){; ?>-->
                            <!--<option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["loaded_id"]==Tpl::$_tpl_vars["_plan"]->plan_id){; ?>selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_name, ENT_QUOTES); ?></option>-->
                            <!--<?php }; ?>-->
                        </select>
                    </dd>
                </dl>
                <!--广告来源  end-->


                <!--合同信息展现框 end-->
                <dl id="platdl2">
                    <dt>广告计划类型：</dt>
                    <dd>
                        <select id="cate" name="cate" <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> required style="width:250px;">
                            <option value="">请选择</option>
                            <?php foreach(Tpl::$_tpl_vars["plan_types"] as Tpl::$_tpl_vars["k"]=>Tpl::$_tpl_vars["_t"]){; ?>
                            <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["k"], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["k"], ENT_QUOTES); ?></option>
                            <?php }; ?>
                        </select>
                        <select <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> id="sub_cate" name="type_id" data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->type_id, ENT_QUOTES); ?>" style="width:250px;">
                        </select>
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </dl>
                <script>
                    var types=$.parseJSON($.base64.atob('<?php echo htmlspecialchars(base64_encode(SJson::encode(Tpl::$_tpl_vars["plan_types"])), ENT_QUOTES); ?>')) ;
                    $(document).ready(function(){
                        $("#cate").change(function(){
                            var t=types[($(this).val())];
                            $("#sub_cate").html();
                            var h="";
                            for(var i in t){
                                <?php if(!empty(Tpl::$_tpl_vars["plan"]->type_id)){; ?>
                                if(t[i].type_id == <?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->type_id, ENT_QUOTES); ?>){
                                    h+="<option selected='selected' value='"+t[i].type_id+"'>"+t[i].type_name+"</option>";
                                }else{
                                    h+="<option value='"+t[i].type_id+"'>"+t[i].type_name+"</option>";
                                }
                                <?php }else{; ?>
                                h+="<option value='"+t[i].type_id+"'>"+t[i].type_name+"</option>";
                                <?php }; ?>
                            }
                            $("#sub_cate").html(h);
                            console.log(h);
                        });
                        var type_id=($("#sub_cate").attr("data"));
                        for(var i in types){
                            for(var j in types[i]){
                                if(type_id == types[i][j].type_id ){
                                    $("#cate").val(i).trigger("change");
                                }
                            }
                        }
                        $("#ta_cate").change(function(){
                            $("#sub_cate").find("option:selected").attr("selected",false);
                            $("#ta_cate").find("option:selected").attr("selected",true);
                            $("#sub_cate").val("");
                        });
                    });
                </script>
                <dl>
                    <dt>导入广告计划：</dt>
                    <dd>
                        <select <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> id="selYear" name="load_ad" onchange="var id=$(this).val();location='/baichuan_advertisement_manage/ad.plan.add?loaded_id='+id;">
                            <option value="0">请选择</option>
                            <?php foreach(Tpl::$_tpl_vars["plans"] as Tpl::$_tpl_vars["_plan"]){; ?>
                            <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["loaded_id"]==Tpl::$_tpl_vars["_plan"]->plan_id){; ?>selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["_plan"]->plan_name, ENT_QUOTES); ?></option>
                            <?php }; ?>
                        </select>
                    </dd>
                </dl>
                <script>
                    var plans=$.parseJSON($.base64.atob('<?php echo htmlspecialchars(base64_encode(SJson::encode(Tpl::$_tpl_vars["plans"])), ENT_QUOTES); ?>'));
                    $(function(){
                        if($("#start_date").val()=="开始时间"){
                            $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                        }
                        $("#start_date").datepicker({ dateFormat: "yy-mm-dd" ,minDate:0});
                        $("#end_date").datepicker({ dateFormat: "yy-mm-dd",minDate:new Date(Date.parse($("#start_date").val())) });
                    });
                </script>
            <?php /*
                <dl>
                    <dt>投放优先级类型：</dt>
                    <dd>
                        <?php foreach(Tpl::$_tpl_vars["releaseType"] as Tpl::$_tpl_vars["releaseCode"]=>Tpl::$_tpl_vars["releaseInfo"]){; ?>
                        <label class="irad ml20"><input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="radio" name="release_type" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["releaseCode"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan"]->release_type==Tpl::$_tpl_vars["releaseCode"]){; ?>checked<?php }; ?>/ <?php if(Tpl::$_tpl_vars["releaseCode"] ==20 && empty(Tpl::$_tpl_vars["plan"]->release_type)){; ?>checked<?php }; ?>> <?php echo htmlspecialchars(Tpl::$_tpl_vars["releaseInfo"]['name'], ENT_QUOTES); ?></label>
                        <?php }; ?>
                    </dd>
                </dl>
            */?>
            </div>
            <!-- 归属设置 -->
            <div class="comForm clear" id="gssz">
                <h1>归属设置</h1>
                <div >
                <span></span>
                <dl>
                    <dt></dt>
                    <dd>
                        <label for="addToSelf"><input type="checkbox" name="addToSelf" id="addToSelf">为自己添加广告</label>
                    </dd>
                </dl>
                </div>

                <div id="zyys">
                <dl>
                    <dt>所属子运营商：</dt>
                    <dd>
                        <select type="1" id="sub_carriers" name="sub_carriers" style="width:250px;" required="required">
                            <?php foreach(Tpl::$_tpl_vars["carriersUser"] as Tpl::$_tpl_vars["carrier"]){; ?>
                            <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["carrier"]['uid'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["carrier"]['uid']==Tpl::$_tpl_vars["plan"]->lowoperate){; ?> selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["carrier"]['user_name'], ENT_QUOTES); ?></option>
                            <?php }; ?>
                        </select>
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </dl>
                </div>
                <div id="khjl">
                <dl>
                    <dt>所属客户经理：</dt>
                    <dd>
                        <select type="2" id="account_manager" name="account_manager" style="width:250px;" required="required">
                        </select>
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </dl>
                </div>
                <dl id="ssggz">
                    <dt>所属广告主账户：</dt>
                    <dd>
                        <select type="3" id="ad_owner" name="bind_id" style="width:250px;" required="required">
                        <!-- <select type="3" id="ad_owner" name="ad_owner" style="width:250px;" required="required"> -->
                        </select>
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </dl>
                <div id="ad_info" style="display: none">
                    <dl>
                        <dt>广告主账户：</dt>
                        <dd>
                            <span id="ad_number"></span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>广告主账户余额：</dt>
                        <dd>
                            <span id="ad_balance"></span>
                        </dd>
                    </dl>
                </div>
                 <?php if(Tpl::$_tpl_vars["plan"]->plan_id>0){; ?>
                <div id="ad_info_self" style="display: none">
                    <dl>
                        <dt>广告主账户：</dt>
                        <dd>
                            <span id="ad_number_self"><?php echo htmlspecialchars(Tpl::$_tpl_vars["userinfo"]['user_name'], ENT_QUOTES); ?></span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>广告主账户余额：</dt>
                        <dd>
                            <span id="ad_balance_self"><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["userinfo"]['account'],2), ENT_QUOTES); ?>元</span>
                        </dd>
                    </dl>
                </div>
                <?php }else{; ?>
                 <div id="ad_info_self" style="display: none">
                    <dl>
                        <dt>广告主账户：</dt>
                        <dd>
                            <span id="ad_number_self"><?php echo htmlspecialchars(Tpl::$_tpl_vars["currentUser"]->user_name, ENT_QUOTES); ?></span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>广告主账户余额：</dt>
                        <dd>
                            <span id="ad_balance_self"><?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["currentUser"]->account,2), ENT_QUOTES); ?>元</span>
                        </dd>
                    </dl>
                </div>
                
                <?php }; ?>


            </div>


            <div class="comForm clear" style="overflow: visible;">
                <h1>价格设置</h1>
                
              <?php /* 
                <dl>
                    <dt>媒体来源：</dt>
                    <dd>
                        <select id="platform" name="platform" required style="width:250px;">
                            <?php foreach(Tpl::$_tpl_vars["ms"]->items as Tpl::$_tpl_vars["w"]){; ?>
                            <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]['id'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["media_extra"]['platform']==Tpl::$_tpl_vars["w"]['id']){; ?> selected <?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]['media_name'], ENT_QUOTES); ?></option>
                            <?php }; ?>
                        </select>
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </dl>
                <dl>
                    <dt>频道专题：</dt>
                    <dd>
                        <select id="channel_id" name="channel_id" required style="width:250px;">
                        </select>
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </dl>
                <dl>
                    <dt>广告位置：</dt>
                    <dd>
                        <select id="position_id" name="ad_pos_id" required style="width:250px;">
                        </select>
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </dl>
              */?>
               <!--======================================================================-->
<!--                <dl>
                    <div id="ad_tfsj">
                    <dt>广告位类型：</dt>
                    <dd>
                        <label class="irad" for="qt"><input name="position_type" id="positiontype" type="radio" value="1" <?php if(Tpl::$_tpl_vars["plan"]->all_day_or_not==1){; ?>checked<?php }; ?> <?php if(!isset(Tpl::$_tpl_vars["plan"])){; ?>checked<?php }; ?>/> 广告位类型</label>
                        <label class="irad ml20" for="fsd" id="showposition" onClick="showPosition();"><input name="positionid" <?php if(Tpl::$_tpl_vars["plan"]->all_day_or_not===0){; ?>checked<?php }; ?> id="fsd" type="radio" value="0" /> 广告位</label>
                    </dd>
                        </div>
                    <div id="displaypositiontype">
                    <dt>广告位类型：</dt>
                    <dd>
                        <select id="tag_identification" name="tag_identification" required style="width:250px;">
                        <option value="">--请选择广告位类型标签--</option>
                        <?php foreach(Tpl::$_tpl_vars["tags"] as Tpl::$_tpl_vars["_tag"]){; ?>
                        <?php if(Tpl::$_tpl_vars["user"]->role_id==13){; ?>
                        <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_tag"]['tag_ident'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["media_extra"]['tag_identification']==Tpl::$_tpl_vars["_tag"]['tag_ident']){; ?>selected<?php }; ?> ><?php echo htmlspecialchars(Tpl::$_tpl_vars["_tag"]['tag_ident'], ENT_QUOTES); ?></option>
                        
                        <?php }else{; ?>
                        <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_tag"]['tag_ident'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["media_extra"]['tag_identification']==Tpl::$_tpl_vars["_tag"]['tag_ident']){; ?>selected<?php }; ?> data-cpm="<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpm_price'],2), ENT_QUOTES); ?>" data-cpt="<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpt_price'],2), ENT_QUOTES); ?>" data-cpc="<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpc_price'],2), ENT_QUOTES); ?>" ><?php echo htmlspecialchars(Tpl::$_tpl_vars["_tag"]['tag_ident'], ENT_QUOTES); ?> &nbsp;&nbsp;<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpm_price'],2), ENT_QUOTES); ?>/CPM &nbsp;&nbsp; <?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpt_price'],2), ENT_QUOTES); ?>/CPT</option>
                        <?php }; ?>
                        <?php }; ?>
                        </select>
                    </dd>
                    </div>
                    <div id="displayposi" >
                    <dt>广告位123：</dt>
                    <dd>
                        <select class="" name="source_id"   id="source_id">
                        <option <?php if(empty(Tpl::$_tpl_vars["_GET"]['source_id'])){; ?>selected<?php }; ?> value="">--媒体来源--</option>
                         <?php foreach(Tpl::$_tpl_vars["ms"] as Tpl::$_tpl_vars["w"]){; ?>
                        <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]['id'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan"]->media_id==Tpl::$_tpl_vars["w"]['id']){; ?>selected<?php }; ?> ><?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]['media_name'], ENT_QUOTES); ?></option>
                        <?php }; ?>
    </select>
                    </dd>
                    <dd>
                        <select id="channel_id" name="channel_id" required style="width:250px;position:relative;top:34px;left:-133px;">
                        <option value="">--请选择频道--</option>
                        <?php foreach(Tpl::$_tpl_vars["channels"] as Tpl::$_tpl_vars["w"]){; ?>
                        <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]->channel_id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan"]->channel_id==Tpl::$_tpl_vars["w"]->channel_id){; ?>selected<?php }; ?> ><?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]->channel_name, ENT_QUOTES); ?></option>
                        <?php }; ?>
                        
                        </select>
                    </dd>
                     <dd>
                        <select id="position_id" name="ad_pos_id" required style="width:250px;position:relative;top:10px;left:470px;">
                        <option value="">--请选择广告位--</option>
                        <?php foreach(Tpl::$_tpl_vars["positions"] as Tpl::$_tpl_vars["w"]){; ?>
                        <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]->id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan"]->position_id==Tpl::$_tpl_vars["w"]->id){; ?>selected<?php }; ?> ><?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]->position_name, ENT_QUOTES); ?></option>
                        <?php }; ?>
                        </select>
                    </dd>
                    </div>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </dl>
               -->
               <!--重新写这段代码  start/-->
                   <!--价格设置与刊例单价 之间  start-->
                <!--选择合同  start-->
                <dl>
                    <dt>合同类型：</dt>
                    <dd>
                        <select <?php if(isset(Tpl::$_tpl_vars["plan_id"])){; ?>disabled<?php }; ?> id="billing_type" name="contract_type" style="width:250px;">
                        <option value="0"  <?php if(Tpl::$_tpl_vars["plan"]->contract_type=='0'){; ?> selected<?php }; ?>>--请选择合同类型--</option>
                        <option value="1"  <?php if(Tpl::$_tpl_vars["plan"]->contract_type=='1'){; ?> selected<?php }; ?>>竞价制广告合同</option>
                        <option value="2"  <?php if(Tpl::$_tpl_vars["plan"]->contract_type=='2'){; ?> selected<?php }; ?>>合约制广告合同</option>
                        </select>
                    </dd>
                </dl>
                <!--  合约制  -->
                <dl id="price_contract" class="ContractSct" style="position: relative;overflow: visible;height: 26px;display: none;">
                    <dt>选择广告位单价：</dt>
                    <dd>
                      <?php if(isset(Tpl::$_tpl_vars["plan_id"])){; ?>
                          <select disabled  name="price_id">
                              <option class="ContractInofo" value="0"  <?php if(Tpl::$_tpl_vars["plan"]->contract_id==0){; ?> selected<?php }; ?>>--选择广告位单价--</option>
  
                              <?php foreach(Tpl::$_tpl_vars["contract_list"]  as  Tpl::$_tpl_vars["price"]){; ?>
                              <option class="ContractInofo" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["price"]['contract_id'], ENT_QUOTES); ?>"  <?php if(Tpl::$_tpl_vars["price"]['contract_id']==Tpl::$_tpl_vars["plan"]->contract_id){; ?> selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["price"]['contract_name'], ENT_QUOTES); ?></option>
                              <?php }; ?>
                          </select>
                      <?php }else{; ?>
                        <select name="price_id">
                              <option class="ContractInofo" value="0"  <?php if(Tpl::$_tpl_vars["plan"]->contract_id==0){; ?> selected<?php }; ?>>--选择广告位单价--</option>
                          </select>
                        <?php }; ?>
                    </dd>
                </dl>
               <!--  竞价制  -->
                <dl id="con_contract" class="ContractSct" style="position: relative;overflow: visible;height: 26px;display: none;">
                    <dt>选择合同：</dt>
                    <dd>
                    	<?php if(isset(Tpl::$_tpl_vars["plan_id"])){; ?>
	                        <select disabled  id="selYear" name="contract_id">
	                            <option class="ContractInofo" value="0"  <?php if(Tpl::$_tpl_vars["plan"]->contract_id==0){; ?> selected<?php }; ?>>--选择合同--</option>
	
	                            <?php foreach(Tpl::$_tpl_vars["contract_list"]  as  Tpl::$_tpl_vars["contract"]){; ?>
	                            <option class="ContractInofo" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contract_id'], ENT_QUOTES); ?>"  <?php if(Tpl::$_tpl_vars["contract"]['contract_id']==Tpl::$_tpl_vars["plan"]->contract_id){; ?> selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["contract"]['contract_name'], ENT_QUOTES); ?></option>
	                            <?php }; ?>
	                        </select>
	                    <?php }else{; ?>
	                    	<select  id="selYear" name="contract_id">
	                            <option class="ContractInofo" value="0"  <?php if(Tpl::$_tpl_vars["plan"]->contract_id==0){; ?> selected<?php }; ?>>--选择合同--</option>
	                        </select>
                        <?php }; ?>
                    </dd>
                    <!--合同信息展现框 start-->
                    <div class="ContractInformation" style="height: auto;top:-70px;left:314px;border: none;">
                        <span>选中合同信息</span><br>
                        &nbsp;&nbsp;<span style="width: 96px;text-align: right">合同名称：&nbsp;</span><input name="contract_name" disabled="disabled" type="text" class="form-control" value="互盈计划">
                        <span style="width: 96px;text-align: right">&nbsp;合同序号：&nbsp;</span><input name="contract_num" disabled="disabled" type="text" class="form-control" value="0001"><br><br>
                        &nbsp;&nbsp;<span style="width: 96px;text-align: right">公司名称：&nbsp;</span><input name="company_name" disabled="disabled" type="text" class="form-control"  value="中国移动">
                        <!--&nbsp;<span style="width: 96px;text-align: right">广告预算：&nbsp;</span><input name="total_budge" disabled="disabled" type="text" class="form-control" value=""><br><br>-->
                        <div class="price_box"></div>
                        <div class="discount_rate">
                            &nbsp;&nbsp;<span style="width: 96px;text-align: right;">总价：&nbsp;</span><input name="total_budget" disabled="disabled" type="text" class="form-control" >

                            <span style="width: 96px;text-align: right;">&nbsp;折扣：&nbsp;</span><input name="discount_rate" disabled="disabled" type="text" class="form-control" ><br><br>
                            &nbsp;&nbsp;<span style="width: 96px;text-align: right;">折后：&nbsp;</span><input name="discount_after" disabled="disabled" type="text" class="form-control">

                        </div>
                    </div>
                </dl>
                <!--竞价合同-->
                <dl class="billing_type1">
                    <dt>计费方式：</dt>
                    <dd>
                        <select id="charge_id" name="billing_type" required <?php if(isset(Tpl::$_tpl_vars["plan_id"])){; ?>disabled<?php }; ?> style="width:250px;">
                            <option value="0">--请选择--</option>
                            <option value="2" <?php if(Tpl::$_tpl_vars["media_extra"]['billing_type'] ==2){; ?> selected <?php }; ?>>CPM</option>
                            <option value="4" <?php if(Tpl::$_tpl_vars["media_extra"]['billing_type'] ==4){; ?> selected <?php }; ?>>CPT（天）</option>
                            <!--下面3个是暂时新增的，还没有数据-->
                            <!--<option value="4" <?php if(Tpl::$_tpl_vars["media_extra"]['billing_type'] ==5){; ?> selected <?php }; ?>>按投放量</option>-->
                            <!--<option value="4" <?php if(Tpl::$_tpl_vars["media_extra"]['billing_type'] ==6){; ?> selected <?php }; ?>>按通话时长</option>-->
                            <!--<option value="4" <?php if(Tpl::$_tpl_vars["media_extra"]['billing_type'] ==7){; ?> selected <?php }; ?>>按通话号码</option>-->
                        </select>
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                    <?php if(isset(Tpl::$_tpl_vars["plan_id"])){; ?><dd><span class="tipstxt">说明：此项无法修改。</span></dd><?php }; ?>
                </dl>
                <div id="postion_price">
	                <dl class="billing_type1">
	                    <dt>位置定价：</dt>
	                    <dd>
	                        <input type="number"  placeholder="请先选择计费方式" name="setting_price" class="itxt" min="0.01" step="0.01" required style="width:200px" id="price" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->setting_price, ENT_QUOTES); ?>"/>&nbsp;&nbsp;<span id="price_way">元/CPM</span>
	                    </dd>
	                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
	                </dl>
                </div>

                <dl class="ad_price_box_1">
                    <dt>广告类型：</dt>
                    <dd>
                        <span class="ad_type"><input name="position_type" value="1"   type="radio"  <?php if(Tpl::$_tpl_vars["plan"]->ad_pos_id<=0){; ?>checked<?php }; ?> id="ad_type" /> <label  for="ad_type">广告位类型</label></span>
                        <span class="ad_seat"><input name="position_type"  value="2" type="radio" <?php if(Tpl::$_tpl_vars["plan"]->ad_pos_id>0){; ?>checked<?php }; ?>  id="ad_ seat" /> <label  for="ad_ seat">广告位</label></span>
                    </dd>
                </dl>


                <div style="height:40px;" class="ad_price_box_2">
                	<dt>广告位类型：</dt>
                    <dd>
                      <input name="tag_identifications" type="hidden" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->tag_identifications, ENT_QUOTES); ?>"/>
                      <select id="tag_identification" name="tag_identification"  readonly data-live-search="true" multiple class="selectpicker" title="--请选择广告位类型标签--">
                        
                      </select>
                      
                        <!--<select id="tag_identification" name="tag_identification" required style="width:250px;">
                           <option value="">--请选择广告位类型标签--</option>-->
                        <!--   <?php foreach(Tpl::$_tpl_vars["tags"] as Tpl::$_tpl_vars["_tag"]){; ?>
                           <?php if(Tpl::$_tpl_vars["_tag"]['plan_id'] ==0 or Tpl::$_tpl_vars["_tag"]['plan_id'] ==Tpl::$_tpl_vars["plan_id"]){; ?>
                           <?php if(Tpl::$_tpl_vars["user"]->role_id==13){; ?>
                           <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_tag"]['tag_ident'], ENT_QUOTES); ?>"  <?php if(Tpl::$_tpl_vars["media_extra"]['tag_identification']==Tpl::$_tpl_vars["_tag"]['tag_ident']){; ?>selected<?php }; ?> ><?php echo htmlspecialchars(Tpl::$_tpl_vars["_tag"]['tag_ident'], ENT_QUOTES); ?></option>
                           <?php }else{; ?>
                           <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_tag"]['tag_ident'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["media_extra"]['tag_identification']==Tpl::$_tpl_vars["_tag"]['tag_ident']){; ?>selected<?php }; ?> data-cpm="<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpm_price'],2), ENT_QUOTES); ?>" data-cpt="<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpt_price'],2), ENT_QUOTES); ?>" data-cpc="<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpc_price'],2), ENT_QUOTES); ?>" ><?php echo htmlspecialchars(Tpl::$_tpl_vars["_tag"]['tag_ident'], ENT_QUOTES); ?> &nbsp;&nbsp;<?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpm_price'],2), ENT_QUOTES); ?>/CPM &nbsp;&nbsp; <?php echo htmlspecialchars(number_format(Tpl::$_tpl_vars["_tag"]['cpt_price'],2), ENT_QUOTES); ?>/CPT</option>
                           <?php }; ?>
                           <?php }; ?>
                           <?php }; ?>-->
                       <!-- </select>-->
                    </dd>
                    <dd><span style="color:red;margin-left:10px;">*</span></dd>
                </div>

                <dl class="ad_price_box_3">
                    <dt>广告位：</dt>
                    <dd>
                        <select class="" name="source_id2"   id="source_id">
                            <option <?php if(empty(Tpl::$_tpl_vars["_GET"]['source_id'])){; ?>selected<?php }; ?> value="">--媒体来源--</option>
                            <?php foreach(Tpl::$_tpl_vars["ms"] as Tpl::$_tpl_vars["w"]){; ?>
                            <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]['id'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan"]->media_id==Tpl::$_tpl_vars["w"]['id']){; ?>selected<?php }; ?> ><?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]['media_name'], ENT_QUOTES); ?></option>
                            <?php }; ?>
                        </select>
                        <select id="channel_id" name="channel_id" required >
                            <option value="">--请选择频道--</option>
                          <!--  <?php foreach(Tpl::$_tpl_vars["channels"] as Tpl::$_tpl_vars["w"]){; ?>
                            <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]->channel_id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan"]->channel_id==Tpl::$_tpl_vars["w"]->channel_id){; ?>selected<?php }; ?> ><?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]->channel_name, ENT_QUOTES); ?></option>
                            <?php }; ?>-->
                        </select>
                        <select id="position_id" name="ad_pos_id" required >
                            <option value="">--请选择广告位--</option>
                           <!-- <?php foreach(Tpl::$_tpl_vars["positions"] as Tpl::$_tpl_vars["w"]){; ?>
                            <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]->id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["plan"]->position_id==Tpl::$_tpl_vars["w"]->id){; ?>selected<?php }; ?> ><?php echo htmlspecialchars(Tpl::$_tpl_vars["w"]->position_name, ENT_QUOTES); ?></option>
                            <?php }; ?>-->
                        </select>
                    </dd>
                </dl>

                   <script>
                    $(function () { 
                    	/*var item = $('input[name=position_type][checked]').val(); 
                    	if(item==2){
                   		 $("#position_id").val(0);
                   	}  else {
                   		$("#tag_identification").empty();


                   	}*/
                   	 
                   	 
                    //$('.selectpicker').selectpicker();
//                  根据合同类型获取所有合同名称 以及 和同类型确定计费方式以及位置定价单位
                    $("#billing_type").change(function(){
                        var contract_type=new Object();
                            contract_type.contract_type = $(this).val();
                            contract_type.uid=$("#ad_owner").val()?$("#ad_owner").val():0;
                            <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                                <?php if(Tpl::$_tpl_vars["roleId"] == '13'){; ?>
                                  contract_type.uid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["current_user"]->uid, ENT_QUOTES); ?>"
                                <?php }; ?>
                                if($("input[name=addToSelf]:checked").length>0){
                                  contract_type.uid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["current_user"]->uid, ENT_QUOTES); ?>"
                                }
                                
                            <?php }else{; ?>
                              contract_type.uid = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->bind_id, ENT_QUOTES); ?>";
                            <?php }; ?>
                            var roleId="<?php echo htmlspecialchars(Tpl::$_tpl_vars["roleId"], ENT_QUOTES); ?>";
                            
                            
                            if(!contract_type.uid)return false;
                            if(!$(this).val()) return false;
                            var elem_= $('select[name="contract_id"]'),elem;
                            var price=$('select[name="price_id"]');
                            var con_contract=$("#con_contract"),price_contract=$("#price_contract");
                            $("#postion_price").show();
                            var $val=$(this).val();
                            if($val==1){
                              <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                                $("input[name=total_cpm]").val("");
                                $('input[name="setting_price"]').val("").removeAttr('readonly');
                                $("#end_date").val("结束时间");
                              <?php }; ?>
                            	$('select[name="billing_type"]').val(2).attr("disabled",false);
                            	$('select[name="billing_type"] option[value=2]').siblings().hide();
                              $("#price_way").html("元/CPM");
                              $("#start_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                              $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                              $("#end_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                              $("#end_date").datepicker("option","maxDate","");
                              $("#budget_cpm").show();
                              $("#budget_cpt").hide();
                              con_contract.show(); 
                              price_contract.hide(); 
                              elem=elem_;
                              
                              
                        	}
                            else{
                              price_contract.show(); 
                              con_contract.hide();
                              elem=price;
                               <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                                  $("input[name=setting_price]").val("").prop("readonly","true");
                               <?php }; ?>
                            	$('select[name="billing_type"] option[value=2]').siblings().show();
                            	$('select[name="billing_type"]').attr("disabled",true);
                            	
                            	if($('select[name="billing_type"]').val()=="4"){
                            		$("#price_way").html("元/天");
                            	}
                            }

                            $.ajax({
                                type:"POST",
                                url: "/baichuan_advertisement_manage/ad.plan.GetContract",
                                data:contract_type,
                                async: false,   //问题的关键，明确是异步提交数据
                                dataType:'json',
                                success:function (data) {
                                	console.log("datadtata",data);
	                                  if($val==="1"){
	                                    if(data.length>0){
	                                      var con_bol=false;
                                        for(var i=0;i<data.length;i++){
                                          var isAccess = false;
                                          <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                                            isAccess = data[i].access_budget　>　0
                                          <?php }else{; ?>
                                            isAccess = true
                                          <?php }; ?>
                                          if(isAccess){
                                              if(!con_bol){
                                                con_bol=!con_bol;
                                                elem.empty();
                                              }
                                              name=data[i].contract_name;
                                              id=data[i].contract_id;
                                              elem.append('<option data-money='+data[i].access_budget+' value='+id+'>'+name+'|剩余金额'+data[i].access_budget
+'元</option>')
                                           }
                                        }
                                        if(con_bol){
  	                                      // $('select[name="contract_id"]').trigger("change");
  	                                       con_bol=!con_bol;
  	                                    }
	                                    }
	                                  }
	                                  else{
	                                    var bol=false;
                                        elem.empty();
                                        if(data.length === 0){
                                        	elem.append('<option value="">请选择广告位单价</option>');
                                        }
	                                    for(var j=0;j<data.length;j++){
	                                      if(!bol){
	                                        bol=!bol;
	                                      }
	                                      var item=data[j];
	                                      elem.append('<option data-price='+item["price"]+' data-access='+item["access_budget"]+' data-unit='+item["unit"]+' value='+item["unit_id"]+'>'+item["price"]+'元|剩余量'+item["access_budget"]+' '+(item["unit"]=="2"?"cpm":"cpt")+'</option>');
                                       }
	                                    if(bol){
                                         <?php if(!empty(Tpl::$_tpl_vars["plan"]->unit_id)){; ?>
                                         var aa="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->unit_id, ENT_QUOTES); ?>";
                                          $("select[name=price_id]").val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->unit_id, ENT_QUOTES); ?>").trigger("change");
                                         <?php }else{; ?>
                                          $('select[name="price_id"]').trigger("change");
                                         <?php }; ?>
                                        bol=!bol;
                                      }
	                                  }
                                },
                                error:function () {
                                    // document.getElementById('Result').innerHTML="出错啦！";
                                    // $("input:not('#send')").val('');
                                }

                            });
                    });
//                  根据合同名称ID获取名称信息
                      $('select[name="price_id"]').change(function(){
                         var $option=$(this).find("option:selected");
                         <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                           $('select[name="billing_type"]').val($option.attr("data-unit"));
                           $('input[name="setting_price"]').val($option.attr("data-price"));
                         <?php }; ?>
                         $('select[name="billing_type"]').attr('disabled',true);
                         $('input[name="setting_price"]').attr('readonly','readonly');
                         $('input[name="plan_day_num_cpt"]').prop("disabled",false);
        
                         if($option.attr("data-unit")==="4") {
                           <?php if(empty(Tpl::$_tpl_vars["plan"]->total_cpt)){; ?>
                            $('input[name="total_cpt"]').val($option.attr("data-access"));
                           <?php }; ?> 
                            
                           // $('input[name="total_cpt"]').prop('readonly','false');
                            $('input[name="total_cpt"]').unbind("blur").unbind("keyup");
                            var cptChange=function(tar){
                                var value=$(tar).val();
                                var min=0;
                                var max=$option.attr("data-access");
                                if(parseFloat(value)<=min||parseFloat(value)>max){
                                    $(tar).val($option.attr("data-access"));
                                }
                                cost_type();
                            }
                            $('input[name="total_cpt"]').blur(function(){
                                cptChange(this);
                                $(this).val(Number($(this).val()).toFixed(3));
                            });
                            $('input[name="total_cpt"]').keyup(function(){
                              cptChange(this);
                            });

                        }
                        if($option.attr("data-unit")=="2"){
                            <?php if(empty(Tpl::$_tpl_vars["plan"]->total_cpm)){; ?>
                            $('input[name="total_cpm"]').val($option.attr("data-access"));
                            <?php }; ?>
                          //  $('input[name="total_cpt"]').prop('readonly','false');
                            $('input[name="total_cpm"]').unbind("blur").unbind("keyup");
                            var cpmChange=function(tar){
                              var value=$(tar).val()*1;
                              var min=0;
                              var max=$option.attr("data-access");
                              if(parseFloat(value)<=min||parseFloat(value)>max){
                                  $(tar).val($option.attr("data-access"));
                              }
                            }
                            $('input[name="total_cpm"]').blur(function(){
                              cpmChange(this);
                              $(this).val(Number($(this).val()).toFixed(3));
                            });
                            $('input[name="total_cpm"]').keyup(function(){
                              cpmChange(this);
                            });
                        }
                        $("#channel_id").trigger("change");
                        var dataArr=[],dataObj=new Object();
                        dataObj.price=$option.attr("data-price");
                        dataObj.unit=($option.attr("data-unit"));
                        dataArr.push(dataObj);
                        get_adposition_type(dataArr);
                        cost_type();
                        function cost_type(){
                                var charge_id = $('select[name="billing_type"]').val();
                                if(charge_id == 0){
                                    $("#postion_price").hide();
                                    $("#budget_cpt").show();
                                    $("#budget_cpm").hide();
                                    $("#ad_tfsj").show();
                                    $("#start_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                    $("#end_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                    $("#end_date").datepicker("option","maxDate","");
                                    <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                                      $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                      $("#end_date").val("结束时间");
                                    <?php }else{; ?>
                                      $("#end_date").val("<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->end_date,'结束时间'), ENT_QUOTES); ?>");
                                    <?php }; ?>
                                }else {
                                    $("#postion_price").show();
                                    if(charge_id == 4){
                                        $("#price_way").html("元/天");
//                                                    $("")
                                        $("#budget_cpm").hide();
                                        $("#budget_cpt").show();
                                        $($("#budget_cpt").children().get(1)).hide();
                                        $("#ad_tfsj").hide();
                                        $(".ysl_cpt").html('CPT(天)');
                                        $('#price').attr('min', $('#price').data('cpt'));
                                        $("#start_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d",time()+3600*24), ENT_QUOTES); ?>");
                                        
                                    var charget_val=parseInt($('input[name="total_cpt"]').val());
                                    var nowDate=new Date("<?php echo htmlspecialchars(date("Y-m-d",time()), ENT_QUOTES); ?>");
                                    nowDate.setDate(nowDate.getDate()+charget_val);
                                        $("#end_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d",time()+3600*24), ENT_QUOTES); ?>");
                                        $("#end_date").datepicker("option","maxDate",nowDate.format("yyyy-MM-dd"));
                                        
                                        <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                                          $("#plan_day_num").val(0);
                                          $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d",time()+3600*24), ENT_QUOTES); ?>");
                                          $("#end_date").val(nowDate.format("yyyy-MM-dd"));
                                        <?php }else{; ?>
                                          $("#end_date").val("<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->end_date,'结束时间'), ENT_QUOTES); ?>");
                                        <?php }; ?>
                                    }
                                    if(charge_id == 2) {
                                        $("#price_way").html("元/CPM");
                                        $("#budget_cpm").show();
                                        $("#budget_cpt").hide();
                                        $("#ad_tfsj").show();
                                        $('#price').attr('min',  $('#price').data('cpm'));
                                        $("#start_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                        
                                        $("#end_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                        $("#end_date").datepicker("option","maxDate","");
                                        <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                                          $("#plan_day_num").val(0);
                                          $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                          $("#end_date").val("结束时间");
                                        <?php }else{; ?>
                                        $("#end_date").val("<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->end_date,'结束时间'), ENT_QUOTES); ?>");
                                        <?php }; ?>
                                        
                                    }
                                }
                            };
                      });

                      /* 每日预算量监听change */
                      
                        $("#plan_day_num").on(
                          {
                            change: function(){
                              var cpmNum=$("input[name=total_cpm]").val();
                              if(parseFloat($(this).val())>parseFloat(cpmNum)){
                                $(this).val(cpmNum);
                              }
                            },
                            keyup: function(){
                              var cpmNum=$("input[name=total_cpm]").val();
                              if(parseFloat($(this).val())>parseFloat(cpmNum)){
                                $(this).val(cpmNum);
                              }
                            }
                          });
                     

                        $('select[name="contract_id"]').change(function(){

                            var contract_id=new Object();
                            contract_id.contract_id = $(this).val();
                            if(!($(this).val()&&$(this).val().length>0))return false;
                            $(".ContractSct").hover(function(){
                                $(".ContractInformation").show();
                            },function(){
                                $(".ContractInformation").hide();
                            });
                            $(".ContractInformation").hover(function(){
                                $(".ContractInformation").show();
                            },function(){
                                $(".ContractInformation").hide();
                            });

                            $.ajax({
                                type:"POST",
                                url: "/baichuan_advertisement_manage/ad.plan.get",
                                data:contract_id,
                                async: false,   //问题的关键，明确是异步提交数据
                                dataType:'json',
                                success:function (data) {
                                   if($("#billing_type").val()==2){
                                       contract_name_ms2(data)
                                }
                                   if($("#billing_type").val()==1) {


                                       contract_name_ms1(data)

                                }
                                },
                                error:function () {
                                    // document.getElementById('Result').innerHTML="出错啦！";
                                    // $("input:not('#send')").val('');
                                }

                            });
                        });
                        
                        $("input[name=setting_price]").on("change",function(){
                        	/* 控制广告为类型的的值 */
                        	var dataArr=[],dataObj=new Object();
                        	if($("select[name=billing_type]").prop("disabled"))dataObj.unit=4;
                        	else{
                        		if($("select[name=billing_type]").val()==0)return false;
                        		else dataObj.unit=$("select[name=billing_type]").val()
                        	}
                        	dataObj.price=$(this).val();
                        	dataArr.push(dataObj);
                        	get_adposition_type(dataArr);
                        	
                        	/*控制广告位的下拉值 */
                        	if($("select[name=channel_id]").val() && $("select[name=channel_id]").val().trim().length > 0){
                        		$("select[name=channel_id]").trigger("change")
                        	}
                        	
                        });
                        
                        
//                        选中合约制合同信息
                        function contract_name_ms2 (data) {
                            var unit=data[0].unit;
                            $('.ContractInformation input[name="contract_name"]').val(data[0].contract_name);
                            $('.ContractInformation input[name="company_name"]').val(data[0].company_name);
                            $('.ContractInformation input[name="contract_num"]').val(data[0].contract_name);
                            $('.ContractInformation input[name="total_budget"]').val(data[0].total_budget);
                            $('.ContractInformation input[name="discount_rate"]').val(data[0].discount_rate);
                            $('.ContractInformation input[name="discount_after"]').val(data[0].discount_after);


                            var form=$(".ContractInformation .price_box");
                            form.empty();
                            for(var i=0;i<unit.length;i++){
								if(unit[i].access_buy_amount&&unit[i].access_buy_amount>0){
                                	var d='&nbsp;&nbsp;<span style="width: 96px;text-align: right;"><input type="radio" name="unit_id" value='+unit[i].unit_id+'>广告单价：&nbsp;</span><input name="price" disabled="disabled" type="text" class="form-control"  value='+unit[i].price+'>'+

                                    '<span style="width: 96px;text-align: right;">&nbsp;购买量：&nbsp;</span><input name="buy_amount" disabled="disabled" type="text" class="form-control" value='+unit[i].buy_amount+'><br><br>'+
                                    '&nbsp;&nbsp;<span style="width: 96px;text-align: right;">单位：&nbsp;</span><input name="unit" disabled="disabled" type="text" class="form-control"  value='+unit[i].unit+'>'+

                                    '<span style="width: 96px;text-align: right;">&nbsp;剩余量：&nbsp;</span><input name="access_buy_amount" disabled="disabled" type="text" class="form-control" value='+unit[i].access_buy_amount+'><br><br>'

                                form.append(d);
                               }
//
                            }

                            $('input:radio[name="unit_id"]').click(function(){
                               var id= $('input:radio[name="unit_id"]:checked').val();
                               var unit_id=new Object();
                                    unit_id.unit_id=id;
                                $.ajax({
                                    type:"POST",
                                    url: "/baichuan_advertisement_manage/ad.plan.getunit",
                                    data:unit_id,
                                    async: false,   //问题的关键，明确是异步提交数据
                                    dataType:'json',
                                    success:function (data) {
                                        console.log(data);
                                        $('select[name="billing_type"]').val(data[0].unit);
                                        $('select[name="billing_type"]').attr('disabled',true);
                                        $('input[name="setting_price"]').val(data[0].price);
                                        $('input[name="setting_price"]').attr('readonly','readonly');
                                        
										                    $('input[name="plan_day_num_cpt"]').prop("disabled",false);
										
                                        if($('input[name="total_cpt"]')) {
                                            $('input[name="total_cpt"]').val(data[0].access_buy_amount);
                                            if(data[0].unit=="4"){
                                            	$('input[name="total_cpt"]').prop('readonly','false');
                                            }
                                            else{
                                            	$('input[name="total_cpt"]').prop('readonly','false');
                                            }
                                            $('input[name="total_cpt"]').unbind("blur");
                                            $('input[name="total_cpt"]').blur(function () {
                                                var value=$(this).val();
                                                var min=0;
                                                var max=data[0].access_buy_amount;
                                                if(value){
                                                    this.value=this.value.replace(/[^0-9-]+/,'');
                                                }
                                                if(parseInt(value)<min||parseInt(value)>max){

                                                    $(this).val(data[0].access_buy_amount);
                                                }
                                            })

                                    }
                                    if($('input[name="total_cpm"]')){
                                        $('input[name="total_cpm"]').val(data[0].access_buy_amount);
                                        $('input[name="total_cpm"]').unbind("blur");
                                        $('input[name="total_cpm"]').blur(function () {
                                            var value=$(this).val()*1;
                                            var min=0;
                                            var max=data[0].access_buy_amount;
                                            $(this).val(value.toFixed(3));
                                            if(parseInt(value)<min||parseInt(value)>max){

                                                $(this).val(data[0].access_buy_amount);
                                            }
                                        })
                                    }
										                  $("#channel_id").trigger("change");
										                 
										                  
                                        get_adposition_type(data);
                                        
                                        cost_type();
                                        function cost_type(){
                                            var charge_id = $('select[name="billing_type"]').val();
                                            console.log(charge_id);
                                            if(charge_id == 0){
                                                $("#postion_price").hide();
                                                $("#budget_cpt").show();
                                                $("#budget_cpm").hide();
                                                $("#ad_tfsj").show();
                                                $("#start_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                                $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                                $("#end_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                                $("#end_date").datepicker("option","maxDate","");
                                                $("#end_date").val("结束时间");
                                            }else {
                                                $("#postion_price").show();
                                                if(charge_id == 4){
                                                    $("#price_way").html("元/天");
//                                                    $("")
                                                    $("#budget_cpm").hide();
                                                    $("#budget_cpt").show();
                                                    $("#ad_tfsj").hide();
                                                    $(".ysl_cpt").html('CPT(天)');
                                                    $('#price').attr('min', $('#price').data('cpt'));
                                                    $("#start_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d",time()+3600*24), ENT_QUOTES); ?>");
                                                    $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d",time()+3600*24), ENT_QUOTES); ?>");
                                            		var charget_val=parseInt($('input[name="total_cpm"]').val());
                                            		var nowDate=new Date("<?php echo htmlspecialchars(date("Y-m-d",time()), ENT_QUOTES); ?>");
                                            		nowDate.setDate(nowDate.getDate()+charget_val);
                                            		    $("#end_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d",time()+3600*24), ENT_QUOTES); ?>");
                                                    $("#end_date").datepicker("option","maxDate",nowDate.format("yyyy-MM-dd"));
                                                    $("#end_date").val(nowDate.format("yyyy-MM-dd"));
                                                }
                                                if(charge_id == 2) {
                                                    $("#price_way").html("元/CPM");
                                                    $("#budget_cpm").show();
                                                    $("#budget_cpt").hide();
                                                    $("#ad_tfsj").show();
                                                    $('#price').attr('min',  $('#price').data('cpm'));
                                                    $("#start_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                                    $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                                    $("#end_date").datepicker("option","minDate","<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
                                                    $("#end_date").datepicker("option","maxDate","");
                                                    $("#end_date").val("结束时间");
                                                    
                                                }
                                            }
                                        };

                                    },
                                    error:function () {

                                    }

                                });

                        });

                        }
//                        选中竞价制合同信息
                    function contract_name_ms1(data) {
                        var unit=data[0].unit;
                        $('.ContractInformation input[name="contract_name"]').val(data[0].contract_name);
                        $('.ContractInformation input[name="company_name"]').val(data[0].company_name);
                        $('.ContractInformation input[name="contract_num"]').val(data[0].contract_name);
                        $('.ContractInformation input[name="total_budget"]').val(data[0].total_budget);


                        var form=$(".ContractInformation .price_box");
                        form.empty();
                    }
//                    根据price unit获取广告位信息
                    function get_adposition_type(data) {
                        var ad_type=new Object();
                            ad_type.price=data[0].price;
                            ad_type.unit=data[0].unit;
                            $.ajax({
                                type:"POST",
                                url: "/baichuan_advertisement_manage/ad.plan.getpositiontype",
                                data:ad_type,
                                async: false,   //问题的关键，明确是异步提交数据
                                dataType:'json',
                                success:function (data) {
                                	 console.log("data0op",data);
                                    var elem=$("select[name='tag_identification']")
                                    elem.empty();
                                   /* elem.append('<option selected value="">请选择广告类型</option>');*/
                                    for(var i=0;i<data.length;i++){
                                    	if(data[i].plan_id=="0" || '<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->tag_identification, ENT_QUOTES); ?>' == data[i].tag_ident){
	                                        name=data[i].tag_ident;
	                                        id=data[i].id;
	                                        elem.append('<option value='+name+'>'+name+'</option>')
                                        }
                                    }
                                    elem.selectpicker('refresh');
                                    
                                    var tag_identifications = $("select[name=tag_identifications]").val();
                                    if(tag_identifications && tag_identifications.length>0){
                                      $('.selectpicker').selectpicker('val',tag_identifications.split(','));
                                    }
                                    
                                },
                                error:function () {

                                }

                            });
                        }

//

                             $(".ad_seat").click(function(){
                             	
                             	 <?php if(!empty(Tpl::$_tpl_vars["plan"]->tag_identification)){; ?>
                             	   $("#tag_identification").val('<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->tag_identification, ENT_QUOTES); ?>');
						         <?php }else{; ?>
						           $("#tag_identification").val('');
						         <?php }; ?>
                            	 //alert($("#tag_identification").val());
                                $(".ad_price_box_3").show();
                                 $(".ad_price_box_2").hide();
                                 
                            });
                            $(".ad_type").click(function(){
                            	<?php if(!empty(Tpl::$_tpl_vars["plan"]->ad_pos_id)){; ?>
                             	   $("#position_id").val('<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->ad_pos_id, ENT_QUOTES); ?>');
                             	<?php }else{; ?>
                            	  $("#position_id").val(0);
						        <?php }; ?>
                            	//alert($("#position_id").val());
                                $(".ad_price_box_2").show();
                                 $(".ad_price_box_3").hide();
                                
                            });
                        //    表单验证
                        var input_valid=function () {
                            var valid1=new Object();

                            $("input[name='total_cpt']").keyup(  valid1.v=function () {
                                console.log();
                                if(this.value){
                                    this.value=this.value.replace(/[^0-9-]+/,'');
                                }

                            }).blur(valid1.v);

                            $('input[name="total_cpm"]').blur(function(){
                                var d=$(this).val()*1;
                                console.log(d);
                                $(this).val(d.toFixed(3));

                        });
                            $('input[name="budget"]').blur(function(){
                                var d=$(this).val()*1;
                                console.log(d);
                                $(this).val(d.toFixed(3));

                        });



                        };
                        input_valid();
                     });
                   </script>
               <!--重新写这段代码  end-->
                <?php if(Tpl::$_tpl_vars["user"]->role_id!=13){; ?>
                <!--======================================================================-->
                <dl>
                    <dt>刊例单价：</dt>
                    <dd>
                        <span id="refer_price" style="color:red;"></span>
                    </dd>
                </dl>
                <?php }; ?>
                <!--合约合同-->
                <!--<dl class="billing_type2">-->
                    <!--<dt>计费方式：</dt>-->
                    <!--<dd>-->
                        <!--<input type="text"  readonly class="itxt" min="0.01" step="0.01" required style="width:200px" id="price1" name="billing_type" value=""/>-->
                    <!--</dd>-->
                    <!--<dd><span style="color:red;margin-left:10px;">*</span></dd>-->
                <!--</dl>-->
                <!--<dl class="billing_type2">-->
                    <!--<dt>位置定价：</dt>-->
                    <!--<dd>-->
                        <!--<input type="text"  readonly class="itxt" min="0.01" step="0.01" required style="width:200px" id="price2" name="setting_price" value=""/>&nbsp;&nbsp;<span id="price_way2">元/CPM</span>-->
                    <!--</dd>-->
                    <!--<dd><span style="color:red;margin-left:10px;">*</span></dd>-->
                <!--</dl>-->
            </div>

            <!--预算设置-->
            <div class="comForm clear">
                <h1>预算设置</h1>
                <div id="budget_cpm" style="display: none">
                <dl>
                    <dt>计划预算量：</dt>
                    <dd>
                        <input id="plan_num" name="total_cpm" min="0" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->total_cpm, ENT_QUOTES); ?>" step="0.01" type="number" class="itxt" size="30" <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>/>&nbsp;&nbsp;CPM
                    </dd>
                </dl>
                <span class="tipstxt">说明：广告计划周期内总的控制量，为“0”时表示不进行总量控制。</span>
                <dl>
                    <dt>每日预算量：</dt>
                    <dd><input id="plan_day_num" name="budget" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['budget'], ENT_QUOTES); ?>" min="0" step="0.01" type="number" class="itxt" size="30" <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>/>&nbsp;&nbsp;CPM
                    </dd>
                </dl>
                 <span class="tipstxt">说明：每日的控制量，为“0”时表示不进行总量控制。</span>
                <dl>
                   <!--<dt>保底点击率：</dt>-->
                    <dd><input type="hidden" id="min_rate" name="ctr_click_rate" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['ctr_click_rate'], ENT_QUOTES); ?>" min="0.01" step="0.01" type="number" class="itxt" size="30" <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>/></dd>
                </dl>
                <dl>
                    <!--<dt>保底点击量：</dt>-->
                    <dd>
                         <input type ="hidden" id="min_hits" name="total_cpc" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['total_cpc'], ENT_QUOTES); ?>" min="0.01" step="0.01" type="number" class="itxt" size="30" <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>/>&nbsp;&nbsp;
                        <!-- <span id="min_hits" name="total_cpc"><?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['total_cpc'], ENT_QUOTES); ?>&nbsp;&nbsp;CPC</span>
                        <input type="text" class="hide" name="total_cpc" id="f_min_hits">-->
                    </dd>
                </dl>
                    </div>
                <!-- cpt预算设置 -->
                <div id="budget_cpt">
                    <dl>
                        <dt>计划预算量：</dt>
                        <dd><input name="total_cpt" id="ysl_cpt" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->total_cpt, ENT_QUOTES); ?>" min="1" step="1" type="number" class="itxt" size="30" required />&nbsp;&nbsp;<span class="ysl_cpt"></span>
                            <span class="tipstxt" style="color:red;">* CPT必须填写计划预算量。</span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>每日预算量：</dt>
                        <dd><input  name="plan_day_num_cpt" value="0" type="text" class="itxt" size="30"/>&nbsp;&nbsp;
                            <span class="tipstxt">说明：每日的控制量，为“0”时表示不进行总量控制。</span>
                        </dd>
                    </dl>
                </div>
            </div>

            <!--投放时间设置-->
            <div class="comForm clear">
                <h1>投放控制</h1>
                <dl>
                    <dt>投放周期：</dt>
                    <dd>
                        <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> id="start_date" name="start_date"  type="text" class="itxt idate fc7" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->start_date,'开始时间'), ENT_QUOTES); ?>" size="12" />
                        至
                        <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> id="end_date"  name="end_date" type="text" class="itxt idate fc7" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->end_date,'结束时间'), ENT_QUOTES); ?>" size="12" />
                    </dd>
                    <?php if(!empty(Tpl::$_tpl_vars["error"]['date'])){; ?>
                    <dd class="tips_error" title="<?php echo htmlspecialchars(Tpl::$_tpl_vars["error"]['date'], ENT_QUOTES); ?>"></dd>
                    <?php }; ?>
                </dl>
                <div class="tipstxt">结束时间为空表示不限结束时间。</div>
                <dl>
                    <div id="ad_tfsj">
                    <dt>广告投放时间：</dt>
                    <dd>
                        <input id="intervals" type="hidden" name="intervals" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->intervals, ENT_QUOTES); ?>" />
                        <label class="irad" for="qt"><input name="all_day_or_not" id="qt" type="radio" value="1" <?php if(Tpl::$_tpl_vars["plan"]->all_day_or_not==1){; ?>checked<?php }; ?> <?php if(!isset(Tpl::$_tpl_vars["plan"])){; ?>checked<?php }; ?>/> 全天投放</label>
                        <label class="irad ml20" for="fsd" id="btnShow1" onClick="ShowDIV('ptime')"><input name="all_day_or_not" <?php if(Tpl::$_tpl_vars["plan"]->all_day_or_not===0){; ?>checked<?php }; ?> id="fsd" type="radio" value="0" /> 分时段投放</label>
                    </dd>
                        </div>
                        <!--遮罩pop start-->
                        <div id="BgDiv" onclick="closeDiv('ptime')"></div>
                        <div id="ptime" class="popdiv pop_time" style="display:none">
                            <div class="dbg">
                                <div class="pmain">
                                    <div class="ptit">
                                        <div class="ptname">时段选择</div>
                                        <div class="ptclose"><a href="javascript:;" onClick="closeDiv('ptime')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
                                    </div>
                                    <div class="dcon">
                                        <div class="HourBox" style="display:block;">
                                            <div class="HourBoxMain clearfix">
                                                <div class="HBMtype">
                                                    <label for="week"><input type="radio" id="week" name="hbmtype" value=""> 整周展示</label>
                                                    <label for="workday"><input type="radio" name="hbmtype" id="workday" value=""> 工作日全天展示</label>
                                                    <label for="weekend"><input type="radio" name="hbmtype" id="weekend" value=""> 休息日全天展示</label>
                                                </div>
                                                <div class="HBMzt"><span class="ztf"></span>&nbsp;投放时间段<span class="ztt"></span>&nbsp;暂停时间段</div>
                                            </div>
                                            <div class="dtli">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="timetab">
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th>日期</th>
                                                        <th>时间段</th>
                                                        <!--<th class="tac">复制到</th>-->
                                                        <th class="tac">00:00 - 05:00</th>
                                                        <th class="tac">06:00 - 11:00</th>
                                                        <th class="tac">12:00 - 17:00</th>
                                                        <th class="tac">18:00 - 23:00</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="select_week_time">
                                                            <span>0<input id="time_0" type="checkbox"></span>
                                                            <span>1<input id="time_1" type="checkbox"></span>
                                                            <span>2<input id="time_2" type="checkbox"></span>
                                                            <span>3<input id="time_3" type="checkbox"></span>
                                                            <span>4<input id="time_4" type="checkbox"></span>
                                                            <span>5<input id="time_5" type="checkbox"></span>
                                                        </td>
                                                        <td class="select_week_time">
                                                            <span>6<input id="time_6" type="checkbox"></span>
                                                            <span>7<input id="time_7" type="checkbox"></span>
                                                            <span>8<input id="time_8" type="checkbox"></span>
                                                            <span>9<input id="time_9" type="checkbox"></span>
                                                            <span>10<input id="time_10" type="checkbox"></span>
                                                            <span>11<input id="time_11" type="checkbox"></span>
                                                        </td>
                                                        <td class="select_week_time">
                                                            <span>12<input id="time_12" type="checkbox"></span>
                                                            <span>13<input id="time_13" type="checkbox"></span>
                                                            <span>14<input id="time_14" type="checkbox"></span>
                                                            <span>15<input id="time_15" type="checkbox"></span>
                                                            <span>16<input id="time_16" type="checkbox"></span>
                                                            <span>17<input id="time_17" type="checkbox"></span>
                                                        </td>
                                                        <td class="select_week_time">
                                                            <span>18<input id="time_18" type="checkbox"></span>
                                                            <span>19<input id="time_19" type="checkbox"></span>
                                                            <span>20<input id="time_20" type="checkbox"></span>
                                                            <span>21<input id="time_21" type="checkbox"></span>
                                                            <span>22<input id="time_22" type="checkbox"></span>
                                                            <span>23<input id="time_23" type="checkbox"></span>
                                                        </td>
                                                    </tr>
                                                    <tr date="1" class="date">
                                                        <td><input name="" class="selectDay" type="checkbox" value="" /></td>
                                                        <td>星期一</td>
                                                        <td>0:00-24:00</td>
                                                        <!--
                                                        <td class="tac">
                                                          <a rel="thisWeek" href="javascript:void(0)">整周</a>
                                                          <a rel="workDay" href="javascript:void(0)">工作日</a>
                                                          <a rel="weekDay" href="javascript:void(0)">休息日</a>
                                                        </td>
                                                        -->
                                                        <td>
                                                            <span class="poinTime time_0">0</span>
                                                            <span class="poinTime time_1">1</span>
                                                            <span class="poinTime time_2">2</span>
                                                            <span class="poinTime time_3">3</span>
                                                            <span class="poinTime time_4">4</span>
                                                            <span class="poinTime time_5">5</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_6">6</span>
                                                            <span class="poinTime time_7">7</span>
                                                            <span class="poinTime time_8">8</span>
                                                            <span class="poinTime time_9">9</span>
                                                            <span class="poinTime time_10">10</span>
                                                            <span class="poinTime time_11">11</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_12">12</span>
                                                            <span class="poinTime time_13">13</span>
                                                            <span class="poinTime time_14">14</span>
                                                            <span class="poinTime time_15">15</span>
                                                            <span class="poinTime time_16">16</span>
                                                            <span class="poinTime time_17">17</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_18">18</span>
                                                            <span class="poinTime time_19">19</span>
                                                            <span class="poinTime time_20">20</span>
                                                            <span class="poinTime time_21">21</span>
                                                            <span class="poinTime time_22">22</span>
                                                            <span class="poinTime time_23">23</span>
                                                        </td>
                                                    </tr>
                                                    <tr date=2 class="date">
                                                        <td><input name="" class="selectDay" type="checkbox" value="" /></td>
                                                        <td>星期二</td>
                                                        <td>00:00-24:00</td>
                                                        <td>
                                                            <span class="poinTime time_0">0</span>
                                                            <span class="poinTime time_1">1</span>
                                                            <span class="poinTime time_2">2</span>
                                                            <span class="poinTime time_3">3</span>
                                                            <span class="poinTime time_4">4</span>
                                                            <span class="poinTime time_5">5</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_6">6</span>
                                                            <span class="poinTime time_7">7</span>
                                                            <span class="poinTime time_8">8</span>
                                                            <span class="poinTime time_9">9</span>
                                                            <span class="poinTime time_10">10</span>
                                                            <span class="poinTime time_11">11</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_12">12</span>
                                                            <span class="poinTime time_13">13</span>
                                                            <span class="poinTime time_14">14</span>
                                                            <span class="poinTime time_15">15</span>
                                                            <span class="poinTime time_16">16</span>
                                                            <span class="poinTime time_17">17</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_18">18</span>
                                                            <span class="poinTime time_19">19</span>
                                                            <span class="poinTime time_20">20</span>
                                                            <span class="poinTime time_21">21</span>
                                                            <span class="poinTime time_22">22</span>
                                                            <span class="poinTime time_23">23</span>
                                                        </td>
                                                    </tr>
                                                    <tr date=3 class="date">
                                                        <td><input name="" class="selectDay" type="checkbox" value="" /></td>
                                                        <td>星期三</td>
                                                        <td>0:00-24:00</td>
                                                        <td>
                                                            <span class="poinTime time_0">0</span>
                                                            <span class="poinTime time_1">1</span>
                                                            <span class="poinTime time_2">2</span>
                                                            <span class="poinTime time_3">3</span>
                                                            <span class="poinTime time_4">4</span>
                                                            <span class="poinTime time_5">5</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_6">6</span>
                                                            <span class="poinTime time_7">7</span>
                                                            <span class="poinTime time_8">8</span>
                                                            <span class="poinTime time_9">9</span>
                                                            <span class="poinTime time_10">10</span>
                                                            <span class="poinTime time_11">11</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_12">12</span>
                                                            <span class="poinTime time_13">13</span>
                                                            <span class="poinTime time_14">14</span>
                                                            <span class="poinTime time_15">15</span>
                                                            <span class="poinTime time_16">16</span>
                                                            <span class="poinTime time_17">17</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_18">18</span>
                                                            <span class="poinTime time_19">19</span>
                                                            <span class="poinTime time_20">20</span>
                                                            <span class="poinTime time_21">21</span>
                                                            <span class="poinTime time_22">22</span>
                                                            <span class="poinTime time_23">23</span>
                                                        </td>
                                                    </tr>
                                                    <tr date=4 class="date">
                                                        <td><input name="" class="selectDay" type="checkbox" value="" /></td>
                                                        <td>星期四</td>
                                                        <td>0:00-24:00</td>
                                                        <td>
                                                            <span class="poinTime time_0">0</span>
                                                            <span class="poinTime time_1">1</span>
                                                            <span class="poinTime time_2">2</span>
                                                            <span class="poinTime time_3">3</span>
                                                            <span class="poinTime time_4">4</span>
                                                            <span class="poinTime time_5">5</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_6">6</span>
                                                            <span class="poinTime time_7">7</span>
                                                            <span class="poinTime time_8">8</span>
                                                            <span class="poinTime time_9">9</span>
                                                            <span class="poinTime time_10">10</span>
                                                            <span class="poinTime time_11">11</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_12">12</span>
                                                            <span class="poinTime time_13">13</span>
                                                            <span class="poinTime time_14">14</span>
                                                            <span class="poinTime time_15">15</span>
                                                            <span class="poinTime time_16">16</span>
                                                            <span class="poinTime time_17">17</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_18">18</span>
                                                            <span class="poinTime time_19">19</span>
                                                            <span class="poinTime time_20">20</span>
                                                            <span class="poinTime time_21">21</span>
                                                            <span class="poinTime time_22">22</span>
                                                            <span class="poinTime time_23">23</span>
                                                        </td>
                                                    </tr>
                                                    <tr date=5 class="date">
                                                        <td><input class="selectDay" name="" type="checkbox" value="" /></td>
                                                        <td>星期五</td>
                                                        <td>0:00-24:00</td>
                                                        <td>
                                                            <span class="poinTime time_0">0</span>
                                                            <span class="poinTime time_1">1</span>
                                                            <span class="poinTime time_2">2</span>
                                                            <span class="poinTime time_3">3</span>
                                                            <span class="poinTime time_4">4</span>
                                                            <span class="poinTime time_5">5</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_6">6</span>
                                                            <span class="poinTime time_7">7</span>
                                                            <span class="poinTime time_8">8</span>
                                                            <span class="poinTime time_9">9</span>
                                                            <span class="poinTime time_10">10</span>
                                                            <span class="poinTime time_11">11</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_12">12</span>
                                                            <span class="poinTime time_13">13</span>
                                                            <span class="poinTime time_14">14</span>
                                                            <span class="poinTime time_15">15</span>
                                                            <span class="poinTime time_16">16</span>
                                                            <span class="poinTime time_17">17</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_18">18</span>
                                                            <span class="poinTime time_19">19</span>
                                                            <span class="poinTime time_20">20</span>
                                                            <span class="poinTime time_21">21</span>
                                                            <span class="poinTime time_22">22</span>
                                                            <span class="poinTime time_23">23</span>
                                                        </td>
                                                    </tr>
                                                    <tr date="6" class="date">
                                                        <td><input class="selectDay" name="" type="checkbox" value="" /></td>
                                                        <td>星期六</td>
                                                        <td>0:00-24:00</td>
                                                        <td>
                                                            <span class="poinTime time_0">0</span>
                                                            <span class="poinTime time_1">1</span>
                                                            <span class="poinTime time_2">2</span>
                                                            <span class="poinTime time_3">3</span>
                                                            <span class="poinTime time_4">4</span>
                                                            <span class="poinTime time_5">5</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_6">6</span>
                                                            <span class="poinTime time_7">7</span>
                                                            <span class="poinTime time_8">8</span>
                                                            <span class="poinTime time_9">9</span>
                                                            <span class="poinTime time_10">10</span>
                                                            <span class="poinTime time_11">11</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_12">12</span>
                                                            <span class="poinTime time_13">13</span>
                                                            <span class="poinTime time_14">14</span>
                                                            <span class="poinTime time_15">15</span>
                                                            <span class="poinTime time_16">16</span>
                                                            <span class="poinTime time_17">17</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_18">18</span>
                                                            <span class="poinTime time_19">19</span>
                                                            <span class="poinTime time_20">20</span>
                                                            <span class="poinTime time_21">21</span>
                                                            <span class="poinTime time_22">22</span>
                                                            <span class="poinTime time_23">23</span>
                                                        </td>
                                                    </tr>
                                                    <tr date="7" class="date">
                                                        <td><input class="selectDay" name="" type="checkbox" value="" /></td>
                                                        <td>星期日</td>
                                                        <td>0:00-24:00</td>
                                                        <td>
                                                            <span class="poinTime time_0">0</span>
                                                            <span class="poinTime time_1">1</span>
                                                            <span class="poinTime time_2">2</span>
                                                            <span class="poinTime time_3">3</span>
                                                            <span class="poinTime time_4">4</span>
                                                            <span class="poinTime time_5">5</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_6">6</span>
                                                            <span class="poinTime time_7">7</span>
                                                            <span class="poinTime time_8">8</span>
                                                            <span class="poinTime time_9">9</span>
                                                            <span class="poinTime time_10">10</span>
                                                            <span class="poinTime time_11">11</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_12">12</span>
                                                            <span class="poinTime time_13">13</span>
                                                            <span class="poinTime time_14">14</span>
                                                            <span class="poinTime time_15">15</span>
                                                            <span class="poinTime time_16">16</span>
                                                            <span class="poinTime time_17">17</span>
                                                        </td>
                                                        <td>
                                                            <span class="poinTime time_18">18</span>
                                                            <span class="poinTime time_19">19</span>
                                                            <span class="poinTime time_20">20</span>
                                                            <span class="poinTime time_21">21</span>
                                                            <span class="poinTime time_22">22</span>
                                                            <span class="poinTime time_23">23</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="dpbtn">
                                                <div class="fr">
                                                    <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" id="checkedDate" value="确定" /></span>
                                                    <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('ptime')" /></span>
                                                    <span class="sbtng ml30"><input name="" type="button" class="ibtng" value="清空" onClick="ClearAllTime()" /></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--遮罩pop end-->


                </dl>
                <dl>
                    <dt>频次控制：</dt>
                    <dd>
                        <select <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> id="frequency_control" name="frequency_control">
                            <option <?php if(!isset(Tpl::$_tpl_vars["plan"]->frequency_control)){; ?>selected<?php }; ?><?php if(Tpl::$_tpl_vars["plan"]->frequency_control===-1){; ?>selected<?php }; ?> value=-1>不限制</option>
                            <option <?php if(Tpl::$_tpl_vars["plan"]->frequency_control===0){; ?>selected<?php }; ?> value=0>根据IP</option>
                            <option <?php if(Tpl::$_tpl_vars["plan"]->frequency_control===1){; ?>selected<?php }; ?> value=1>根据COOKIE</option>
                            <?php if(Tpl::$_tpl_vars["config"]['version'] == 'operator'){; ?>
                            <option <?php if(Tpl::$_tpl_vars["plan"]->frequency_control===2){; ?>selected<?php }; ?> value=2>根据手机号</option>
                            <option <?php if(Tpl::$_tpl_vars["plan"]->frequency_control===3){; ?>selected<?php }; ?> value=3>优先根据手机号，其次IP</option>
                            <option <?php if(Tpl::$_tpl_vars["plan"]->frequency_control===3){; ?>selected<?php }; ?> value=4>根据IMEI</option>
                            <?php }; ?>
                        </select>
                    </dd>
                </dl>
                <div class="tipstxt">不限预算时,每日投放量没有上限,设置预算后,当消费达到预算后即不再投放。</div>


                <div id="limit_1" style="display:none">
                    <dl>
                        <dt>投放限制：</dt>
                        <dd>
                            <label class="irad">
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> id="control_method_a" type="radio" name="control_method" value="1" <?php if(Tpl::$_tpl_vars["plan"]->day_num==1){; ?>checked<?php }; ?><?php if(empty(Tpl::$_tpl_vars["plan"]->day_num)){; ?>checked<?php }; ?>/>按日控制
                            </label>
                            <label class="irad ml20">
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> id="control_method_b" type="radio" name="control_method" value="2" <?php if(isset(Tpl::$_tpl_vars["plan"]->day_num) && Tpl::$_tpl_vars["plan"]->day_num==7){; ?>checked<?php }; ?>/>按周控制
                            </label>
                            <label class="irad ml20">
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> id="control_method_c" type="radio" name="control_method" value="3" <?php if(isset(Tpl::$_tpl_vars["plan"]->day_num) && Tpl::$_tpl_vars["plan"]->day_num==30){; ?>checked<?php }; ?>/>按月控制
                            </label>
                        </dd>
                    </dl>
                    <div id="control_by_day">
                        <dl>
                            <dt></dt>
                            <dd>
                                单用户两次投放的间隔时间:
                                <?php if(Tpl::$_tpl_vars["plan"]->day_num==1){; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" class="itxt" size="5" name="time_interval_day" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->time_interval,600), ENT_QUOTES); ?>">秒<br />
                                <?php }else{; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" class="itxt" size="5" name="time_interval_day" value="600">秒<br />
                                <?php }; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="hidden" name="day_num_day" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->day_num,1), ENT_QUOTES); ?>"/>
                                每天单用户最多投放多少:&nbsp&nbsp&nbsp&nbsp<input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" name="show_num_day" class="itxt" size="5" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->show_num,3), ENT_QUOTES); ?>" >次
                            </dd>
                        </dl>
                    </div>

                    <div id="control_by_week" style="display:none">
                        <dl>
                            <dt></dt>
                            <dd>
                                单用户两次投放的间隔时间:
                                <?php if(Tpl::$_tpl_vars["plan"]->day_num==7){; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" class="itxt" size="5" name="time_interval_week" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->time_interval/3600,24), ENT_QUOTES); ?>">小时<br />
                                <?php }else{; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" class="itxt" size="5" name="time_interval_week" value="24">小时<br />
                                <?php }; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="hidden" name="day_num_week" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->day_num,7), ENT_QUOTES); ?>"/>
                                每周单用户最多投放多少:&nbsp&nbsp&nbsp&nbsp<input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" name="show_num_week" class="itxt" size="5" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->show_num,3), ENT_QUOTES); ?>" >次
                            </dd>
                        </dl>
                    </div>

                    <div id="control_by_month" style="display:none">
                        <dl>
                            <dt></dt>
                            <dd>
                                单用户两次投放的间隔时间:
                                <?php if(Tpl::$_tpl_vars["plan"]->day_num==30){; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" class="itxt" size="5" name="time_interval_month" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->time_interval/86400,6), ENT_QUOTES); ?>">天<br />
                                <?php }else{; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" class="itxt" size="5" name="time_interval_month" value="6">天<br />
                                <?php }; ?>
                                <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="hidden" name="day_num_month" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->day_num,30), ENT_QUOTES); ?>"/>
                                每月单用户最多投放多少:&nbsp&nbsp&nbsp&nbsp<input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> type="text" name="show_num_month" class="itxt" size="5" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->show_num,3), ENT_QUOTES); ?>" >次
                            </dd>
                        </dl>
                    </div>
                    <div class="tipstxt">这里限制每一个用户的投放频次</div>
                </div>
                <input type="hidden" value="" id="submit_or_not" name="submit_or_not"/>

                <script>
                    function ClearAllTime(){
                        $(".HBMtype  input").attr("checked",false);
                        $(".select_week_time  input").attr("checked",false);
                        $(".date  input").attr("checked",false);
                        $("td.select_week_time span input").prop("checked",false);
                        $(".selectDay").parents("tr").find("span.poinTime").removeClass("ptsel");
                        $("selectDay").prop("checked",false);
                        $("span.poinTime").removeClass("ptsel");
                    };
                    $(document).ready(function(){
                    	var item = $('input[name=position_type][checked]').val(); 
                    	 if(item==2){
                    		 
                                 $(".ad_price_box_3").slideDown("slow");
                                  $(".ad_price_box_2").hide();
                            
                    	}  else {
                    		 $(".ad_price_box_2").slideDown("slow");
                             $(".ad_price_box_3").hide();
                    	}
                    	 
                        $("#frequency_control").change(function(){
                            if($(this).val()!=-1){ $("#limit_1").show(); }else{ $("#limit_1").hide()}
                        }).trigger("change");;
                        $("#control_method_a").click(function(){
                            $("#control_by_day").show();
                            $("#control_by_week").hide();
                            $("#control_by_month").hide();
                        });
                        $("#control_method_b").click(function(){
                            $("#control_by_day").hide();
                            $("#control_by_week").show();
                            $("#control_by_month").hide();
                        });
                        $("#control_method_c").click(function(){
                            $("#control_by_day").hide();
                            $("#control_by_week").hide();
                            $("#control_by_month").show();
                        });
                        $("input[name='control_method']:checked").click();
                    });
                </script>
                <script>
                //广告投放时间 时段选择
                $(document).ready(function(){
                    $("#budget_b").click(function(){
                        $("#_IDbudget").show();
                    });
                    $("#budget_a").click(function(){
                        $("#_IDbudget").hide();
                    });
                    if ($("#budget_b").prop("checked")) {
                        $("#_IDbudget").show();
                    };
                    $("#budget").change(function(){
                        $("#budget_b").val($("#budget").val());
                    });
                    $("#week").click(function(){
                        $("td.select_week_time span input").prop("checked",false);
                        $("td.select_week_time span input").removeClass("ptsel");
                        $("tr[class=date] input ").prop("checked",true);
                        $("span.poinTime").addClass("ptsel");
                    });
                    $("#workday").click(function(){
                        $("td.select_week_time span input").prop("checked",false);
                        $("td.select_week_time span input").removeClass("ptsel");
                        $("span.poinTime").addClass("ptsel");
                        $("tr[date=6] span.poinTime").removeClass("ptsel");
                        $("tr[date=7] span.poinTime").removeClass("ptsel");
                        $("tr[class=date] input ").prop("checked",true);
                        $("tr[date=6] input ").prop("checked",false);
                        $("tr[date=7] input ").prop("checked",false);
                    });
                    $("#weekend").click(function(){
                        $("td.select_week_time span input").prop("checked",false);
                        $("td.select_week_time span input").removeClass("ptsel");
                        $("span.poinTime").removeClass("ptsel");
                        $("tr[date=6] span.poinTime").addClass("ptsel");
                        $("tr[date=7] span.poinTime").addClass("ptsel");
                        $("tr[class=date] input ").prop("checked",false);
                        $("tr[date=6] input ").prop("checked",true);
                        $("tr[date=7] input ").prop("checked",true);
                    });
                    $("#checkedDate").click(function(){
                        var intervals = "1:";
                        $("tr[date=1] span.ptsel").each(function(i, item){
                            intervals += $(item).html() + ",";
                        });
                        intervals += ";2:";
                        $("tr[date=2] span.ptsel").each(function(i, item){
                            intervals += $(item).html() + ",";
                        });
                        intervals += ";3:";
                        $("tr[date=3] span.ptsel").each(function(i, item){
                            intervals += $(item).html() + ",";
                        });
                        intervals += ";4:";
                        $("tr[date=4] span.ptsel").each(function(i, item){
                            intervals += $(item).html() + ",";
                        });
                        intervals += ";5:";
                        $("tr[date=5] span.ptsel").each(function(i, item){
                            intervals += $(item).html() + ",";
                        });
                        intervals += ";6:";
                        $("tr[date=6] span.ptsel").each(function(i, item){
                            intervals += $(item).html() + ",";
                        });
                        intervals += ";7:";
                        $("tr[date=7] span.ptsel").each(function(i, item){
                            intervals += $(item).html() + ",";
                        });
                        $("#intervals").val(intervals);
                        closeDiv('ptime');
                        
                    });
                    if ($("#intervals").val() != "") {
                        var intervals = $("#intervals").val().split(";");
                        for (var i in intervals) {
                            var t = intervals[i].split(":");
                            var d = t[0];
                            var x = t[1].split(",");
                            $("tr[date=" + d + "] span.poinTime").each(function(i, item){
                                var html = $(this).html();
                                if (x.indexOf(html) != -1) {
                                    $(this).addClass("ptsel");
                                }
                            });
                        }
                    }
                    $("td.select_week_time span input").click(function(){
                        var i_id = $(this).attr("id");
                        if ($(this).prop("checked")) {
                            $("." + i_id).addClass("ptsel");
                        }
                        else {
                            $("." + i_id).removeClass("ptsel");
                        }
                    });
                    $(".selectDay").click(function(){
                        if ($(this).prop("checked")) {
                            $(this).parents("tr").find("span.poinTime").addClass("ptsel");
                        }
                        else {
                            $(this).parents("tr").find("span.poinTime").removeClass("ptsel");
                        }
                    });
                    $("span.poinTime").click(function(){
                        if ($(this).hasClass("ptsel")) {
                            $(this).removeClass("ptsel");
                        }
                        else {
                            $(this).addClass("ptsel");
                        }
                    });
                });
            </script>
                <!--
                      <dl>
                        <dt>投放限制：</dt>
                        <dd>
                          每天的CPC控制:<input type="text" class="itxt" size="5" name="day_cpc" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->day_cpc,1), ENT_QUOTES); ?>"><br />
                          每天的CPM控制:<input type="text" class="itxt" size="5" name="day_cpm" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->day_cpm,1), ENT_QUOTES); ?>"><br />
                        </dd>
                      </dl>
                      <div class="tipstxt">这里限制每天的投放设置，-1为不限制</div>
                -->

                <dl>
                    <dt>投放频次：</dt>
                    <dd>
                        <?php /*          <label class="irad" for="bz"><input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> name="smooth_control" id="bz" <?php if(Tpl::$_tpl_vars["plan"]->smooth_control==0){; ?>checked<?php }; ?> type="radio" value="0" /> 平滑控制</label>*/?>
                        <label class="irad ml20" for="unl"><input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> name="smooth_control" id="unl" <?php if(Tpl::$_tpl_vars["plan"]->smooth_control==2 or !Tpl::$_tpl_vars["plan"]->smooth_control){; ?>checked<?php }; ?> type="radio" value="2" /> 标准，以尽量多获取曝光为目标</label><br />
                        <label class="irad ml20" for="yuns"><input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> name="smooth_control" id="yuns" <?php if(Tpl::$_tpl_vars["plan"]->smooth_control==1){; ?>checked<?php }; ?> type="radio" value="1" /> 匀速，以尽量覆盖全时段为目标</label>
                    </dd>
                </dl>

            </div>

            <!--btn-->
            <div class="comForm">
                <dl>
                    <dt>&nbsp;</dt>
                    <dd>
          <span class="sbtnb">
            <?php if(!empty(Tpl::$_tpl_vars["plan_id"])){; ?>
            <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> <?php if(isset(Tpl::$_tpl_vars["plan"])&&(Tpl::$_tpl_vars["plan"]->verified_or_not==1)){; ?> disabled <?php }; ?> name="" type="button" class="ibtnb save" onclick="editSave()" value="保存" />
<?php }else{; ?>
            <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> <?php if(isset(Tpl::$_tpl_vars["plan"])&&(Tpl::$_tpl_vars["plan"]->verified_or_not==1)){; ?> disabled <?php }; ?> name="" type="button" class="ibtnb save" onclick="addSave()" value="保存并继续" />
<?php }; ?>
          </span>

                        <?php if(!user_api::auth("admin")){; ?>
          <span class="sbtnb" style="margin-left:20px;">
<?php if(!empty(Tpl::$_tpl_vars["plan_id"])){; ?>
            <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> <?php if(isset(Tpl::$_tpl_vars["plan"])&&(Tpl::$_tpl_vars["plan"]->verified_or_not==1)){; ?> disabled <?php }; ?> name="" type="button" class="ibtnb save"  onclick="addSubmit()" value="提交审核" />
<?php }else{; ?>
            <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> <?php if(isset(Tpl::$_tpl_vars["plan"])&&(Tpl::$_tpl_vars["plan"]->verified_or_not==1)){; ?> disabled <?php }; ?> name="" type="button" onclick="addSubmit()" class="ibtnb save" value="提交审核并继续" />
<?php }; ?>
          </span>
                        <?php }; ?>
                    </dd>
                </dl>
            </div>

        </form>
    </div>
</div>


<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</div>
<script>
// 保存计划
var addoncheck = function(){
    if( !$("#plan_name").val() ){
        alert("计划名称没有填写");
        return false;
    }else if($("#cate").val()==0 && $("#ta_cate").val()==0){
        alert("请选择广告类型");
        return false;
    }else if( isNaN(parseFloat($("#price").val())) ){
        alert("位置定价为必填项");
        return false;
    }else if(parseFloat($("#hidden_price").val()) > parseFloat($("#price").val())){
        alert("出价不能低于刊例价");
        return false;
    }else if($("#charge_id").val()==0 ){
        alert("计费方式没有选择");
        return false;
    }else if(parseFloat($("#hidden_price").val()) > parseFloat($("#price").val())){
        alert("出价不能低于刊例价");
        return false;
    }else if( $("#charge_id").val()==1){
        if(parseFloat($("#plan_num").val()) < 0 ){
            alert("计划预算量不能为负");
            return false;
        }else if(parseFloat($("#plan_day_num").val()) < 0 ){
            alert("每日预算量不能为负");
            return false;
        }/*else if(parseFloat($("#min_rate").val()) < 0 ){
            alert("保底点击率不能为负");
             return false;
        }*/else if( parseFloat($('#plan_day_num').val())>parseFloat($('#plan_num').val()) ){
            alert("每日预算量超过了计划预算量");
            return false;   
        }
    }
    return true;
};
$("form").validate({ 
    submitHandler: function(form){
        if(addoncheck()){
            form.submit();
        }
    },
    errorClass:"fcr"
});

function editSave(){
    var status = <?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>;
    if(status == 2){
//        layer.confirm('修改将停投当前广告，确认修改？', function(){
            $("#submit_or_not").val(0);
            $("#plan_form").submit();
//        });
    }else {
        $("#submit_or_not").val(0);
        $("#plan_form").submit();
    }

}
function canSubmit(){
  if($("#billing_type").val()=="1"){
     var val=$("select[name=contract_id] option:selected").attr("data-money"),
     price=$("input[name=setting_price]").val(),
     plan=$("input[name=total_cpm]").val()
     if(price*plan>val)return false
  }
  return true
}
function addSave(){
    if(!canSubmit()){
      layer.msg("该合同剩余金额不足，请重新输入位置定价或计划预算量");
      return;
    }
    $("select[name=billing_type]").prop("disabled",false);
    $("#submit_or_not").val(0);
    
    var tags = $(".selectpicker").val();
    if(tags && tags.length > 0){
      $("input[name='tag_identifications']").val(tags.join(","))
    }

    $("#plan_form").submit();
}

function editSubmit(){
    if(!canSubmit()){
      layer.msg("该合同剩余金额不足，请重新输入位置定价或计划预算量");
      return;
    }
    var status = <?php echo htmlspecialchars(Tpl::$_tpl_vars["status"], ENT_QUOTES); ?>;
    var tags = $(".selectpicker").val();
    if(tags && tags.length > 0){
      $("input[name='tag_identifications']").val(tags.join(","))
    }

    if(status == 2){
        layer.confirm('修改将停投当前广告，确认修改？', function(){
            $("#submit_or_not").val(1);
            $("select[name=billing_type]").prop("disabled",false);
            $("#plan_form").submit();
        });
    }else{
        $("select[name=billing_type]").prop("disabled",false);
        $("#submit_or_not").val(1);
        $("#plan_form").submit();
    }

}
function addSubmit(){
    if(!canSubmit()){
      layer.msg("该合同剩余金额不足，请重新输入位置定价或计划预算量");
      return;
    }
    layer.confirm('直接提交将无法修改广告计划，是否继续？', function(){
    	var tags = $(".selectpicker").val();
	    if(tags && tags.length > 0){
	      $("input[name='tag_identifications']").val(tags.join(","))
	    }
        $("#submit_or_not").val(1);
        $("select[name=billing_type]").prop("disabled",false);
        $("#plan_form").submit();
    });
}
</script>
<script>
    $(function(){
        if(<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["plan"]->is_own,0), ENT_QUOTES); ?>&&"<?php echo htmlspecialchars(Tpl::$_tpl_vars["current_user"]->uid, ENT_QUOTES); ?>"==="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->uid, ENT_QUOTES); ?>"){
            $('#addToSelf').click();
            $('#zyys').toggle();
            $('#khjl').toggle();
            $('#ssggz').toggle();
            $('#ad_info').hide();
            $('#ad_info_self').show();
        }
        else{
          <?php if(!empty(Tpl::$_tpl_vars["plan"]->uid)){; ?>
             $('#zyys').toggle();
              $('#khjl').toggle();
              $('#ssggz').toggle();
              $('#ad_info').hide();
              $('#ad_info_self').show();
          <?php }; ?>
        }
        $("#addToSelf").change(function(){
            if($(this).is(':checked')){
                $('#zyys').hide();
                $('#khjl').hide();
                $('#ssggz').hide();
                $('#ad_info').hide();
                $('#ad_info_self').show();
            }else{            
                $('#zyys').show();
                $('#khjl').show();
                $('#ssggz').show();
                $('#ad_info').show();
                $('#ad_info_self').hide();
            }
            $("#billing_type").trigger('change');
        })
        $("#platform").change(function(){
            $("#position_id option").remove();
            var media_id = $(this).val();
            var hidden_channel_id = $("#hidden_channel_id").val();
            $.ajax({
                cache: true,
                type: "GET",
                url:"/baichuan_advertisement_manage/ad.plan.GetWebsites."+media_id,
                async: false,
                error: function(request) {
                    alert("获取频道出错");
                },
                success: function(data) {
                    $("#channel_id option").remove();
                    try{
                        var obj = eval(data);
                    }catch(e){
                        var obj = { };
                    }
                    var length = obj.length;
                    for(var i = 0 ;i < length ;i++ ){
                        if(hidden_channel_id == obj[i].channel_id){
                            $("#channel_id").append( $("<option selected ></option>").text(obj[i].channel_name).attr('value', obj[i].channel_id) );
                        }else{
                            $("#channel_id").append($("<option ></option>").text(obj[i].channel_name).attr('value', obj[i].channel_id));
                        }
                    }
                    $("#channel_id").trigger("change");
                }
            });
        });
       /** $("#platform").click(function(){
                var media_id = $(this).val();
            if(media_id==1){
                $("#jslx").attr("style","display:none");
            }else if(media_id==2){
                $("#jslx").attr("style","display:block");
                $("#hidden_price").val(0);
                $("#refer_price").html("￥"+"0.0000"+"&nbsp;/&nbsp;CPM");
            }
        }); */
    })
  
</script>
<script>
    $(function(){
        /**计费方式显示 */
//        $("#charge_id").change(cost_type);
        $("#charge_id").change(function(){
            cost_type();
        });
        
        
     	$('input[name="plan_day_num_cpt"]').on(
     		{
     			"change":function(){
     				var val=$("input[name=total_cpt]").val()||0;
     				if(parseInt($(this).val())>val)$(this).val(val)
     				else if(parseInt($(this).val())==0)$(this).val(0)
     			},
     			"keyup":function(){
     				$(this).val($(this).val().replace(/\D/g,''));
     			}
     		});
        
       function cost_type(){
            var charge_id = $("#charge_id").val();
            console.log(charge_id);
            if(charge_id == 0){
                $("#postion_price").hide();
                $("#budget_cpt").show();
                $("#budget_cpm").hide();
                $("#ad_tfsj").show();
            }else {
                $("#postion_price").show();
                if(charge_id == 4){
                	var valid1=new Object();
                    $("#price_way").html("元/天");
                    $("input[name='setting_price']").keyup(  valid1.v=function () {
                        console.log();
                        if(this.value){
                            this.value=this.value.replace(/[^0-9-]+/,'');
                        }

                    }).blur(valid1.v);

                    $("#budget_cpm").hide();
                    $("#budget_cpt").show();
                    $("#ad_tfsj").hide();
                    $(".ysl_cpt").html('CPT(天)')
                    $('#price').attr('min', $('#price').data('cpt'));
                }
                if(charge_id == 2) {
                    $("#price_way").html("元/CPM");
                    $('input[name="setting_price"]').blur(function(){
                        var d=$(this).val()*1;
                        $(this).val(d.toFixed(3));

                    });

                    $("#budget_cpm").show();
                    $("#budget_cpt").hide();
                    $("#ad_tfsj").show();
                    $('#price').attr('min',  $('#price').data('cpm'));
                }
            }
        };
        $("#source_id").change(function(){
            var source_id = $(this).val();//子运营商id
            var hidden_channel_id = $("#hidden_channel_id").val();
        $.ajax({
            cache: true,
            type: "GET",
            url:"/baichuan_advertisement_manage/ad.plan.getWebsites."+ source_id,
            async: false,
            error: function(request) {
                alert("获取频道 出错");
            },
            success: function(data) {
                $("#channel_id option").remove();
                try{
                    var obj = eval(data);
                }catch(e){
                    var obj = { };
                }                    var length = obj.length;
                for(var i = 0 ;i < length ;i++ ){
                    if(hidden_channel_id == obj[i].channel_id){
                        $("#channel_id").append($("<option selected ></option>").text(obj[i].channel_name).attr('value', obj[i].channel_id) );
                    }else {
                        $("#channel_id").append($("<option ></option>").text(obj[i].channel_name).attr('value', obj[i].channel_id));
                    }

                }
               $("#channel_id").trigger("change");
            }
        });

    });
        $("#channel_id").change(function(){
            var channel_id = $(this).val();
            var hidden_position_id = $("#hidden_position_id").val();
            var unit=$('select[name="billing_type"]').val();
            var price,plan_id;   
            if($('select[name="billing_type"]').prop("disabled"))unit=4
            <?php if(!empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
              price = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->setting_price, ENT_QUOTES); ?>";
              plan_id = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->plan_id, ENT_QUOTES); ?>";
            <?php }else{; ?>
              price=$('input[name="setting_price"]').val();
              plan_id=$("input[name='plan_id']").val(); 
            <?php }; ?>
            if(!(price && price.length>0)){
            	alert("请填写位置定价"); 
            	return false
            }
        $.ajax({
            cache: true,
            type: "GET",
             url:"/baichuan_advertisement_manage/ad.plan.GetPositions."+ channel_id+"."+unit+"."+price+"."+plan_id,
            async: false,
            error: function(request) {
                alert("获取广告位出错");
            },
            success: function(data) {
                $("#position_id option").remove();
                try{
                    var obj = eval(data);
                }catch(e){
                    var obj = { };
                }                    var length = obj.length;
                  $("#position_id").append($('<option value="">--请选择广告位--</option>'));
                for(var i = 0 ;i < length ;i++ ){
                	if(parseFloat(obj[i].cpm) <= parseFloat(price) && (obj[i].plan_id == "0" || '<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->ad_pos_id, ENT_QUOTES); ?>'== obj[i].id)){
	                    if(hidden_position_id == obj[i].uid){
	                        $("#position_id").append($("<option selected ></option>").text(obj[i].position_name).attr('value', obj[i].id) );
	                    }else {
	                        $("#position_id").append($("<option ></option>").text(obj[i].position_name).attr('value', obj[i].id));
	                    }
					}
                }
               // $("#channel_id").trigger("change");
            }
        });

    });
        
        //当CMP总量一定，保底点击率变化后，保底点击量也变化 预算总量plan_num，保底点击率min_rate min_hits
        /*$("#min_rate").add("#plan_num").on('input',function(){
            var plan_num = $("#plan_num").val(); // 预算总量
            var rate = $("#min_rate").val();

            if(plan_num>0&&rate>0){            
                var hits = parseInt(plan_num*rate*10);
                $("#min_hits").html(hits+"&nbsp;&nbsp;CPC");
                $("#f_min_hits").val(hits);
            }else{
                $("#min_hits").html("&nbsp;&nbsp;CPC");
                $("#f_min_hits").val(0);
            }
        });*/

        var myuid = <?php echo htmlspecialchars(Tpl::$_tpl_vars["uid"], ENT_QUOTES); ?>;
        //所属子运营商和客户经理还有广告主的关联关系
        $("#sub_carriers").change(function(){
                var carriers_id = $(this).val();//子运营商id
                if(!carriers_id) return;
                var userType = $(this).attr("type");
                var hidden_market_id = $("#hidden_market_id").val();
                $("#ad_number").hide();
                $("#ad_balance").hide();
                carriers_id = carriers_id||myuid;
            $.ajax({
                cache: true,
                type: "GET",
                url:"/baichuan_advertisement_manage/admin.user.Getcarriers."+ carriers_id+ userType,
                async: false,
                error: function(request) {
                    alert("获取客户经理出错");
                },
                success: function(data) {
                    $("#account_manager option").remove();
                    try{
                        var obj = eval(data);
                    }catch(e){
                        var obj = { };
                    }                    var length = obj.length;
                    for(var i = 0 ;i < length ;i++ ){
                        if(hidden_market_id == obj[i].uid){
                            $("#account_manager").append($("<option selected ></option>").text(obj[i].user_name).attr('value', obj[i].uid) );
                        }else {
                            $("#account_manager").append($("<option ></option>").text(obj[i].user_name).attr('value', obj[i].uid));
                        }

                    }
                    $("#account_manager").trigger("change");
                }
            });

        });
        //通过客户经理id获取广告主信息
        $("#account_manager").change(function(){
            var account_manager_id = $(this).val();
            var userType = $(this).attr("type");
            var hidden_bind_id = $("#hidden_bind_id").val();
            $("#ad_number").hide();
            $("#ad_balance").hide();
            account_manager_id = account_manager_id||myuid;
            $.ajax({
                cache: true,
                type: "GET",
                url:"/baichuan_advertisement_manage/admin.user.Getcarriers."+ account_manager_id+ userType,
                async: false,
                error: function(request) {
                    alert("获取广告主出错");
                },
                success: function(data) {
                    $("#ad_owner option").remove();
                    try{
                        var obj = eval(data);
                    }catch(e){
                        var obj = { };
                    }
                    var length = obj.length;
                    for(var i = 0 ;i < length ;i++ ){
                        if(hidden_bind_id == obj[i].uid){
                            $("#ad_owner").append($("<option data-number="+obj[i].account+" data-account="+escape(obj[i].user_name)+" value="+obj[i].uid+" selected ></option>").text(obj[i].user_name+"|￥"+obj[i].account+"元") );
                        }else {
                            $("#ad_owner").append($("<option data-number="+obj[i].account+" data-account="+escape(obj[i].user_name)+" value="+obj[i].uid+" ></option>").text(obj[i].user_name+"|￥"+obj[i].account+"元") );
                        }
                    }
                    $("#ad_owner").trigger("change");
                }
            });

        });

        //显示广告主信息
         $("#ad_owner").change(function(){
            var ad_id = $(this).val(); //账号
            ad_id = ad_id || myuid;
             $.ajax({
                 cache: true,
                 type: "GET",
                 url:"/baichuan_advertisement_manage/admin.user.GetAdInfo."+ ad_id,
                 async: false,
                 error: function(request) {
                     alert("获取广告主账号信息出错");
                 },
                 success: function(data) {
                     $("#ad_number").show();
                     $("#ad_balance").show();
                    try{
                        var obj = eval(data);
                    }catch(e){
                        var obj = { };
                    }
                     $("#ad_number").html(obj[0].user_name);
                     if(obj[0].account =="0.0000"){
                         $("#ad_balance").html("￥"+obj[0].account+"元"+"（您的账户余额为0，请及时充值！）");
                         $("#ad_balance").attr("style","color:red");

                     }else {
                         $("#ad_balance").html("￥"+obj[0].account+"元");
                         $("#ad_balance").removeAttr("style");
                     }
                     if($("#billing_type").val()&&$("#billing_type").val()!=0){
                       <?php if(empty(Tpl::$_tpl_vars["plan"]->plan_id)){; ?>
                        $("#billing_type").trigger("change");
                       <?php }; ?>
                     }
                     //$("#ad_info_self").hide();
                     //$("#ad_info").show();
                 }
             });
        });

        /** 归属设置显示 hidden_role_id
            * */
        setTimeout(function(){
            var role_id = $("#hidden_role_id").val();
            if(role_id == 10000 || role_id == 1000){
                $("#sub_carriers").trigger("change");
            }else if(role_id == 18){ //子运营商账号
                $("#sub_carriers").trigger("change");
                $("#zyys").remove();
            }else if(role_id == 12){ //客户经理账号
                $("#account_manager").trigger("change");
                $("#zyys").remove();
                $("#khjl").remove();

            }else if(role_id == 13){ //广告主账号
                $("#gssz").remove();
                 //默认加载广告主
            }
        },0);

        
        $("#charge_id").trigger("change");
        //cpt总量天数和截止时间变化关系
        $("#ysl_cpt").change(function(){
                var cpt_day = $(this).val();  //cpt投放总天数
                var start = $("#start_date").val();
                var m= Math.round(new Date(start).getTime()/1000); //开始时间的时间戳

                var  v = parseInt(cpt_day*86400)+parseInt(m)-86400;

                var t = new Date(parseInt(v) * 1000);
                var b = t.getFullYear() + '-' + (t.getMonth()+1) + '-' + t.getDate();
                $("#end_date").val(b);

        });
        $('#end_date').add('#start_date').change(function(){
            var s = $('#start_date').val();
            var e = $('#end_date').val();
            if(s && e){
                s= new Date(s);
                e= new Date(e);
                var day = (e.getTime() - s.getTime())/86400000;
                if(day>=0)
                    $("#ysl_cpt").val(day+1);
            }
        });
/*
        $("#channel_id").change(function(){
            var channel_id = $(this).val();
            var hidden_position_id = $("#hidden_ad_pos_id").val();
            $.ajax({
                cache: true,
                type: "GET",
                url:"/baichuan_advertisement_manage/ad.plan.GetPositions."+ channel_id,
                async: false,
                error: function(request) {
                    alert("获取广告位置出错");
                },
                success: function(data) {
                    $("#position_id option").remove();
                    var obj = eval(data);
                    var length = obj.length;
                    for(var i = 0 ;i < length ;i++ ){

                        if(obj[i].id == hidden_position_id){

                            $("#position_id").append("<option data-price="+obj[i].cpm+" value="+obj[i].id+" selected >"+obj[i].position_name+"|￥"+obj[i].cpm+"元/CPM"+"</option>");
                        }else{
                            $("#position_id").append("<option data-price="+obj[i].cpm+" value="+obj[i].id+" >"+obj[i].position_name+"|￥"+obj[i].cpm+"元/CPM"+"</option>");
                        }
                    }
                    $("#position_id").trigger("change");
                }
            });
        });
        $("#position_id").change(function(){
            var position_id = $(this).val();
            $.ajax({
                cache: true,
                type: "GET",
                url:"/baichuan_advertisement_manage/ad.plan.GetPrice."+ position_id,
                async: false,
                error: function(request) {
                    alert("获取广告价格出错");
                },
                success: function(data) {
                    try{
                        var obj = eval(data);
                    }catch(e){
                        console.error('获取广告价格出错');
                        return;
                    }
                    $("#hidden_price").val(obj[0].cpm);
                    $('#price').attr('min', obj[0].cpm);
                    $("#refer_price").html("￥"+obj[0].cpm+"&nbsp;/&nbsp;CPM");
                }
            });
        });
        $("#platform").trigger("change");
// 价格与媒体关系（旧2017-2/20）
*/
        $("#tag_identification").change(function(){
            var selopt = $(this).find('option:selected');
            $("#hidden_price").val(selopt.data('cpm'));

            $("#price").data('cpm', selopt.data('cpm')).data('cpt', selopt.data('cpt'));
            $("#charge_id").trigger("change");
            
            $("#refer_price").html(["￥",selopt.data('cpm'),"&nbsp;/&nbsp;CPM","&nbsp;&nbsp;&nbsp;￥"+selopt.data('cpt')+"&nbsp;/&nbsp;CPT"].join('')).data('');
        })
        
       <?php if(!empty(Tpl::$_tpl_vars["plan"]->contract_type)){; ?>
           $("#billing_type").trigger("change");
       <?php }; ?>
       <?php if(!empty(Tpl::$_tpl_vars["plan"]->media_id)){; ?>
           $("#source_id").trigger("change");
       <?php }; ?>
       <?php if(!empty(Tpl::$_tpl_vars["plan"]->channel_id)){; ?>
           $("#channel_id").trigger("change");
       <?php }; ?>
       <?php if(!empty(Tpl::$_tpl_vars["plan"]->setting_price)){; ?>
           $("input[name=setting_price]").val("<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->setting_price, ENT_QUOTES); ?>").trigger("change");
           setTimeout(function(){
           $("#position_id").val('<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->ad_pos_id, ENT_QUOTES); ?>');
           },100)
           $("select[name=tag_identification]").val('<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->tag_identification, ENT_QUOTES); ?>')
       <?php }; ?>
        
        /* 反选值  */
        
        
          
       
    });
    //自动保存广告计划
 /**  function autoSave(){
        if($("#cate").val()==0 && $("#ta_cate").val()==0){
            alert("请选择广告类型");
            return false;
        }
        alert("即将自动保存");
        $("#submit_or_not").val(0);
        $("#plan_form").submit();
    }
    setTimeout(autoSave,60000); */
    function showPosition(){
    	$("#f").show();
    	$("#displaypositiontype").hide();
    }
</script>
<script type="text/javascript">
$(document).ready(function(){
	 $("#sub_carriers").change(function(){
		console.log($(this).val());
	});	
});

Date.prototype.format = function(format) {
    var date = {
       "M+": this.getMonth() + 1,
       "d+": this.getDate(),
       "h+": this.getHours(),
       "m+": this.getMinutes(),
       "s+": this.getSeconds(),
       "q+": Math.floor((this.getMonth() + 3) / 3),
       "S+": this.getMilliseconds()
    };
    if (/(y+)/i.test(format)) {
       format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
    }
    for (var k in date) {
       if (new RegExp("(" + k + ")").test(format)) {
           format = format.replace(RegExp.$1, RegExp.$1.length == 1
              ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
       }
    }
    return format;
}
</script>
</body>
</html>

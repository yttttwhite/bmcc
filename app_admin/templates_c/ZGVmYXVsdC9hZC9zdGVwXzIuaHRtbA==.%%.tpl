<!DOCTYPE html>
<html>
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
<style>
  .popdiv{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
  }
  .flex-middle{
    display: flex;
    display: -webkit-flex;
    display: -moz-box;
    align-items: center;
    justify-content: center;
  }
  .select-box{
    width:120px;
    height:120px;
    border:1px dashed #67A0DC;
    border-radius: 5px;
    cursor:pointer;
  }
  .select-box > span{
    color:#666;
  }
  .select-col  input{
    display: none;
  }
  .select-mar{
    margin:20px 0 ;
  }
  .select-mar tr{
    border-top:1px solid #ddd;
  }
  .button-remove{
    background: lightyellow;
  }
</style>
<script>
function select_all(flag,name){ //全选或取消
    var inputs = document.getElementsByTagName("input");     
    for(var i=0;i<inputs.length;i++)     
    {     
      if(inputs[i].getAttribute("type") == "checkbox" && inputs[i].getAttribute("name") == name)     
      {     
        if(flag==1)
        inputs[i].checked = true;
        else{
            if(inputs[i].checked == true)
                inputs[i].checked = false;
            else
                inputs[i].checked = true;
        }
      }     
    }     
  }
</script>
</head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>

<!--main-->
<div class="main">
  <div class="side">
<?php echo htmlspecialchars(tpl_function_part("/ad.plan.listpart.".Tpl::$_tpl_vars["plan_id"].".".Tpl::$_tpl_vars["group_id"]), ENT_QUOTES); ?>
  </div>
  
  <!--mcon-->
  <div class="mcon">
      <div class="step">
          <div class="step2" style="padding:0;">
              <div id="prevplan" class="pull-left" style="height:100%;width:227px;">
                  <a href="/baichuan_advertisement_manage/ad.plan.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>?back=/ad.group.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>" style="height:100%;width:100%;display:block"></a>
              </div>
              <div id="curgroup" class="pull-left" style="height:100%;width:227px;">
              </div>
              <div id="nextstaff" class="pull-left" style="height:100%;width:227px;">
                  <a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["backstaff"], ENT_QUOTES); ?>" style="height:100%;width:100%;display:block"></a>
              </div>
            </div>
      </div>
    <form method="post" action="/baichuan_advertisement_manage/ad.group.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["group"]->group_id,0), ENT_QUOTES); ?>"> 

    <input type="hidden" name="plan_id" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>" />
    <input type="hidden" name="group_id" value="<?php echo htmlspecialchars(tpl_modifier_default(Tpl::$_tpl_vars["group"]->group_id,0), ENT_QUOTES); ?>" />
    <input type="hidden" name="channels" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['position_identification'], ENT_QUOTES); ?>"/>
    <!--基本信息-->
    <div class="comForm clear">
      <h1>基本信息</h1>
      <dl>
        <dt>广告组名称：</dt>
        <dd><input <?php echo htmlspecialchars(Tpl::$_tpl_vars["groupReadonly"], ENT_QUOTES); ?> name="name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["group"]->name, ENT_QUOTES); ?>" type="text" class="itxt" size="30" /></dd>
        <!--<dd class="tips_error">输入错误</dd>-->
      </dl>
      <div class="tipstxt">建议您根据媒体、人群或活动内容来命名，以便于调整投放和报表查看。</div>
      
      <dl>
        <dt>导入广告组：</dt>
        <dd>
          <select <?php echo htmlspecialchars(Tpl::$_tpl_vars["groupReadonly"], ENT_QUOTES); ?> id="selYear" onchange="var id=$('#selYear').val();location='/baichuan_advertisement_manage/ad.group.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>?loaded_id='+id;">
			<option value="0">请选择</option>
			<?php foreach(Tpl::$_tpl_vars["groups"] as Tpl::$_tpl_vars["_group"]){; ?>
			<option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->group_id, ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["loaded_id"]==Tpl::$_tpl_vars["_group"]->group_id){; ?>selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["_group"]->name, ENT_QUOTES); ?></option>
			<?php }; ?>
          </select>
        </dd>
      </dl>
    </div>
    
    <script>
    $(document).ready(function(){
            $('#renqunmt input[type="checkbox"]').change(function() {
              var l = $('#renqunmt input[type="checkbox"]:checked').not('.crowd_title').length;
              if(l<1){ $('#rqmt').parent().next().next().text("没有选择标签")}else{ $('#rqmt').parent().next().next().text($('#renqunmt input[type="checkbox"]:checked').not('.crowd_title').parent().text())}
            });
            $('#shuxingmt input[type="checkbox"]').change(function() {
              var l = $('#shuxingmt input[type="checkbox"]:checked').length;
              if(l<1){ $('#sxmt').parent().next().next().text("没有选择标签")}else{ $('#sxmt').parent().next().next().text($('#shuxingmt input[type="checkbox"]:checked').not('.crowd_title').parent().text())}
            });


            $(".regArea >.regas > input").click(function(){
                if($(this).prop("checked")){
                    $(this).parent().find("li>input").prop("checked",true);
                }else{
                    $(this).parent().find("li>input").prop("checked",false);
                }
            });
            $(".regas").mouseover(function(){ $(this).find("ul").show(); }).mouseleave(function(){ $(this).find("ul").hide(); });
            $(".regas >ul input").click(function(){ 
                var checked=false;
                $(this).parents("label").find("li>input").each(function(i,item){
                    if($(item).prop("checked")){ checked=true;; }
                });
                $(this).parents("label").find(">input").prop("checked",checked);
            });

            //区域
            $(".regatit").click(function(){
                $(this).parent().find(".regas input").prop("checked",$(this).find("input").prop("checked"));
            });
            $("#area_all").click(function(){
                $(this).parents(".region").find("input").prop("checked",true);
            });
            $("#area_all_no").click(function(){
                $(this).parents(".region").find("input").each(function(i,item){
                    $(item).prop("checked",!$(item).prop("checked"));
                    });
            });
            $("#area_ok").click(function(){
                var id_s="";
                var id_n="";
                $(this).parents(".region").find(".regas >input:checked").each(function(i,item){
                    console.log($(item).val());
                    id_s+=$(item).val()+":";
                    id_n+=$(item).attr("data")+":";
                    $(item).parent().find("ul input:checked").each(function(i,item){
                    id_s+=$(item).val()+",";
                    id_n+=$(item).attr("data")+",";
                    });
                    id_s+=";";
                    id_n+=";";

                });
                $("#area_value").val(id_s);
                $("#area_lable").val(id_n);
                closeDiv('preg');
            });

            //1,2线
            $(".otcltit").click(function(){
                $(this).parent().find("input").prop("checked",$(this).find("input").prop("checked"));
            });
            $(".otclc").mouseover(function(){ $(this).find("ul").show(); }).mouseleave(function(){ $(this).find("ul").hide(); });
            $(".otclc > input").click(function(){
                if($(this).prop("checked")){
                    $(this).parent().find("li>input").prop("checked",true);
                }else{
                    $(this).parent().find("li>input").prop("checked",false);
                }
            });
            $(".otclc >ul input").click(function(){ 
                var checked=false;
                $(this).parents("label").find("li>input").each(function(i,item){
                    if($(item).prop("checked")){ checked=true;; }
                });
                $(this).parents("label").find(">input").prop("checked",checked);
            });
            $("#crowds_all").click(function(){
                $(this).parents(".pmain").find("input").prop("checked",true);
            });
            $("#crowds_all_no").click(function(){
                $(this).parents(".pmain").find("input").each(function(i,item){
                    $(item).prop("checked",!$(item).prop("checked"));
                    });
            });
            $("#city_all").click(function(){
                $(this).parents(".otcity").find("input").prop("checked",true);
            });
            $("#city_all_no").click(function(){
                $(this).parents(".otcity").find("input").each(function(i,item){
                    $(item).prop("checked",!$(item).prop("checked"));
                    });
            });
            $("#city_ok").click(function(){
                var id_s="";
                var id_n="";
                $(this).parents(".otcity").find("input:checked[value]").each(function(i,item){
                    console.log($(item).val());
                    id_s+=$(item).val()+",";
                    id_n+=$(item).attr("data")+",";

                });
                $("#area_value").val(id_s);
                $("#area_lable").val(id_n);
                closeDiv('potcity');
            });
            $("#qg").click(function(){
                $("#area_value").val("");
                $("#area_lable").val("");
            });

            //设置预设数据
            <?php if(Tpl::$_tpl_vars["plan"]->platform !=1){; ?>
            var ids = ($("#area_value").val()||"").split(/[:,;]/);
            if(ids){
                var i_1=0;
                var i_2=0;
                $(".regas input").each(function(i,item){
                        if(ids.indexOf($(item).val())!==-1){
                        $(item).prop("checked",true);
                        i_1++;
                        }
                });
                $(".otcity input").each(function(i,item){
                        if(ids.indexOf($(item).val())!==-1){
                        i_2++;
                        $(item).prop("checked",true);
                        }
                });
                if(i_1>0 && i_1>=i_2) $("#xztf").prop("checked",true);
                if(i_2>0 && i_2>i_1)$("#xzcs").prop("checked",true);
            }
            <?php }; ?>
			var defaultType = parseInt($("input[name=exchange_or_ta]:checked").val());
            if(defaultType == 1){
				$("#exchange_container").hide();
				$("#ta_container").show();
                }else{
				$("#exchange_container").show();
				$("#ta_container").hide();
			}
            if(<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan"]->platform, ENT_QUOTES); ?> ==1){
                $("#exchange_container").hide();
                $("#ta_container").show();
                }
            else{
                $("#exchange_container").show();
                $("#ta_container").hide();
            }
			$("input[name=exchange_or_ta]").click(function(){
				var type = parseInt($("input[name=exchange_or_ta]:checked").val());
				switch(type) {
					case 1:
						$("#exchange_container").hide();
						$("#ta_container").show();
						break;
						
					case 2:
						$("#exchange_container").show();
						$("#ta_container").hide();
						break;
						
					default: 
						return;
				}
			});
			var ismouseDown = false;
			/*弹窗可以拖动*/
			$(".ptit").on({
			  'mousedown':function(e){
			    e.preventDefault();
			    console.log(e.button)
			    var pop = $(this).closest(".popdiv");
			    ismouseDown = true;
			    gapX=e.pageX-pop.offset().left;  
          gapY=e.pageY-pop.offset().top;
          
			     $(document).mousemove(function (event) {
              if (ismouseDown) {
                  var top = (event.clientY - gapY) > 0 ? (event.clientY - gapY) : 0;
                  var left = (event.clientX - gapX) > 0 ? (event.clientX - gapX) : 0;
                  top = (top-$(window).height() + pop.height()) > 0 ?($(window).height() - pop.height()):top;
                  left = (left-$(window).width() + pop.width()) > 0 ?($(window).width() - pop.width()):left;
                  pop.css({
                  top:top,
                  left:left,
                  transform:'translate(0,0)'
                });
              }
              return false;
          }).mouseup(
              function () {
              ismouseDown = false;
          });
			  }
			});
    });
    </script>
    <?php Tpl::$_tpl_vars["plan"]->platform = 1; ?>
    <!--定向设置-->
    <div class="comForm clear">
      <h1>定向设置</h1>
      <h2>地域定向</h2>
      <dl>
        <dt>地区选择：</dt>
        <?php if(Tpl::$_tpl_vars["plan"]->platform !=1){; ?>
        <dd>
        <input type="hidden" id="area_value" name="area_value" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["group"]->area_value, ENT_QUOTES); ?>" />
        <input type="hidden" id="area_lable" name="area_lable" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["group"]->area_lable, ENT_QUOTES); ?>" />
          <label class="irad" for="qg"><input name="area_lable_tmp" id="qg" type="radio" <?php if(Tpl::$_tpl_vars["group"]->area_lable==0){; ?>checked<?php }; ?> value="0" /> 全国</label>
          <label class="irad ml20" for="xztf"><input name="area_lable_tmp" id="xztf" type="radio" value="" onClick="ShowDIV('preg')" /> 选择投放地区</label>
          <!--遮罩pop start-->
          <div id="BgDiv"></div>
          <div id="preg" class="popdiv pop_region" style="display:none">
            <div class="dbg">
              <div class="pmain">
              <div class="ptit">
                <div class="ptname">选择投放地区</div>
                <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('preg')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
              </div>
              <div class="dcon">
                <div class="region">
<?php foreach(Tpl::$_tpl_vars["area_region"] as Tpl::$_tpl_vars["k"]=>Tpl::$_tpl_vars["_area"]){; ?>
                  <div class="regArea">
                    <label class="regatit" for="area_<?php echo htmlspecialchars(Tpl::$_tpl_vars["k"], ENT_QUOTES); ?>" style="float:none; width:100%;"><input id="area_<?php echo htmlspecialchars(Tpl::$_tpl_vars["k"], ENT_QUOTES); ?>" type="checkbox" value="" /> <?php echo htmlspecialchars(Tpl::$_tpl_vars["k"], ENT_QUOTES); ?></label>
<?php foreach(Tpl::$_tpl_vars["_area"] as Tpl::$_tpl_vars["__area"]){; ?>

                    <label class="regas" for="area_<?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['id'], ENT_QUOTES); ?>" style="position:relative">
                        <input id="area_<?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['id'], ENT_QUOTES); ?>" data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['area_name'], ENT_QUOTES); ?>" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['id'], ENT_QUOTES); ?>" /> <?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['area_name'], ENT_QUOTES); ?>
<?php if(!empty(Tpl::$_tpl_vars["__area"]['childs'])){; ?>
                        <ul style="display: none;padding: 5px;position:absolute;top: 30px;left:0px;z-index:999;background-color: #ccc;width: 155px;max-height: 200px;overflow: auto;">
                        <?php foreach(Tpl::$_tpl_vars["__area"]['childs'] as Tpl::$_tpl_vars["city"]){; ?>
                    	<label class="regas" for="area_<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['id'], ENT_QUOTES); ?>" style="position:relative">
                            <li><input id="area_<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['id'], ENT_QUOTES); ?>" data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['area_name'], ENT_QUOTES); ?>" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['id'], ENT_QUOTES); ?>"> <?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['area_name'], ENT_QUOTES); ?></li>
			</label>
                        <?php }; ?>
                        </ul>
<?php }; ?>
                    </label>
<?php }; ?>
                  </div>
<?php }; ?>
                  <div class="dpbtn">
                    <div class="fl">
                      <span class="sbtng"><input type="button" class="ibtng" id="area_all" value="全选"  /></span>
                      <span class="sbtng ml15"><input type="button" class="ibtng" id="area_all_no" value="反选" /></span>
                    </div>
                    <div class="fr">
                      <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" id="area_ok" value="确定"/></span>
                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('preg')" /></span>
                    </div>
                  </div>
                  
                </div>              
              </div>
              </div>
            </div>
          </div>
          <!--遮罩pop end-->
          
          <label class="irad ml20" for="xzcs"><input name="area_lable_tmp" id="xzcs" type="radio" value="" onClick="ShowDIV('potcity')" /> 选择一二线城市投放</label>
          <!--遮罩pop start-->
          <div id="BgDiv"></div>
          <div id="potcity" class="popdiv pop_otcity" style="display:none">
            <div class="dbg">
              <div class="pmain">
              <div class="ptit">
                <div class="ptname">选择一二线城市投放</div>
                <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('potcity')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
              </div>
              <div class="dcon">
                <div class="otcity">
                  <div class="otcli">
                    <label class="otcltit" for="hb" style="float:none; width:100%;"><input type="checkbox" /> 一线城市</label>
<?php foreach(Tpl::$_tpl_vars["area_level"][1] as Tpl::$_tpl_vars["__area"]){; ?>
                    <label class="otclc" for="city_<?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['id'], ENT_QUOTES); ?>" style="position:relative">
                        <input id="city_<?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['id'], ENT_QUOTES); ?>" data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['area_name'], ENT_QUOTES); ?>" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['id'], ENT_QUOTES); ?>" /> <?php echo htmlspecialchars(Tpl::$_tpl_vars["__area"]['area_name'], ENT_QUOTES); ?>
<?php if(!empty(Tpl::$_tpl_vars["__area"]['childs'])){; ?>
                        <ul style="display: none;padding: 5px;position:absolute;top: 30px;left:0px;z-index:999;background-color: #ccc;width: 155px;max-height: 200px;overflow: auto;">
                        <?php foreach(Tpl::$_tpl_vars["__area"]['childs'] as Tpl::$_tpl_vars["city"]){; ?>
                            <li><input id="city_<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['id'], ENT_QUOTES); ?>" data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['area_name'], ENT_QUOTES); ?>" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['id'], ENT_QUOTES); ?>"> <?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['area_name'], ENT_QUOTES); ?></li>
                        <?php }; ?>
                        </ul>
<?php }; ?>
                    </label>
<?php }; ?>
                  </div>
                  
                  <div class="otcli">
                    <label class="otcltit" for="db" style="float:none; width:100%;"><input id="db" type="checkbox"/> 二线城市</label>
<?php foreach(Tpl::$_tpl_vars["area_level"][2] as Tpl::$_tpl_vars["_area"]){; ?>
                    <label class="otclc" for="city_<?php echo htmlspecialchars(Tpl::$_tpl_vars["_area"]['id'], ENT_QUOTES); ?>"><input id="city_<?php echo htmlspecialchars(Tpl::$_tpl_vars["_area"]['id'], ENT_QUOTES); ?>" type="checkbox" data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_area"]['area_name'], ENT_QUOTES); ?>" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_area"]['id'], ENT_QUOTES); ?>" /> <?php echo htmlspecialchars(Tpl::$_tpl_vars["_area"]['area_name'], ENT_QUOTES); ?></label>
<?php }; ?>
                  </div>
                  
                  <div class="dpbtn">
                    <div class="fl">
                      <span class="sbtng"><input type="button" id="city_all" class="ibtng" value="全选"  /></span>
                      <span class="sbtng ml15"><input id="city_all_no" type="button" class="ibtng" value="反选" /></span>
                    </div>
                    <div class="fr">
                      <span class="sbtnb ml30"><input type="button" class="ibtnb" id="city_ok" value="确定" /></span>
                      <span class="sbtng ml15"><input type="button" class="ibtng" value="取消" onClick="closeDiv('potcity')" /></span>
                    </div>
                  </div>
                  
                </div>              
              </div>
              </div>
            </div>
          </div>
          <!--遮罩pop end-->
       
        </dd>
        <?php }else{; ?>
        <dd>
            <dd id="beijing_container" class="sp" style="margin-left:60px; padding: 10px; border: 1px solid #DDDDDD;">
            选择北京地区：
            <hr style="margin:5px 0;">
            <div class="rqli accordion" id="xzbj">
            <?php foreach(Tpl::$_tpl_vars["area_level"][1] as Tpl::$_tpl_vars["__area"]){; ?>
                <?php if(Tpl::$_tpl_vars["__area"]['area_name'] == "北京"){; ?>    
                    <?php foreach(Tpl::$_tpl_vars["__area"]['childs'] as Tpl::$_tpl_vars["city"]){; ?>
                        <label class="rqxz">
                            <input name="bj_area[]" data="<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['area_name'], ENT_QUOTES); ?>" type="checkbox" 
                            <?php if(in_array(Tpl::$_tpl_vars["city"]['id'],explode(",",Tpl::$_tpl_vars["group"]->area_value))){; ?>checked<?php }; ?> value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['id'], ENT_QUOTES); ?>">
                            <em><?php echo htmlspecialchars(Tpl::$_tpl_vars["city"]['area_name'], ENT_QUOTES); ?></em>
                        </label>
                        <?php }; ?>
                <?php }; ?>
            <?php }; ?>
            </div>
            <div class="fl">
                <span class="sbtng"><input type="button" class="ibtng" id="area_all" value="全选"  onclick="select_all(1,'bj_area[]')"/></span>                                                                             
                <span class="sbtng ml15"><input type="button" class="ibtng" id="area_all_no" value="反选" onclick="select_all(0,'bj_area[]')"/></span>
            </div> 
        </dd>
        <?php }; ?>
      </dl>
      <h2>无线投放</h2>
      <?php if(Tpl::$_tpl_vars["plan"]->platform != 1){; ?>
      <dl>
        <dt>无线投放设置：</dt>
        <dd>
          <label class="irad" for="is_mobile_0"><input id="is_mobile_0" name="mobile" <?php if(empty(Tpl::$_tpl_vars["group"]->mobile)){; ?>checked<?php }; ?> type="radio" value="0"/>不限PC和mobile</label>
          <label class="irad m240" for="is_mobile_1"><input id="is_mobile_1" name="mobile" <?php if(Tpl::$_tpl_vars["group"]->mobile==1){; ?>checked<?php }; ?> type="radio" value="1"/>仅投放PC</label>
          <label class="irad m120" for="is_mobile_2"><input id="is_mobile_2" name="mobile" <?php if(Tpl::$_tpl_vars["group"]->mobile==2){; ?>checked<?php }; ?> type="radio" value="2"/>仅投放mobile</label>
        </dd>
    </dl>
    <?php }; ?>
      	<dl>
        	<dt>终端类型：</dt>
			<dd>
				<label for="os3"><input id="os3" class="os" name="os[]" type="checkbox" <?php if(in_array('iphone',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="iphone"/>iPhone</label>
	            <label for="os4"><input id="os4" class="os" name="os[]" type="checkbox" <?php if(in_array('android',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="android"/>Android</label>
			</dd>
		</dl>
        <!--客户bug单问题描述：无线投放中，浏览器还有"IE"等浏览器。选择"android"，还可以选择safari浏览器   修改：屏蔽掉-->
		<!--<dl>
         <dt>浏览器：</dt>
         <dd>
             <label for="agent1"><input id="agent1" class="agent" name="agent[]" type="checkbox" <?php if(in_array('safari',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="safari"/>Safari</label>
             <label for="agent1"><input id="agent1" class="agent" name="agent[]" type="checkbox" <?php if(in_array('ie',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="ie"/>IE</label>
             <label for="agent2"><input id="agent2" class="agent" name="agent[]" type="checkbox" <?php if(in_array('360',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="360"/>360</label>
             <label for="agent3"><input id="agent3" class="agent" name="agent[]" type="checkbox" <?php if(in_array('sougou',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="sougou"/>搜狗</label>
             <label for="agent4"><input id="agent4" class="agent" name="agent[]" type="checkbox" <?php if(in_array('firefox',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="firefox"/>Firefox</label>
             <label for="agent5"><input id="agent5" class="agent" name="agent[]" type="checkbox" <?php if(in_array('qq',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="qq"/>qq浏览器</label>
             <label for="agent6"><input id="agent6" class="agent" name="agent[]" type="checkbox" <?php if(in_array('aoyou',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="aoyou"/>遨游</label>
             <label for="agent7"><input id="agent7" class="agent" name="agent[]" type="checkbox" <?php if(in_array('chrome',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="chrome"/>Chrome</label>
             <label for="agent8"><input id="agent8" class="agent" name="agent[]" type="checkbox" <?php if(in_array('uc',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="uc"/>UC</label>
             <label for="agent9"><input id="agent9" class="agent" name="agent[]" type="checkbox" <?php if(in_array('liebao',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="liebao"/>猎豹</label>
			 <label for="agent10"><input id="agent10" class="agent" name="agent[]" type="checkbox" <?php if(in_array('micromessenger',Tpl::$_tpl_vars["include_useragent"])){; ?>checked<?php }; ?> value="micromessenger"/>微信</label>
		 </dd>
     </dl>-->

      <!-- 人群定向 -->
      <h2>人群定向</h2>
      <dl>
        <dt>人群选择：</dt>
        <dd style="width: 77%;">
          <input name="media_value" id="media_value" type="hidden" value=""/>
          <input name="media_label" id="media_label" type="hidden" value=""/>
          <label class="irad" for="rqmt">
          	<input name="user_tag_type" value="1" id="rqmt" type="radio" onclick="ShowDIV('renqunmt')" <?php if(Tpl::$_tpl_vars["group"]->colum2 == 1){; ?> checked <?php }; ?>> 按标准人群
		      </label>
          <br>
          <!-- <span class="text-info small ml-10"></span>
          <pre class="hide"><?php echo htmlspecialchars(Tpl::$_tpl_vars["CrowdsString"], ENT_QUOTES); ?></pre> -->
		  <!--<label class="irad ml20" for="rqdy">
		  	<input name="user_tag_type" value="2" id="rqdy" type="radio"  onclick="ShowDIV('renqundy')" <?php if(Tpl::$_tpl_vars["group"]->colum2 == 2){; ?> checked <?php }; ?>> 按定义人群
	      </label>-->
		  
		  <!--标准人群-->
          <!--遮罩pop start-->
          <div id="BgDiv"></div>
          <div id="renqunmt" class="popdiv pop_renqun" style="display: none;">
            <div class="dbg">
              <div class="pmain">
               <div class="ptit">
                <div class="ptname">选择人群</div>
                <div class="ptclose"><a href="javascript:;" id="btnClose" onclick="closeDiv('renqunmt')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭"></a></div>
               </div>
               <div class="dcon">
                  <!--toolbar start--> 
                  <div class="toolbar-bc">
                  <!--
                    <div id="adjihua" class="selMenu smzt mr15">
                        <span class="smtit">媒体类型</span>
                        <ul>
                          <li><a href="javascript:;">标准人群</a></li>
                        </ul>
                    </div>
                      -->
                    <!--<span class="iSearch">
                      <a class="isicon" href="#"><img src="/baichuan_advertisement_manage/assets_admin/img/i_search.gif" alt="搜索"></a>
                      <input type="text" class="search itxt fc7" onkeydown="if (event.keyCode==13) { }" onblur="if(this.value=='')value='人群名称';" onfocus="if(this.value=='人群名称')value='';" value="人群名称" size="30">
                  </span>-->
                    <div class="clear">
                      <div class="fl">
                        <span class="sbtng"><input id="user_tag_type_1" type="button" class="ibtng" value="选择标签"  /></span>
                        <span class="sbtng ml15"><input id="user_tag_type_2" type="button" class="ibtng" value="手动录入" /></span>
                      </div>
                    </div>
                  </div>
                  <input name="usertags_type" id="usertags_type" type="hidden" value="1"/>
                  <script type="text/javascript">
                    var user_tag_c = 1;
                    $('#user_tag_type_2').click(function(){
                      user_tag_c = 2;
                      $('.accordion2').show();
                      $('.accordion1').hide();
                      $('#renqunmt .ibtngf').hide();
                    });
                    $('#user_tag_type_1').click(function(){
                      $('#renqunmt .ibtngf').show();
                      $('.accordion1').show();
                      $('.accordion2').hide();
                      user_tag_c = 1;
                    });
                    function ibtnb_ok(){
                      $('#usertags_type').val(user_tag_c);
                      if(user_tag_c == 1){
                        $("#usertag_manual").val('');
                      }
                      if(user_tag_c == 2){
                        $('#renqunmt').find('input:checkbox').prop("checked", false);
                      }
                      closeDiv('renqunmt');
                    };
                  </script>
                  <div class="rqli accordion">

                    <div class="accordion1" <?php if(Tpl::$_tpl_vars["usertags_type"] == 2){; ?>style="display: none;"<?php }; ?>>
                        <?php foreach(Tpl::$_tpl_vars["crowds_default"] as Tpl::$_tpl_vars["_c"]){; ?>
                        <div>
                            <div class="rqltit <?php if(in_array(Tpl::$_tpl_vars["_c"]['tag_code'], Tpl::$_tpl_vars["usertags_code"]) && Tpl::$_tpl_vars["group"]->colum2 == 1){; ?> active<?php }; ?>">
                                <input class="crowd_title" name="usertag_1[]" id="mrf<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['tag_code'], ENT_QUOTES); ?>" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['tag_code'], ENT_QUOTES); ?>" align="absmiddle" <?php if(in_array(Tpl::$_tpl_vars["_c"]['tag_code'], Tpl::$_tpl_vars["usertags_code"]) && Tpl::$_tpl_vars["group"]->colum2 == 1){; ?> checked<?php }; ?>>
                                <?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['tag_name'], ENT_QUOTES); ?>
                            </div>
                            <div class="rqlcon" style="display:block;">
                                <?php if(!empty(Tpl::$_tpl_vars["_c"]['tag_value'])){; ?>
                                    <?php foreach(Tpl::$_tpl_vars["_c"]['tag_value'] as Tpl::$_tpl_vars["_k"] => Tpl::$_tpl_vars["_d"]){; ?>
                                      <label class="rqxz" for="mrf<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['tag_code'], ENT_QUOTES); ?>-<?php echo htmlspecialchars(Tpl::$_tpl_vars["_k"], ENT_QUOTES); ?>">
                                        <input name="usertag_1[]" id="mrf<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['tag_code'], ENT_QUOTES); ?>-<?php echo htmlspecialchars(Tpl::$_tpl_vars["_k"], ENT_QUOTES); ?>" type="checkbox"  <?php if(in_array(Tpl::$_tpl_vars["_c"]['tag_code'].':'.Tpl::$_tpl_vars["_k"], Tpl::$_tpl_vars["group"]->usertags) && Tpl::$_tpl_vars["group"]->colum2 == 1){; ?> checked <?php }; ?> value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['tag_code'], ENT_QUOTES); ?>:<?php echo htmlspecialchars(Tpl::$_tpl_vars["_k"], ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_d"], ENT_QUOTES); ?>
                                      </label>
                                    <?php }; ?>
                                <?php }; ?>
                            </div>
                        </div>
                      <?php }; ?>
                    </div>

                    <div class="accordion2" <?php if(Tpl::$_tpl_vars["usertags_type"] == 1){; ?>style="display: none;"<?php }; ?>>
                      <div id="ip_pannel_1" class="pdomcon" style="margin: 2px; padding: 5px;">手动输入标签(每行一个)，比如:<br />
                        N_001_001:1<br />
                        N_001_001:2<br />
                        <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="usertag_manual" id="usertag_manual" style="width:100%;height:100%"><?php if(Tpl::$_tpl_vars["usertags_type"] == 2){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->usertags), ENT_QUOTES); ?><?php }; ?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="dpbtn">
                    <div class="fl">
                      <!--<span class="sbtng"><input name="" type="button" class="ibtng" onclick="$('#renqunmt').find('.crowd_title').click()" value="全选"></span>-->
                      <span class="sbtng ml15"><input name="" type="button" class="ibtng ibtngf" onclick="$('#renqunmt').find('.crowd_title').click()" value="反选"></span>
                    </div>
                    <div class="fr">
                      <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" value="确定" onclick="ibtnb_ok()"></span>
                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onclick="closeDiv('renqunmt')"></span>
                    </div>
                  </div>
               </div>
              </div>
            </div>
          </div>
          <!--遮罩pop end-->
          <!--标准人群  end-->

		  <!--自定义人群-->
          <!--遮罩pop start-->
          <div id="BgDiv"></div>
          <div id="renqundy" class="popdiv pop_renqun" style="display:none">
            <div class="dbg">
              <div class="pmain">
              <div class="ptit">
                <div class="ptname">按定义人群</div>
                <div class="ptclose"><a href="javascript:;" id="btnClose" onclick="closeDiv('renqundy')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭"></a></div>
              </div>
              <div class="dcon">
                  <!--toolbar start--> 
                  <div class="toolbar-bc">
                      <!--<span class="iSearch">
                         <a class="isicon" href="#"><img src="/baichuan_advertisement_manage/assets_admin/img/i_search.gif" alt="搜索"></a>
                         <input type="text" class="search itxt fc7" onkeydown="if (event.keyCode==13) { }" onblur="if(this.value=='')value='人群名称';" onfocus="if(this.value=='人群名称')value='';" value="人群名称" size="30">
                     </span>-->
                    <div class="clear"></div>
                  </div>
                  <div class="rqli accordion">
                    <?php foreach(Tpl::$_tpl_vars["user_tags"]->items as Tpl::$_tpl_vars["_c"]){; ?>
                    <div class="rqltit">
		 				<input class="crowd_title" name="usertag_2[]" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['id'], ENT_QUOTES); ?>" type="checkbox" <?php if(in_array(Tpl::$_tpl_vars["_c"]['id'], Tpl::$_tpl_vars["group"]->usertags) && Tpl::$_tpl_vars["group"]->colum2 == 2){; ?> checked <?php }; ?> align="absmiddle" /><?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['name'], ENT_QUOTES); ?><?php if(isset(Tpl::$_tpl_vars["_c"]['coverage'])){; ?><span style="float:right;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['coverage'], ENT_QUOTES); ?></span><?php }; ?>
				    </div>
                    <?php }; ?>
                  </div>
                  <div class="dpbtn">
                    <div class="fl">
                      <span class="sbtng"><input id="crowds_all" type="button" class="ibtng" value="全选"></span>
                      <span class="sbtng ml15"><input id="crowds_all_no" type="button" class="ibtng" value="反选"></span>
                    </div>
                    <div class="fr">
                      <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" value="确定" onclick="closeDiv('renqundy')"></span>
                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onclick="closeDiv('renqundy')"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  <!--自定义人群  end-->
		  
		  
        </dd>
        </dl>
        <dl>
        <dt>人群属性选择：</dt>
        <dd style="width: 77%;">
          <input name="media_value" id="media_value" type="hidden" value=""/>
          <input name="media_label" id="media_label" type="hidden" value=""/>
          <label class="irad" for="sxmt">
              <input name="user_props_type" value="1" id="sxmt" type="radio" onclick="ShowDIV('shuxingmt')" <?php if(!empty(Tpl::$_tpl_vars["props"])){; ?> checked <?php }; ?>> 按标准属性
          </label>
      <br>
          <span class="text-info small ml-10"></span>
		  <pre class="hide"><?php echo htmlspecialchars(Tpl::$_tpl_vars["PropsString"], ENT_QUOTES); ?></pre>
          
          <!--标准属性-->
          <!--遮罩pop start-->
          <div id="BgDiv1"></div>
          <div id="shuxingmt" class="popdiv pop_renqun" style="display: none;">
            <div class="dbg">
              <div class="pmain">
               <div class="ptit">
                <div class="ptname">选择属性</div>
                <div class="ptclose"><a href="javascript:;" id="btnClose" onclick="closeDiv('shuxingmt')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭"></a></div>
               </div>
               <div class="dcon">
                  <!--toolbar start--> 
                  <div class="toolbar-bc">
                    <div class="clear"></div>
                  </div>
                  
                  <div class="rqli accordion">
                    <?php foreach(Tpl::$_tpl_vars["crowds_position"] as Tpl::$_tpl_vars["_c"]){; ?>
                        <div>
                            <div class="rqltit active">
                                <input class="crowd_title" name="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['data']['name'], ENT_QUOTES); ?>[]" id="mrf<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['data']['id'], ENT_QUOTES); ?>" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['data']['id'], ENT_QUOTES); ?>" align="absmiddle" <?php if(in_array(Tpl::$_tpl_vars["_c"]['data']['id'], Tpl::$_tpl_vars["props"])){; ?> checked <?php }; ?>>
                                <?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['data']['name'], ENT_QUOTES); ?><?php if(isset(Tpl::$_tpl_vars["_c"]['data']['coverage'])){; ?><em class="tag-coverage">[<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['data']['coverage'], ENT_QUOTES); ?>]</em><?php }; ?>
                            </div>
                            <div class="rqlcon" style="display:block;">
                             <?php if(!empty(Tpl::$_tpl_vars["_c"]['child'])){; ?>
                              <?php foreach(Tpl::$_tpl_vars["_c"]['child'] as Tpl::$_tpl_vars["_d"]){; ?>
                              <label class="rqxz" for="mrf<?php echo htmlspecialchars(Tpl::$_tpl_vars["_d"]['id'], ENT_QUOTES); ?>">
                                  <input name="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_c"]['data']['name'], ENT_QUOTES); ?>[]" id="mrf<?php echo htmlspecialchars(Tpl::$_tpl_vars["_d"]['id'], ENT_QUOTES); ?>" type="checkbox"  <?php if(in_array(Tpl::$_tpl_vars["_d"]['id'], Tpl::$_tpl_vars["props"])){; ?> checked <?php }; ?> value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["_d"]['id'], ENT_QUOTES); ?>">
                                <?php echo htmlspecialchars(Tpl::$_tpl_vars["_d"]['name'], ENT_QUOTES); ?><?php if(isset(Tpl::$_tpl_vars["_d"]['coverage'])){; ?><em class="tag-coverage">[<?php echo htmlspecialchars(Tpl::$_tpl_vars["_d"]['coverage'], ENT_QUOTES); ?>]</em><?php }; ?>
                              </label>
                              <?php }; ?>
                             <?php }; ?>
                            </div>
                        </div>
                    <?php }; ?>
                  </div>
                
                  <div class="dpbtn">
                    <div class="fr">
                      <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" value="确定" onclick="closeDiv('shuxingmt')"></span>
                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onclick="closeDiv('shuxingmt')"></span>
                    </div>
                  </div>
               </div>
              </div>
            </div>
          </div>
          <!--遮罩pop end-->
          <!--标准属性  end-->
          
        </dd>
      </dl>
        <script>
            $(".search").keyup(function(){
              var v=$(this).val();
              $(this).parents(".dcon").find("label.rqxz").hide();
              $(this).parents(".dcon").find("label.rqxz:contains('"+v+"')").show();;
            });
        </script>
          <!--遮罩pop end-->
<?php if(false&&Tpl::$_tpl_vars["config"]['version'] == "operator"){; ?>
        <dl>
          <dt>用户类型定向：</dt>
          <dd>
          <label class="irad"      for="is_usertype_0"><input id="is_usertype_0" name="usertype" <?php if(empty(Tpl::$_tpl_vars["group"]->usertype)){; ?>checked<?php }; ?> type="radio" value="0"/>不限ADSL和专线</label>
          <label class="irad m240" for="is_usertype_1"><input id="is_usertype_1" name="usertype" <?php if(Tpl::$_tpl_vars["group"]->usertype==1){; ?>checked<?php }; ?> type="radio" value="1"/>仅投放ADSL用户</label>
          <label class="irad m120" for="is_usertype_2"><input id="is_usertype_2" name="usertype" <?php if(Tpl::$_tpl_vars["group"]->usertype==2){; ?>checked<?php }; ?> type="radio" value="2"/>仅投放专线用户</label>
          </dd>
        </dl>
<?php }; ?>
        <!-- 用户标签 -->
          <!--遮罩pop end-->
<?php if(Tpl::$_tpl_vars["config"]['version'] == "operator"){; ?>
        <?php if(Tpl::$_tpl_vars["roleId"] >=0){; ?>
      <dl>
          <dt>黑白名单：</dt>
          <dd>
          <label class="irad" for="ip_balck"><span class="sbtng"><input name="xzmt" id="ip_black" type="button"  onClick="ShowDIV('pip')" class="ibtng" value="IP黑白名单"/></span></label>
          
          <!--遮罩pop start-->
          <!--div id="BgDiv"></div-->
          <div id="pip" class="popdiv pop_domain" style="display:none">
            <div class="dbg">
              <div class="pmain">
              <div class="ptit">
                <div class="ptname">IP黑白名单</div>
                <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('pip')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
              </div>
              <div class="dcon">
                  <div class="clear">
                    <div class="fl">
                      <span class="sbtng">        <input id="ip_set_1" type="button" class="ibtng" value="IP白名单"  /></span>
                      <span class="sbtng ml15">    <input id="ip_set_2" type="button" class="ibtng" value="IP黑名单" /></span>
                    </div>
                  </div>
                  <script>
                  $("#ip_set_1").click(function(){
                      $("#ip_pannel_1").show();
                      $("#ip_pannel_2").hide();
                  });
                  $("#ip_set_2").click(function(){
                      $("#ip_pannel_1").hide();
                      $("#ip_pannel_2").show();
                  });
                  </script>
                  
                  <div id="ip_pannel_1" class="pdomcon">手动输入IP白名单(每行一个)，比如:<br />
                  127.0.0.1<br />
                  127.0.0.2<br />
                  <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="_include_ip" style="width:100%;height:100%"><?php if(!empty(Tpl::$_tpl_vars["group"]->include_ip)){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->include_ip), ENT_QUOTES); ?><?php }; ?></textarea></div>
                  <div id="ip_pannel_2" class="pdomcon" style="display:none">手动输入IP黑名单，比如:<br />
                  127.0.0.1<br />
                  127.0.0.2<br />
                  <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="_exclude_ip" style="width:100%;height:100%"><?php if(!empty(Tpl::$_tpl_vars["group"]->exclude_ip)){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->exclude_ip), ENT_QUOTES); ?><?php }; ?></textarea></div>
                  
                  <div class="dpbtn">
                    <div class="fr">
                      <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" value="确定" onClick="closeDiv('pip')" /></span>
                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('pip')" /></span>
                    </div>
                  </div>
              </div>
              </div>
            </div>
          </div>

          <!--遮罩pop end-->

          <!--遮罩pop start-->
          <!--<dt>ADSL黑白名单：</dt> -->
          <label class="irad" for="adsl_black"><span class="sbtng"><input name="xzmt" id="adsl_black" type="button"  onClick="ShowDIV('padsl')" class="ibtng" value="手机号黑白名单"/></span></label>
          
          <!--遮罩pop start-->
          <!--div id="BgDiv"></div-->
          <div id="padsl" class="popdiv pop_domain" style="display:none">
            <div class="dbg">
              <div class="pmain">
              <div class="ptit">
                <div class="ptname">手机号黑白名单</div>
                <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('padsl')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
              </div>
              <div class="dcon">
                  <div class="clear">
                    <div class="fl">
                      <span class="sbtng">        <input id="adsl_set_1" type="button" class="ibtng" value="手机号白名单"  /></span>
                      <span class="sbtng ml15">   <input id="adsl_set_2" type="button" class="ibtng" value="手机号黑名单" /></span>
                    </div>
                  </div>
                  <script>
                  $("#adsl_set_1").click(function(){
                      $("#adsl_pannel_1").show();
                      $("#adsl_pannel_2").hide();
                  });
                  $("#adsl_set_2").click(function(){
                      $("#adsl_pannel_1").hide();
                      $("#adsl_pannel_2").show();
                  });
                  </script>
                  
                  <div id="adsl_pannel_1" class="pdomcon">手动输入手机号白名单(每行一个)。<br />
                  <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="_include_adsl" style="width:100%;height:100%"><?php if(!empty(Tpl::$_tpl_vars["group"]->include_adsl)){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->include_adsl), ENT_QUOTES); ?><?php }; ?></textarea></div>
                  <div id="adsl_pannel_2" class="pdomcon" style="display:none">手动输入手机号黑名单。<br />
                  <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="_exclude_adsl" style="width:100%;height:100%"><?php if(!empty(Tpl::$_tpl_vars["group"]->exclude_adsl)){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->exclude_adsl), ENT_QUOTES); ?><?php }; ?></textarea></div>
                  
                  <div class="dpbtn">
                    <div class="fr">
                      <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" value="确定" onClick="closeDiv('padsl')" /></span>
                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('padsl')" /></span>
                    </div>
                  </div>
              </div>
              </div>
            </div>
          </div>

              <!-- start 20171023-->
              <label class="irad" for="mtym"><span class="sbtng"><input name="xzmt" id="mtym" type="button"  onClick="ShowDIV('pdomain')" class="ibtng" value="网站黑白名单"/></span></label>
              <!--遮罩pop start-->
              <div id="BgDiv"></div>
              <div id="pdomain" class="popdiv pop_domain" style="display:none">
                  <div class="dbg">
                      <div class="pmain">
                          <div class="ptit">
                              <div class="ptname">网站黑白名单</div>
                              <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('pdomain')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
                          </div>
                          <div class="dcon">
                              <div class="clear">
                                  <div class="fl">
                                      <span class="sbtng">        <input id="domain_set_1" type="button" class="ibtng" value="定向域名"  /></span>
                                      <span class="sbtng ml15">    <input id="domain_set_2" type="button" class="ibtng" value="排除域名" /></span>
                                  </div>
                              </div>
                              <script>
                                  $("#domain_set_1").click(function(){
                                      $("#domain_pannel_1").show();
                                      $("#domain_pannel_2").hide();
                                  });
                                  $("#domain_set_2").click(function(){
                                      $("#domain_pannel_1").hide();
                                      $("#domain_pannel_2").show();
                                  });
                              </script>

                              <div id="domain_pannel_1" class="pdomcon">手动输入定向域名(每行一个)，比如:<br />
                                  www.163.com (仅包含首页) <br />
                                  www.163.com/* (包含所有) <br />
                                  <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="_include_host" style="width:100%;height:100%"><?php if(!empty(Tpl::$_tpl_vars["group"]->_include_host)){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->_include_host), ENT_QUOTES); ?><?php }; ?></textarea></div>
                              <div id="domain_pannel_2" class="pdomcon" style="display:none">手动输入排除域名(每行一个)，比如:<br />
                                  www.163.com (仅包含首页) <br />
                                  www.163.com/* (包含所有) <br />
                                  <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="_exclude_host" style="width:100%;height:100%"><?php if(!empty(Tpl::$_tpl_vars["group"]->_exclude_host)){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->_exclude_host), ENT_QUOTES); ?><?php }; ?></textarea></div>

                              <div class="dpbtn">
                                  <div class="fr">
                                      <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" value="确定" onClick="closeDiv('pdomain')" /></span>
                                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('pdomain')" /></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- end -->
         </dd>
        </dl>
        <?php }; ?>
<?php }; ?>
          <!--遮罩pop end-->
      <script type="text/javascript">
      //$(document).ready(function(){
          
          $(".accordion .rqltit:first").addClass("active");
          $(".accordion .rqlcon:not(:first)").hide();
      
          $(".accordion .rqltit input").click(function(){
          });
          $(".accordion .rqltit").click(function(e){
                  var element = e.target.nodeName.toLowerCase();
                  if(element=="input"){
                      $(e.target).parents(".rqltit").siblings('.rqlcon').find("input").prop("checked",$(e.target).prop("checked"));
                  }else{
                      $(this).next(".rqlcon").slideToggle("fast").siblings(".rqlcon").slideUp("fast");
                      $(this).toggleClass("active");
                      $(this).siblings(".rqltit").removeClass("active");
                  }
          });
      
      //});
      </script>
		<dl>
                    <div id="BgDiv"></div>
                      <script type="text/javascript">
          $("#xzys .rqltit:first").addClass("active");
          $("#xzys .rqlcon:not(:first)").hide();
      
          $("#xzys .rqltit input").click(function(){
          });
          $("#xzys .rqltit").click(function(e){
                  var element = e.target.nodeName.toLowerCase();
                  if(element=="input"){
                    $(e.target).parents(".rqltit").siblings('.rqlcon').find("input").prop("checked",$(e.target).prop("checked"));
                    $(e.target).parents(".combcheck").siblings().children('.rqlcon').find("input").prop("checked",false);    
                  }else{
                      $(this).next(".rqlcon").slideToggle("fast").siblings(".rqlcon").slideUp("fast");
                      $(this).toggleClass("active");
                      $(this).siblings(".rqltit").removeClass("active");
                  }
          });
      </script>
        </dd>
      </dl>

        <!--start-->
        <h2>流量来源：</h2>
        <dl>
            <dd class="exchange" style="margin-left:60px;">
               <?php /* <label class="rqxz" for="exchanges1">
                    <input disabled="true" id="exchanges1"type="checkbox" name="exchanges[]" <?php if(in_array(1,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?>  value="1"> <em>Tanx</em>
                </label>
                <label class="rqxz" for="exchanges2">
                    <input disabled="true" id="exchanges2"type="checkbox" name="exchanges[]" <?php if(in_array(2,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?>  value="2"> <em>Google</em>
                </label>
                <label class="rqxz" for="exchanges3">
                    <input disabled="true" id="exchanges3"type="checkbox" name="exchanges[]" <?php if(in_array(3,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?>  value="3"> <em>Baidu</em>
                </label>
                <label class="rqxz" for="exchanges4">
                    <input disabled="true" id="exchanges4"type="checkbox" name="exchanges[]" <?php if(in_array(4,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?>  value="4"> <em>SSP</em>
                </label>
                <br>
                <label class="rqxz" for="exchanges5">
                    <input disabled="true" id="exchanges5"type="checkbox" name="exchanges[]" <?php if(in_array(5,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?>  value="5"> <em>Sina Sax</em>
                </label>
                <label class="rqxz" for="exchanges6">
                    <input disabled="true" id="exchanges6"type="checkbox" name="exchanges[]" <?php if(in_array(6,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?>  value="6"> <em>Tencent</em>
                </label>
                <label class="rqxz" for="exchanges7">
                    <input disabled="true" id="exchanges7"type="checkbox" name="exchanges[]" <?php if(in_array(7,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?>  value="7"> <em>Youku</em>
                </label>
                <label class="rqxz" for="exchanges8">
                    <input id="exchanges8"type="checkbox" name="exchanges[]" <?php if(in_array(8,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?> <?php if(!isset(Tpl::$_tpl_vars["group_id"])){; ?> checked <?php }; ?>value="8"> <em>InMobi</em>
                </label> */?>
                <label class="rqxz" for="exchanges9">
                    <input id="exchanges9"type="checkbox" name="exchanges[]" <?php if(in_array(9,Tpl::$_tpl_vars["exchanges"])){; ?>checked<?php }; ?> value="9"> <em>LingJi</em>
                </label>
                <hr>
            </dd>
        </dl>

        <?php if(!user_api::auth("admin")){; ?>
        <input id="exchanges9" type="hidden" name="exchanges[]" value="9">
        <?php }; ?>
        <!--end-->

<h2>屏幕位置<span style="color:#925EC0;"> [ 仅适用于Exchange流量 ，流量来源紫色部分 ]</span></h2>
<dl>
	<!--<dt class="narrow-hide"></dt>-->
	<dt>屏幕位置：</dt>
	<dd>
		<label class="irad" for="is_first_page_1"><input id="is_first_page_1" name="is_first_page" <?php if(Tpl::$_tpl_vars["group"]->is_first_page===0){; ?>checked<?php }; ?> type="radio" value="0"/>首屏</label>
		<label class="irad ml20" for="is_first_page_2"><input id="is_first_page_2" name="is_first_page" <?php if(Tpl::$_tpl_vars["group"]->is_first_page==1){; ?>checked<?php }; ?> type="radio" value="1"/>非首屏</label>
		<label class="irad ml20" for="is_first_page_3"><input id="is_first_page_3" name="is_first_page" <?php if(Tpl::$_tpl_vars["group"]->is_first_page==2){; ?>checked<?php }; ?> <?php if(!isset(Tpl::$_tpl_vars["group"])){; ?>checked<?php }; ?> type="radio" value="2"/>不限</label>
	</dd>
</dl>

    <?php if(Tpl::$_tpl_vars["plan"]->platform != 1){; ?>
      <h2>关键词定向</h2>
      <dl>
        <dt><?php /*输入关键词<br/>逗号分开*/?></dt>

        <dd>
            <textarea class="itxt" style='margin: 0px; width: 566px; height: 74px;' name="keyword_list"><?php echo htmlspecialchars(Tpl::$_tpl_vars["group"]->keyword_list, ENT_QUOTES); ?></textarea>
        </dd>
    </dl>
    <?php }; ?>
    </div>
    
    <!--添加素材-->
    <div class="comForm clear">
      <h1>添加素材</h1>
      <div class="form-group clear" id="selectTable">
      	<?php if(empty(Tpl::$_tpl_vars["stuff_list"])){; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="select-mar">
          <tbody>
            <tr>
              <td class="select-col">
                <div class="select-box flex-middle">
                  <input class="select-input" name="adid" readonly accept="adid">
                  <i class="icon-plus"></i>
                  <span>选择素材</span>
                  <img class="addr" style="width:100%;height:100%;display: none;"/>
                  <embed width="100%" height="100%" style="width:100%;height:100%;display: none;"></embed>
                </div>
              </td>
              <td rowspan="1">
               <dl>
                <dt>素材名称：</dt>
                <dd item-name>***</dd>
               </dl>
               <dl>
                <dt>素材尺寸：</dt>
                <dd item-wh>***</dd>
               </dl>
              </td>
              <td rowspan="1">
                <dl>
                  <dt>展示类型：</dt>
                  <dd>
                    <select <?php echo htmlspecialchars(Tpl::$_tpl_vars["groupReadonly"], ENT_QUOTES); ?> name="view_type" accept="view_type">
                      <option value="1">嵌入式</option>
                      <option value="2" selected>浮窗</option>
                      <option value="8">重定向[禁用：JS]</option>
                      <option value="16">重定向(DPC)</option>
                      <option value="32">通栏</option>
                      <option value="256">插页</option>
                      <option value="512">对联</option>
                      <option value="128">无线浮标</option>
                      <option value="64">无线APP</option>
                    </select>
                  </dd>
                </dl>
                <dl>
                  <dt>位置：</dt>
                  <dd>
                    <select <?php echo htmlspecialchars(Tpl::$_tpl_vars["groupReadonly"], ENT_QUOTES); ?> name="view_position" accept="view_position">
                      <option value="0" selected>默认</option>
                      <option value="1">正上方</option>
                      <option value="2">右上角</option>
                      <option value="3">右侧居中</option>
                      <option value="4">右下角</option>
                      <option value="5">正下方</option>
                      <option value="6">左下角</option>
                      <option value="7">左侧居中</option>
                      <option value="8">左上角</option>
                    </select>
                  </dd>
                 </dl>
              </td>
              <td> <input type="button" value="添加素材" id="addButon"></td>
            </tr>
          </tbody>
        </table>
        <?php }else{; ?>
        <?php foreach(Tpl::$_tpl_vars["ad_list"] as Tpl::$_tpl_vars["k"]=>Tpl::$_tpl_vars["ad"]){; ?>
        	<?php foreach(Tpl::$_tpl_vars["stuff_list"] as Tpl::$_tpl_vars["stuff"]){; ?>
        	<?php if(Tpl::$_tpl_vars["ad"][adid] == Tpl::$_tpl_vars["stuff"][adid]){; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="select-mar" >
          <tbody>
            <tr>
              <td class="select-col">
                <div class="select-box flex-middle un-editable">
                  <input class="select-input" name="adid" readonly accept="adid" value='<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuff"][adid], ENT_QUOTES); ?>'>
                  <?php if(empty(Tpl::$_tpl_vars["stuff"][addr])){; ?>
                  <i class="icon-plus"></i>
                  <span>选择素材</span>
                  <?php }; ?>
                  <img class="addr" style="width:100%;height:100%;<?php if(Tpl::$_tpl_vars["stuff"][type]!=1){; ?>display: none;<?php }; ?>" <?php if(Tpl::$_tpl_vars["stuff"][type]==1){; ?> src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuff"][addr], ENT_QUOTES); ?>"<?php }; ?>/>
                  <embed width="100%" height="100%" style="width:100%;height:100%;<?php if(Tpl::$_tpl_vars["stuff"][type]!=2){; ?>display: none;<?php }; ?>" <?php if(Tpl::$_tpl_vars["stuff"][type]==2){; ?> src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuff"][addr], ENT_QUOTES); ?>"<?php }; ?>></embed>
                </div>
              </td>
              <td rowspan="1">
               <dl>
                <dt>素材名称：</dt>
                <dd item-name><?php echo htmlspecialchars(Tpl::$_tpl_vars["stuff"][name], ENT_QUOTES); ?></dd>
               </dl>
               <dl>
                <dt>素材尺寸：</dt>
                <dd item-wh><?php echo htmlspecialchars(Tpl::$_tpl_vars["stuff"][width], ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuff"][height], ENT_QUOTES); ?></dd>
               </dl>
              </td>
              <td rowspan="1">
                <dl>
                  <dt>展示类型：</dt>
                  <dd>
                    <select <?php echo htmlspecialchars(Tpl::$_tpl_vars["groupReadonly"], ENT_QUOTES); ?> name="view_type" accept="view_type" disabled>
                      <option value="1" <?php if(Tpl::$_tpl_vars["ad"][adType]==1){; ?>selected<?php }; ?>>嵌入式</option>
                      <option value="2" <?php if(empty(Tpl::$_tpl_vars["ad"][adType]) or Tpl::$_tpl_vars["ad"][adType]==2){; ?>selected<?php }; ?>>浮窗</option>
                      <option value="8" <?php if(Tpl::$_tpl_vars["ad"][adType]==8){; ?>selected<?php }; ?>>重定向[禁用：JS]</option>
                      <option value="16" <?php if(Tpl::$_tpl_vars["ad"][adType]==16){; ?>selected<?php }; ?>>重定向(DPC)</option>
                      <option value="32" <?php if(Tpl::$_tpl_vars["ad"][adType]==32){; ?>selected<?php }; ?>>通栏</option>
                      <option value="256" <?php if(Tpl::$_tpl_vars["ad"][adType]==256){; ?>selected<?php }; ?>>插页</option>
                      <option value="512" <?php if(Tpl::$_tpl_vars["ad"][adType]==512){; ?>selected<?php }; ?>>对联</option>
                      <option value="128" <?php if(Tpl::$_tpl_vars["ad"][adType]==128){; ?>selected<?php }; ?>>无线浮标</option>
                      <option value="64" <?php if(Tpl::$_tpl_vars["ad"][adType]==64){; ?>selected<?php }; ?>>无线APP</option>
                    </select>
                  </dd>
                </dl>
                <dl>
                  <dt>位置：</dt>
                  <dd>
                    <select <?php echo htmlspecialchars(Tpl::$_tpl_vars["groupReadonly"], ENT_QUOTES); ?> name="view_position" accept="view_position" disabled>
                      <option value="0" <?php if(empty(Tpl::$_tpl_vars["ad"][colum1]) or Tpl::$_tpl_vars["ad"][colum1]==0){; ?>selected<?php }; ?>>默认</option>
                      <option value="1" <?php if(Tpl::$_tpl_vars["ad"][colum1]==1){; ?>selected<?php }; ?>>正上方</option>
                      <option value="2" <?php if(Tpl::$_tpl_vars["ad"][colum1]==2){; ?>selected<?php }; ?>>右上角</option>
                      <option value="3" <?php if(Tpl::$_tpl_vars["ad"][colum1]==3){; ?>selected<?php }; ?>>右侧居中</option>
                      <option value="4" <?php if(Tpl::$_tpl_vars["ad"][colum1]==4){; ?>selected<?php }; ?>>右下角</option>
                      <option value="5" <?php if(Tpl::$_tpl_vars["ad"][colum1]==5){; ?>selected<?php }; ?>>正下方</option>
                      <option value="6" <?php if(Tpl::$_tpl_vars["ad"][colum1]==6){; ?>selected<?php }; ?>>左下角</option>
                      <option value="7" <?php if(Tpl::$_tpl_vars["ad"][colum1]==7){; ?>selected<?php }; ?>>左侧居中</option>
                      <option value="8" <?php if(Tpl::$_tpl_vars["ad"][colum1]==8){; ?>selected<?php }; ?>>左上角</option>
                    </select>
                  </dd>
                 </dl>
              </td>
              <!--<?php if(Tpl::$_tpl_vars["k"] == 0){; ?>
              <td> <input type="button" value="添加素材" id="addButon"></td>
              <?php }else{; ?>
              <td> <input type="button" value="删除素材" id="addButon" class="button-remove"></td>
              <?php }; ?>-->
            </tr>
          </tbody>
        </table>
        <?php }; ?>
        <?php }; ?>
         <?php }; ?>
        
        <?php }; ?>
        
        
        
      </div>
      
    </div>
    
    <!--用户在哪里看到我的广告-->
    <div class="comForm clear" style="display:none;">
      <h1>哪里的用户在哪里看到我的广告</h1>
	  <?php /* <dl>
        <dt>选择域名分组：</dt>
        <dd>
        	<?php Tpl::$_tpl_vars["i"]=1; ?>
        	<?php foreach(Tpl::$_tpl_vars["domainGroups"] as Tpl::$_tpl_vars["mongoId"]=>Tpl::$_tpl_vars["domainGroup"]){; ?>
			<?php if(Tpl::$_tpl_vars["i"]%4==1 && Tpl::$_tpl_vars["i"]>4){; ?><br /><?php }; ?>
			<label class="rqxz"><input id="domain_group_<?php echo htmlspecialchars(Tpl::$_tpl_vars["i"]++, ENT_QUOTES); ?>" name="domain_group[]" type="checkbox" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["mongoId"], ENT_QUOTES); ?>"/><?php echo htmlspecialchars(Tpl::$_tpl_vars["domainGroup"]['name'], ENT_QUOTES); ?></label>
			<?php }; ?>
		</dd>
      </dl> */?>
      <dl>
        <dd>
          <dt>选择媒体：</dt>
          <label class="irad" for="mtym"><span class="sbtng"><input name="xzmt" id="mtym" type="button"  onClick="ShowDIV('pdomain')" class="ibtng" value="媒体定向"/></span></label>
          
          <!--遮罩pop start-->
          <div id="BgDiv"></div>
          <div id="pdomain" class="popdiv pop_domain" style="display:none">
            <div class="dbg">
              <div class="pmain">
              <div class="ptit">
                <div class="ptname">媒体定向</div>
                <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('pdomain')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
              </div>
              <div class="dcon">
                  <div class="clear">
                    <div class="fl">
                      <span class="sbtng">        <input id="domain_set_1" type="button" class="ibtng" value="定向域名"  /></span>
                      <span class="sbtng ml15">    <input id="domain_set_2" type="button" class="ibtng" value="排除域名" /></span>
                    </div>
                  </div>
                  <script>
                  $("#domain_set_1").click(function(){
                      $("#domain_pannel_1").show();
                      $("#domain_pannel_2").hide();
                  });
                  $("#domain_set_2").click(function(){
                      $("#domain_pannel_1").hide();
                      $("#domain_pannel_2").show();
                  });
                  </script>
                  
                  <div id="domain_pannel_1" class="pdomcon">手动输入定向域名(每行一个)，比如:<br />
                  www.163.com (仅包含首页) <br />
                  www.163.com/* (包含所有) <br />
                  <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="_include_host" style="width:100%;height:100%"><?php if(!empty(Tpl::$_tpl_vars["group"]->_include_host)){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->_include_host), ENT_QUOTES); ?><?php }; ?></textarea></div>
                  <div id="domain_pannel_2" class="pdomcon" style="display:none">手动输入排除域名(每行一个)，比如:<br />
                  www.163.com (仅包含首页) <br />
                  www.163.com/* (包含所有) <br />
                  <textarea style="margin: 2px; padding: 5px; height: 125px; width: 725px;" name="_exclude_host" style="width:100%;height:100%"><?php if(!empty(Tpl::$_tpl_vars["group"]->_exclude_host)){; ?><?php echo htmlspecialchars(implode("\n",Tpl::$_tpl_vars["group"]->_exclude_host), ENT_QUOTES); ?><?php }; ?></textarea></div>
                  
                  <div class="dpbtn">
                    <div class="fr">
                      <span class="sbtnb ml30"><input name="" type="button" class="ibtnb" value="确定" onClick="closeDiv('pdomain')" /></span>
                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('pdomain')" /></span>
                    </div>
                  </div>
              </div>
              </div>
            </div>
          </div>
          <!--遮罩pop end-->
        </dd>
      </dl>
    </div>
    
    <!--出价-->
          <input type="hidden" name="bid_price" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["media_extra"]['group_price'], ENT_QUOTES); ?>" class="itxt" />
    <!--btn-->
    <div class="comForm">
      <dl>
        <dt>&nbsp;</dt>
        <dd>
          <span class="sbtnb">
<?php if(!empty(Tpl::$_tpl_vars["group_id"])){; ?>
            <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["groupReadonly"], ENT_QUOTES); ?> name="" type="submit" class="ibtnb" value="保存"/>
<?php }else{; ?>
            <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["groupReadonly"], ENT_QUOTES); ?> name="" type="submit" class="ibtnb" value="保存并继续"/>
<?php }; ?>
          </span>
<?php if(empty(Tpl::$_tpl_vars["group_id"])){; ?>
          <span class="slink ml30"><a href="/baichuan_advertisement_manage/ad.plan.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>">&lt;&lt; 返回上一步</a></span>
<?php }; ?>
        </dd>
      </dl>
    </div>
    
    </form>
  </div>
</div>

 
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
<script>
  $(document).ready(function(){

  function getSelected(){
    var $table = $('.reportab'),$tr = $table.find('tr.selected');
    var data = null;
    if($tr.length > 0) {
      data = new Object;
      data.id = $tr.attr("item_id");
      data.name = $tr.attr("item_name");
      data.type = $tr.attr("item_type");
      data.addr = $tr.attr("item_addr");
      data.wh = $tr.attr("item_wh");
      data.uid = $tr.attr("item_uid");
    }
    return data
  }
    var $tabParent = $("#selectTable"), table = $tabParent.find('.select-mar').get(0), tableClone= $(table).clone(),
    implements = {
        init: function() {
          this.onEvents();
        },
        onEvents: function() {
          var $addbuton = $("#addButon");
          /* 添加素材  */
          $addbuton.on('click', function(e) {
            var ev = e || event;
            ev.stopPropagation();
            var $tartable = $(tableClone).clone();
            if($tartable.find(".un-editable"))$tartable.find(".un-editable").removeClass('.un-editable');
            $tartable.find("input[type=button]").addClass('button-remove').val('删除素材');
            $tabParent.append($tartable);
          });
          /* 删除素材  */
          $tabParent.on('click', '.button-remove', function(e) {
            var ev = e || event;
            ev.stopPropagation();
            $(this).closest('table').remove();
          });
          /* 弹出选择素材弹出框  */
          $tabParent.on('click', '.select-box', function(e){
          	if($(this).hasClass('un-editable')) return false;
            var ev = e || event, $this = $(this);
            ev.stopPropagation();
            layer.open({
              type: 2 //Page层类型
              ,area: ['800px', '500px']
              ,title: '选择素材'
              ,shade: 0.6 //遮罩透明度
              ,scrollbar : false 
              ,anim: 1 //0-6的动画形式，-1不开启
              ,content: '/baichuan_advertisement_manage/ad.stufflibrary.GetStuffLib?plan_id=<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>'
              ,btn:['确定', '取消']
              ,yes: function(index, layero) {
                var iframeWin = window[layero.find('iframe')[0]['name']];
                var data = iframeWin.getSelected();
                if(data){
                  var $adid = $this.find('input[accept=adid]'), $img = $this.find("img"), $embed = $this.find("embed"), $tr = $this.closest('tr')
                  , $name = $tr.find("[item-name]"), $wh = $tr.find('[item-wh]'), $span = $this.find('span') ,
                  $viewType = $tr.find("[accept=view_type]"), $viewPos = $tr.find("[accept=view_position]");
                  $span.hide();
                  $adid.val(data.id);
                  $adid.attr('name','adid['+ data.id +']');
                  $viewType.attr('name','view_type['+ data.id +']');
                  $viewPos.attr('name','view_position['+ data.id +']');
                  $name.text(data.name);
                  $wh.text(data.wh);
                  if(data.type * 1 === 2){
                    $embed.attr('src', data.addr).show();
                    $img.hide();
                  }
                  else{
                    $img.attr('src', data.addr).show();
                    $embed.hide();
                  }
                }
                layer.close(index)
              }
              ,btn2: function(index, layero){
                layer.close(index)
              }
            }); 
          });
        }
    };
    implements.init();
    
    
    
    
  });
  
  
  
</script>
</html>

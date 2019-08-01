<!DOCTYPE html>
<html>
<head>
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
<script src="/baichuan_advertisement_manage/assets_admin/js/jquery.form.min.js"></script>
<style>
span.sbtng, span.sbtng .ibtng{
float:none;
}
</style>
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
    <div class="step mb-10">
          <div class="step3" style="padding:0;">
              <div id="prevplan" class="pull-left" style="height:100%;width:227px;">
                  <a href="/baichuan_advertisement_manage/ad.plan.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>?backstaff=/ad.stuff.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>" style="height:100%;width:100%;display:block"></a>
              </div>
              <div id="prevgroup" class="pull-left" style="height:100%;width:227px;">
                  <a href="/baichuan_advertisement_manage/ad.group.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>?back=/ad.stuff.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>" style="height:100%;width:100%;display:block"></a>
              </div>
      </div>
      </div>
  	<form action="/ad.stuff.save" method="post" id="stuffs_form">
    <input type="hidden" name="plan_id" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>" />
    <input type="hidden" name="group_id" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>" />
    <input type="hidden" name="submit_or_not" id="submit_or_not" value="0"/>
  	<div class="toolbar-bc fl" style="margin-bottom:13px;">
		<!--<span class="sbtng" style="position:relative;display:inline-block;zoom:1;cursor:pointer;overflow:hidden;vertical-align:middle;">-->
        <!--<input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> <?php if((Tpl::$_tpl_vars["btn_disable"]==1)&&(!(user_api::auth("admin")))){; ?> disabled <?php }; ?> name="stuff" type="button" id="" class="ibtng" value="上传素材" style="background: #EEEEEE; border: 1px solid #DDDDDD; font-family: Microsoft Yahei; font-weight: normal;"/>-->
            <!--<input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> <?php if((Tpl::$_tpl_vars["btn_disable"]==1)&&(!(user_api::auth("admin")))){; ?> disabled <?php }; ?> name="stuff[]" style="position:absolute;left:0;width: 180px;top:0;_zoom:30;font-size:300px\9;height:100%;_height:auto;opacity:0;filter:alpha(opacity=0);-ms-filter:"alpha(opacity=0)";cursor:pointer;" type="file" multiple id="upload" accept="image/gif, image/png, image/jpeg, image/gif,application/x-shockwave-flash" class="ibtng" value="批量上传" />-->
		<!--</span>-->
		<!--<span style="color: red;">（请上传大小为<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad_position"], ENT_QUOTES); ?>的图片素材）</span>-->
		<!--<span class="sbtng" style="position:relative;display:inline-block;zoom:1;cursor:pointer;overflow:hidden;vertical-align:middle;">-->
		<!--<?php if(Tpl::$_tpl_vars["config"]['adp']['stuff_text']){; ?>-->
            <!--<input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>  <?php if((Tpl::$_tpl_vars["btn_disable"]==1)&&(!(user_api::auth("admin")))){; ?> disabled <?php }; ?> type="button" id="" class="ibtng" onclick="location='/baichuan_advertisement_manage/ad.stuff.addone.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>'" value="添加文本素材"  style="background: #EEEEEE; border: 1px solid #DDDDDD; font-family: Microsoft Yahei; font-weight: normal;"/>-->
		<!--<?php }; ?>-->
		<!--</span>-->
    	<div class="fr">
			<a class="btn btn-squared btn-blue" href="/baichuan_advertisement_manage/ad.plan.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>">广告组列表</a>
		    <!--<a class="btn btn-squared btn-blue" href="/baichuan_advertisement_manage/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">素材列表</a>-->
		    <a class="btn btn-squared btn-blue" href="/baichuan_advertisement_manage/ad.group.list.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">广告列表</a>
			<!--<a class="btn btn-squared btn-red" href="/baichuan_advertisement_manage/ad.stuff.addExchangeStuff.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">添加灵集素材</a>-->
		    <a class="btn btn-squared btn-default" href="/baichuan_advertisement_manage/ad.plan.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>">编辑广告计划</a>
		    <a class="btn btn-squared btn-default" href="/baichuan_advertisement_manage/ad.group.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">编辑广告组</a>
		    <!--<a class="btn btn-squared btn-default" href="/baichuan_advertisement_manage/ad.stuff.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">编辑素材</a>-->
		    <a class="btn btn-squared btn-default" href="/baichuan_advertisement_manage/ad.stuff.add.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>">编辑广告</a>
		</div>
    </div>
    <!--基本信息-->
    <div class="comForm clear" style="margin:0;">
<?php /*
      <h1>上传素材</h1>
      <h2 style="padding-left:0;">可选素材尺寸(px)&amp;约占流量</h2>
		  */?>
      <div class="cyli" style="margin:0;">
          <div class="">
		  	<span style="width:30px"></span>
	          	<script>
	              $(document).ready(function(){
	                  $(".copyset").click(function(){
	                      var me = ($(this).parents("tr"));
	                      var source = ($(this).parents("tr").prev());
	                      if (me.find("textarea.show_js").val() && source.find("textarea.show_js").val()) {
	                          me.find("textarea.show_js").val(source.find("textarea.show_js").val());
	                          me.find("textarea.click_js").val(source.find("textarea.click_js").val());
	                          me.find("input.landing_page").val(source.find("input.landing_page").val());
	                          //me.find("input.adname").val(source.find("input.adname").val());
	                          me.find("input.view1").prop("checked", source.find("input.view1").prop("checked"));
	                          me.find("input.view2").prop("checked", source.find("input.view2").prop("checked"));
	                          me.find("input.view4").prop("checked", source.find("input.view4").prop("checked"));
	                          alert("复制成功，请保存!");
	                      }
	                      else {
	                          alert("复制失败，请手动输入!");
	                      }
	                      return false;

	                  });
	                  $("#upload").change(function(){
	                  	    var cnt = this.files.length;
					        for(var i=0; i<cnt;i++){
					            if(this.files[i].type.search('image')<0 && this.files[i].type.search('flash')<0 ){
					            	alert("仅支持图片和Flash，请重新选择");
					            	return;
					            }
					        }

	                        $("form").submit();
	                  });
	                  var bar = $('.bar');
	                  var percent = $('.percent');
	                  var status = $('#status');
	                  $('form').ajaxForm({
	                      dataType: "json",
	                      beforeSend: function(){
	                          var show_js = $("textarea[name^='show_js']");
	                          click_js = $("textarea[name^='click_js']");
	                          $.each(show_js, function(){
	                              if ($(this).val().length > 1640) {
	                                  alert("统计代码长度不能大于1640!");
	                                  $(":submit").preventDefault();
	                              }
	                          });
	                          $.each(click_js, function(){
	                              if ($(this).val().length > 1640) {
	                                  alert("统计代码长度不能大于1640!");
	                                  $(":submit").preventDefault();
	                              }
	                          });
	                          status.empty();
	                          var percentVal = '0%';
	                          bar.width(percentVal)
	                          percent.html(percentVal);
	                      },
	                      uploadProgress: function(event, position, total, percentComplete){
	                          var percentVal = percentComplete + '%';
	                          bar.width(percentVal)
	                          percent.html(percentVal);
	                      },
	                      success: function(r){
	                          if (r.error != ""){
								alert(r.error);
							  }
	                          var percentVal = '100%';
	                          bar.width(percentVal)
	                          percent.html(percentVal);
	                      },
	                      complete: function(xhr){
							  location.reload();
	                      }
	                  });
	                  $(".addr").mouseover(function(){
	                      var d = '<img style="width:100%;" src="' + $(this).attr("src") + '">';
	                      var p = ($(this).position());
	                      $("#addr_pre").html(d).css({
	                          left: p.left,
	                          top: p.top + $(this).height() + 20
	                      }).show();
	                  }).mouseout(function(){
	                      $("#addr_pre").hide();
	                  });
	              });
	          </script>
				<div style="position:absolute; top:33px; left:33px max-width:600px;" id="addr_pre"></div>
				<div style="display:none" class="progress">
					<div class="bar"></div >
					<div class="percent">0%</div >
				</div>
				<div id="status"></div>
	            <!--遮罩pop start-->
	            <div id="BgDiv"></div>
	            <div id="sucai" class="popdiv pop_sucai" style="display:none">
	              <div class="dbg">
	                <div class="pmain">
	                <div class="ptit">
	                  <div class="ptname">历史素材库</div>
	                  <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('sucai')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
	                </div>
	                <div class="dcon">
	                  <div class="pscltit">
	                    <ul><li class="sel"><a class="ablk" href="#">历史素材</a></li><li><a class="ablk" href="#">自助素材</a></li></ul>
	                  </div>
	                  <div class="pscleft">
	                    <ul class="psclsize ablk">
	                      <li><a href="#">660×90</a></li>
	                      <li><a href="#">350×150</a></li>
	                      <li class="sel ablk"><a href="#">660×90</a></li>
	                      <li><a href="#">660×90</a></li>
	                      <li><a href="#">350×150</a></li>
	                      <li><a href="#">660×90</a></li>
	                      <li><a href="#">660×90</a></li>
	                      <li><a href="#">660×90</a></li>
	                    </ul>
	                  </div>
	                  <div class="pscright">
	                    <ul class="pscrli">
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                      <li><input name="" type="checkbox" value="" /><img src="/baichuan_advertisement_manage/assets_admin/img/tmp_ad.jpg" width="80" height="80" /></li>
	                    </ul>
	                  </div>
	                  <div class="clear"></div>
	                  <div class="dpbtn">
	                    <div class="fr">
	                      <span class="sbtnb"><input name="" type="button" class="ibtnb" value="确定" onClick="closeDiv('sucai')" /></span>
	                      <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('sucai')" /></span>
	                    </div>
	                  </div>

	                </div>
	                </div>
	              </div>
	            </div>
	            <!--遮罩pop end-->
          </div>
	</div>
	<div class="clear">
		<!--<dd>
			<?php foreach(Tpl::$_tpl_vars["channels_config"] as Tpl::$_tpl_vars["channel"]){; ?>
				<label class="irad ml20"><?php echo htmlspecialchars(Tpl::$_tpl_vars["channel"]["channel_id"], ENT_QUOTES); ?>/<?php echo htmlspecialchars(Tpl::$_tpl_vars["channel"]["width"], ENT_QUOTES); ?>/<?php echo htmlspecialchars(Tpl::$_tpl_vars["channel"]["height"], ENT_QUOTES); ?>/<?php echo htmlspecialchars(Tpl::$_tpl_vars["channel"]["fontsize"], ENT_QUOTES); ?></label>
			<?php }; ?>
            </dd>-->
	</div>
	<div class="clear"></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listab fs14" id="stuffs">
			<tr>
				<th scope="col">ID</th>
				<th scope="col">素材</th>
				<th scope="col">素材名称</th>
                <?php if(Tpl::$_tpl_vars["plan"]->platform == 1){; ?>
                <th scope="col">素材标题  <i class="fa fa-question-circle" title="素材标题不能超过14个汉字或者28个字符"></i></th>
                <?php }; ?>
				 <!--th scope="col">广告组样式参考</th-->
                 <?php if(Tpl::$_tpl_vars["plan"]->platform != 1){; ?>
				<th scope="col" style="min-width:100px;" >展示类型</th>
                <th scope="col" style="min-width:100px;">位置</th>
                <?php }; ?>
				<!--<th scope="col" width="50">状态</th>-->
				<?php if(false &&Tpl::$_tpl_vars["config"]['stuff']['shenhe']){; ?>
				<th scope="col" width="50">审核</th>
				<?php }; ?>
				<th scope="col">目标地址和文本内容</th>
				<th scope="col" width="120">监控JS</th>
				<th scope="col" width="120">下载信息</th>
				<th scope="col">&nbsp;</th>
			</tr>
		<?php foreach(Tpl::$_tpl_vars["ads"] as Tpl::$_tpl_vars["ad"]){; ?>
			<?php Tpl::$_tpl_vars["stuffType"] = Tpl::$_tpl_vars["ad"]->stuff->type; ?>
			<tr>
				<td><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?></td>
				<td>
					<?php if(Tpl::$_tpl_vars["ad"]->stuff->type==2){; ?>
					<embed src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" width="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->width, ENT_QUOTES); ?>" height="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->height, ENT_QUOTES); ?>" style="max-width:180px;max-height:80px"></embed>
					<?php }elseif( Tpl::$_tpl_vars["ad"]->stuff->type==1){; ?>
					<a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" target="_blank"><img class="addr" style="max-width:180px;max-height:80px" src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" /></a>
					<?php }else{; ?>
					<textarea style="width:200px;height:100px" name="text[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->text, ENT_QUOTES); ?></textarea>
					<?php }; ?>
				</td>
				<td style="font-size:12px; line-height:18px;">
					名称:<br/>
					<input type="text" name="adname[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" class="adname itxt" size="20" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adname, ENT_QUOTES); ?>" />
					<br/>
					素材类型:
					<?php if(Tpl::$_tpl_vars["ad"]->stuff->type==1){; ?>IMG
					<?php }elseif( Tpl::$_tpl_vars["ad"]->stuff->type==2){; ?>FLASH
					<?php }elseif( Tpl::$_tpl_vars["ad"]->stuff->type==5){; ?>重定向
					<?php }elseif( Tpl::$_tpl_vars["ad"]->stuff->type==6){; ?>VIDEO
					<?php }elseif( Tpl::$_tpl_vars["ad"]->stuff->type==8){; ?>JS
					<?php }elseif( Tpl::$_tpl_vars["ad"]->stuff->type==9){; ?>HTML
					<?php }elseif( Tpl::$_tpl_vars["ad"]->stuff->type==7){; ?>IFRAME
					<?php }; ?>
					<br/>
					<?php if( in_array(Tpl::$_tpl_vars["stuffType"],Tpl::$_tpl_vars["visibleStuffType"]) ){; ?>
					素材尺寸:
					<input type="text" name="width[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->width, ENT_QUOTES); ?>" class="itxt" size="3"/>*<input type="text" name="height[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->height, ENT_QUOTES); ?>" class="itxt" size="3"/></br>
					<?php }elseif((Tpl::$_tpl_vars["stuffType"] == 5)){; ?>
					重定向规则:<span style="color:#E83428; margin-left:10px;"><?php echo htmlspecialchars(Tpl::$_tpl_vars["rule"][Tpl::$_tpl_vars["ad"]->stuff->landing_rule], ENT_QUOTES); ?></span>
					<br/>
					<?php }; ?>
				</td>
                <?php if(Tpl::$_tpl_vars["plan"]->platform == 1){; ?>
                <td>
                    <input type="text" name="title[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->title, ENT_QUOTES); ?>" >
                </td>
                <?php }; ?>
				<!--td>
					图片:<br/>
					<span>(<?php echo htmlspecialchars(Tpl::$_tpl_vars["groupTaLimit"]["height_min"], ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["groupTaLimit"]["width_min"], ENT_QUOTES); ?>)</span>
					/<span>(<?php echo htmlspecialchars(Tpl::$_tpl_vars["groupTaLimit"]["height_max"], ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["groupTaLimit"]["width_max"], ENT_QUOTES); ?>)</span><br/>
					文字:</br>
					<span><?php echo htmlspecialchars(Tpl::$_tpl_vars["groupTaLimit"]["fornt_min"], ENT_QUOTES); ?></span>/<span><?php echo htmlspecialchars(Tpl::$_tpl_vars["groupTaLimit"]["fornt_max"], ENT_QUOTES); ?></span>
				</td-->
                <?php if(Tpl::$_tpl_vars["plan"]->platform != 1){; ?>
				<td>
					<?php if( in_array(Tpl::$_tpl_vars["stuffType"],Tpl::$_tpl_vars["visibleStuffType"]) ){; ?>
						<input id="view1_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="1" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 1){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view1_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">嵌入式</label><br/>

						<input id="view2_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="2" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 2){; ?>checked<?php }; ?> <?php if(Tpl::$_tpl_vars["ad"]->view_type == 3){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view2_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">浮窗</label><br/>

						<input id="view32_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="32" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 32){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view32_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">通栏</label><br/>

						<input class="view256" id="view256_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="256" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 256){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view256_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">插页</label><br/>
						<?php if( Tpl::$_tpl_vars["stuffType"] != 9){; ?>
						<input class="view512" id="view512_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="512" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 512){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view512_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">对联</label><br/>
						<?php }; ?>

						<input id="view128_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="128" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 128){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view128_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">无线浮标</label><br/>

						<input id="view64_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="64" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 64){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view64_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">无线APP</label><br/>
						<!--
						<input id="view4_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="4" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 4){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view4_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">背投</label><br/>
						-->
					<?php }elseif((Tpl::$_tpl_vars["stuffType"] == 8)){; ?>
						<input id="view1_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="1" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 1){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view1_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">嵌入式</label><br/>
					<?php }; ?>
					<?php if(Tpl::$_tpl_vars["config"]['adp']['plan_redirect'] && Tpl::$_tpl_vars["config"]['version'] == "operator" && Tpl::$_tpl_vars["ad"]->stuff->type==5){; ?>
						<input id="view8_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="8" <?php if(Tpl::$_tpl_vars["ad"]->view_type == 8){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view8_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">重定向[禁用：JS]</label><br/>

						<input id="view16_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="radio" value="16"  <?php if(Tpl::$_tpl_vars["ad"]->view_type == 16){; ?>checked<?php }; ?> name="view_type[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/>
						<label for="view16_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>">重定向(DPC)</label><br/>
					<?php }; ?>
				</td>
				<td>
					<?php if(isset(Tpl::$_tpl_vars["positions"][Tpl::$_tpl_vars["ad"]->colum1])){; ?><?php Tpl::$_tpl_vars["checkPosId"] = Tpl::$_tpl_vars["ad"]->colum1; ?><?php }else{; ?><?php Tpl::$_tpl_vars["checkPosId"] = 0; ?><?php }; ?>
					<?php foreach(Tpl::$_tpl_vars["positions"] as Tpl::$_tpl_vars["posId"] => Tpl::$_tpl_vars["posName"]){; ?>
						<?php if(Tpl::$_tpl_vars["posId"] == 0 ){; ?>
						<label><input type="radio" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["posId"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["posId"] == Tpl::$_tpl_vars["checkPosId"]){; ?>checked="checked"<?php }; ?> name="view_position[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/><?php echo htmlspecialchars(Tpl::$_tpl_vars["posName"], ENT_QUOTES); ?></label><br/>
						<?php }elseif((Tpl::$_tpl_vars["ad"]->view_type == 2)){; ?>
						<label><input type="radio" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["posId"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["posId"] == Tpl::$_tpl_vars["checkPosId"]){; ?>checked="checked"<?php }; ?> name="view_position[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/><?php echo htmlspecialchars(Tpl::$_tpl_vars["posName"], ENT_QUOTES); ?></label><br/>
						<?php }elseif((Tpl::$_tpl_vars["posId"]%4 == 1 && in_array(Tpl::$_tpl_vars["ad"]->view_type,array(1,32)))){; ?>
						<label><input type="radio" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["posId"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["posId"] == Tpl::$_tpl_vars["checkPosId"]){; ?>checked="checked"<?php }; ?> name="view_position[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]"/><?php echo htmlspecialchars(Tpl::$_tpl_vars["posName"], ENT_QUOTES); ?></label><br/>
						<?php }; ?>
					<?php }; ?>
                </td>
                <?php }; ?>
				<!--<td><?php if(Tpl::$_tpl_vars["ad"]->play_status==1){; ?>正常<?php }else{; ?>无效<?php }; ?></td>-->
				<?php if(false && Tpl::$_tpl_vars["config"]['stuff']['shenhe']){; ?>
				<td>
					<input id="st_<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>" type="checkbox" value="1" name="st[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>][]"/>
				</td>
				<?php }; ?>
				<td>
					<?php /*跳转地址<input type="text" class="itxt crop_url" name="crop_url[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" size="30" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->crop_url, ENT_QUOTES); ?>" /><br />*/?>
					<?php if(Tpl::$_tpl_vars["ad"]->stuff->type<=2 or Tpl::$_tpl_vars["ad"]->stuff->type==5){; ?>
					<br>描述：<br>
					<input type="text" class="itxt landing_page" name="description[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" size="30" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->desc, ENT_QUOTES); ?>" />
					<br>标题：<br>
					<input type="text" class="itxt landing_page" name="title[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" size="30" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->title, ENT_QUOTES); ?>" />
					<br>落地页：<br>
					<input type="text" class="itxt landing_page" name="landing_page[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" size="30" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->landing_page, ENT_QUOTES); ?>" />
					<br/>
						<?php if(Tpl::$_tpl_vars["ad"]->view_type&0x10){; ?>
						跳转规则:<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->landing_rule, ENT_QUOTES); ?>
						<select name="landing_rule[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]">
							<?php foreach(Tpl::$_tpl_vars["rule"] as Tpl::$_tpl_vars["k"]=>Tpl::$_tpl_vars["v"]){; ?>
							<option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["k"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["ad"]->stuff->landing_rule==Tpl::$_tpl_vars["k"]){; ?>selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["v"], ENT_QUOTES); ?></option>
							<?php }; ?>
						</select>
						<?php }; ?>
					<?php }else{; ?>
					<?php }; ?>
				</td>
				<td>
					显示监控JS<br />
					<textarea style="margin: 0px; width: 220px; height: 50px;" type="text" class="show_js itxt" name="show_js[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" size="30" ><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->show_js, ENT_QUOTES); ?></textarea><br />
					点击监控JS<br />
					<textarea style="margin: 0px; width: 220px; height: 50px;" type="text" class="click_js itxt" name="click_js[<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>]" size="30" ><?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->click_js, ENT_QUOTES); ?></textarea>
				</td>
				<td>应用类型：<?php if(Tpl::$_tpl_vars["ad"]->stuff->app_type ==0){; ?>Android <?php }else{; ?> IOS <?php }; ?><br/>
					应用包名称：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->packagename, ENT_QUOTES); ?><br/>
					应用名称：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->appname, ENT_QUOTES); ?><br/>
					<?php if(Tpl::$_tpl_vars["ad"]->stuff->app_type ==0){; ?>Android应用介绍URL：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->app_intro_url, ENT_QUOTES); ?><?php }; ?><br/>
					应用大小：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->app_size, ENT_QUOTES); ?><br/>
					应用版本：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->app_ver, ENT_QUOTES); ?><br/>
					<?php if(Tpl::$_tpl_vars["ad"]->stuff->app_type ==0){; ?>appid：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->app_id, ENT_QUOTES); ?> <?php }else{; ?> App Store ID：<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->itunesId, ENT_QUOTES); ?><?php }; ?><br/>
				</td>
				<td>
					<span class="ltlink a12">
						<!--<a href="#">重新上传</a><a href="#">检测代码</a>-->
						<a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->stuff->addr, ENT_QUOTES); ?>" target="_blank">预览</a><br />
						<!-- <a class="copyset" href="#" title="复制上面的设置(类型，目标地址，JS设置)到本素材">复制</a> -->
						<a href="javascript:void(0)" onclick="lightHtml(<?php echo htmlspecialchars(Tpl::$_tpl_vars["ad"]->adid, ENT_QUOTES); ?>);">删除</a>
						<?php /*<a href="#">下载</a><br />*/?>
					</span>
				</td>
			</tr>
		<?php }; ?>
		</table>
    <!--btn-->
    <div class="comForm">
        <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?> <?php if((Tpl::$_tpl_vars["btn_disable"]==1)&&(!(user_api::auth("admin")))){; ?> disabled <?php }; ?> class="btn btn-squared btn-success fr" type="button" value="保存" style="width:120px;" onclick="saveAll()"/>
        <?php if(!user_api::auth("admin")){; ?>
        <input <?php echo htmlspecialchars(Tpl::$_tpl_vars["readonly"], ENT_QUOTES); ?>  <?php if((Tpl::$_tpl_vars["btn_disable"]==1)&&(!(user_api::auth("admin")))){; ?> disabled <?php }; ?> class="btn btn-squared btn-success fr" type="button" value="提交审核" style="width:120px;" onclick="submitAll()"/>
        <?php }; ?>
    </div>

  </div>
  </form>
</div>
</div>
<div class="clear"></div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>

<script type="text/javascript">
function saveAll(){
        $("#submit_or_not").val(0);
        $("#stuffs_form").submit();
}

function submitAll(){
    layer.confirm('提交审核后将不可再修改素材，是否继续？', function(){
        $("#submit_or_not").val(1);
        $("#stuffs_form").submit();
    });
}
function lightHtml(adid){
	var html =	'<div style="width:360px; height: 160px;">'+
					'<div style="width: 320px; height: 60px; line-height: 30px; margin-top: 30px; margin-left:20px; text-align:center;">确认删除？</div>'+
					'<div style="width: 320px; height: 30px; line-height: 30px; margin-top: 20px; margin-left:20px;">'+
					'<a href="javascript:;" class="xubox_close" style="width:80px; height:30px; background:#CC0000; text-align:center; color:#FFFFFF; left:80px;"  onclick="deleteAdById('+ adid +');">删除</a>'+
					'<a href="javascript:;" class="xubox_close" style="width:80px; height:30px; background:#28A7E1; text-align:center; color:#FFFFFF; left:200px;">关闭</a>'+
					'</div>'+
				'</div>';
	lightBox(html);
}
function deleteAdById(adid){
	$.ajax({
		type: "POST", url: "ad.stuff.delete", data: { adid:adid }, dataType:"json",
		success: function(msg){
			location.reload();
		}
	});
	return false;
};
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?> 
  <script src="/baichuan_advertisement_manage/assets_admin/js/jquery.form.min.js"></script>
  <title><?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id']>0){; ?>编辑素材<?php }else{; ?>创建素材<?php }; ?></title>
  <style type="text/css">
    span.sbtng, span.sbtng .ibtng {
      float: none;
    }
    .form-group .form-control:not(div){
      width:80%;
      display: inline-block;
    }
    .font-po{
      margin:0 4px;
    }
    .fcr:not(label){
    	border-color: #990000!important;
    }
    label.fcr{
    	display: block;
    }
  </style>
  <link rel="stylesheet" href="/baichuan_advertisement_manage/assets_admin/v5/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
  <script src="/baichuan_advertisement_manage/assets_admin/v5/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
</head>  
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<div class="main">
  <div class="side">
    <div class="mb-10">
      <a class="btn btn-success btn-squared" style="width:235px;" href="/baichuan_advertisement_manage/ad.stufflibrary.Add?nav=8">创建素材</a>
    </div> 
    <script type="text/javascript">
      $(document).ready(function(){
          $(".accordion h3[current=active]").addClass("active");
      });
    </script>
    <div class="accordion" style="margin-top:0;">
      <h2>素材库</h2>
      <h3 class="bort" current="active">
        <a href="/baichuan_advertisement_manage/ad.stufflibrary.List?nav=8"><b>素材列表</b></a>
      </h3>
      <h3 class="bort" >
        <a href="/baichuan_advertisement_manage/ad.stufflibrary.AuditedList?type=1&nav=8"><b>素材审核</b></a>
      </h3>
    </div>
  </div>
  <div class="mcon">
    <div class="toolbar-bc mb-10">
      <div class="fl sub-title sc-title">
         <a href="/baichuan_advertisement_manage/ad.stufflibrary.List?nav=8"> 素材库</a><i class="font-po fa fa-angle-double-right"></i><a href="/baichuan_advertisement_manage/ad.stufflibrary.List?nav=8">素材列表</a>
         <i class="font-po fa fa-angle-double-right"></i><span><?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id']>0){; ?>编辑素材<?php }else{; ?>创建素材<?php }; ?></span>
      </div>
      <div class="clear"></div>
    </div>
    <div class="comForm clear" style="margin:0;">
      <div>
        <div class="" style="width:730px; magin-left:30px; margin-top:30px; border:1px solid #EEEEEE; padding:30px; float: left;">
          <!--<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="/ad.stuff.saveExchangeStuff.<?php echo htmlspecialchars(Tpl::$_tpl_vars["plan_id"], ENT_QUOTES); ?>.<?php echo htmlspecialchars(Tpl::$_tpl_vars["group_id"], ENT_QUOTES); ?>" id="stuffs_form">-->
          <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="/ad.stufflibrary.Add.save" id="stuffs_form">
            <input type="hidden" name="submit_or_not" id="submit_or_not" value="0"/>
            <?php if(isset(Tpl::$_tpl_vars["response"]['error'])&&Tpl::$_tpl_vars["response"]['error']>0){; ?>
            <div class="form-group mt-30">
              <label for="adType" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <div class="alert alert-danger mt-10" style="margin-bottom: 0;">
                  <button data-dismiss="alert" class="close">×</button>
                  <strong>提示：</strong><span><?php echo htmlspecialchars(Tpl::$_tpl_vars["response"]['message'], ENT_QUOTES); ?></span>
                </div>
              </div>
            </div>
            <?php }; ?>
            <div class="form-group">
              <label for="stuff_type" class="col-sm-2 control-label">创意类型:</label>
              <div class="col-sm-10">
                <span class="ad_type"><input name="stuff_type" value="0"   type="radio"  <?php if(Tpl::$_tpl_vars["stuffInfo"]->type<=0){; ?>checked<?php }; ?> id="stuff_type" /> <label  for="stuff_type">非动态</label></span>
                <span class="ad_seat"><input name="stuff_type"  value="17"  type="radio" <?php if(Tpl::$_tpl_vars["stuffInfo"]->type ==17){; ?>checked<?php }; ?>  id="stuff_type_seat" /> <label  for="stuff_type_seat">动态</label></span>
              </div>
            </div>
            <div class="form-group mt-30">
              <label for="adType" class="col-sm-2 control-label"><span style="color:red;vertical-align: middle;">*</span>广告类型</label>
              <div class="col-sm-10">
                <select id="adType" name="view_type" class="form-control" onchange="appInit.changeAdType();" >
                  <option value="0">请选择</option>
                  <?php foreach(Tpl::$_tpl_vars["adTypesInfo_inmobi"] as Tpl::$_tpl_vars["adTypeCode"] => Tpl::$_tpl_vars["adTypeInfo"]){; ?>
                  <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["adTypeCode"], ENT_QUOTES); ?>" <?php if( Tpl::$_tpl_vars["stuffInfo"]['adType'] == Tpl::$_tpl_vars["adTypeCode"] ){; ?>selected="selected"<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["adTypeInfo"]['name'], ENT_QUOTES); ?></option>
                  <?php }; ?>
                </select>
                <div id="tip-container" class="alert alert-info mt-10" style="display:none; margin-bottom: 0;">
                  <button data-dismiss="alert" class="close">×</button>
                  <strong>提示：</strong><span id="tip"></span>
                </div>
              </div>
            </div>
            <!-- start inmobi信息流 -->
            <div class="form-group" id="isLogoOrIcon">
              <label for="ad-type" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <span class="ad_type"><input name="ad_icon_group" value="1"   type="checkbox"  <?php if(Tpl::$_tpl_vars["plan"]->ad_pos_id<=0){; ?>checked<?php }; ?> id="ad_logo" /> <label  for="ad_logo">上传logo</label></span>
                <span class="ad_seat"><input name="ad_icon_group"  value="2"  type="checkbox" <?php if(Tpl::$_tpl_vars["plan"]->ad_pos_id>0){; ?>checked<?php }; ?>  id="ad_icon" /> <label  for="ad_icon">上传icon</label></span>
              </div>
            </div>
            <div class="form-group mt-30" style="display:none;" id="adLogoDiv">
              <label for="ad-type" class="col-sm-2 control-label">logo</label>
              <div class="col-sm-10">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                  <div class="input-group">
                    <div class="form-control uneditable-input">
                      <i class="fa fa-file fileupload-exists"></i>
                      <span class="fileupload-preview"></span>
                    </div>
                    <div class="input-group-btn">
                      <div class="btn btn-light-grey btn-file">
                        <span class="fileupload-new"><i class="fa fa-folder-open-o"></i>选择文件</span>
                        <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i>修改</span>
                        <input type="file" id="ad-logo-file" class="ad-icon-file" class="file-input" name="ad-logo-file" onchange="appInit.getIconFileName(0,this);">
                      </div>
                      <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                        <i class="fa fa-times"></i>删除
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <label for="ad-type" class="col-sm-2 control-label">logo尺寸</label>
              <div class="col-sm-10">
                <select id="logo_width" name="logo_width" class="form-control">
                  <option value="0">请选择</option>
                  <?php foreach(Tpl::$_tpl_vars["icon_size"] as Tpl::$_tpl_vars["len"]){; ?>
                  <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["len"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["stuffInfo"]->crop == Tpl::$_tpl_vars["len"]){; ?>selected="selected"<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["len"], ENT_QUOTES); ?>x<?php echo htmlspecialchars(Tpl::$_tpl_vars["len"], ENT_QUOTES); ?></option>
                  <?php }; ?>
                </select>
              </div>
            </div>
            <div class="form-group mt-30" style="display:none;" id="adIconDiv">
              <label for="ad-type" class="col-sm-2 control-label">icon</label>
              <div class="col-sm-10">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                  <div class="input-group">
                    <div class="form-control uneditable-input">
                      <i class="fa fa-file fileupload-exists"></i>
                      <span class="fileupload-preview"></span>
                    </div>
                    <div class="input-group-btn">
                      <div class="btn btn-light-grey btn-file">
                        <span class="fileupload-new"><i class="fa fa-folder-open-o"></i>选择文件</span>
                        <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i>修改</span>
                        <input type="file" id="ad-icon-file" class="ad-icon-file" class="file-input" name="ad-icon-file" onchange="appInit.getIconFileName(0);">
                      </div>
                      <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                        <i class="fa fa-times"></i>删除
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <label for="ad-type" class="col-sm-2 control-label">icon尺寸</label>
              <div class="col-sm-10">
                <select id="icon_width" name="icon_width" class="form-control">
                  <option value="0">请选择</option>
                  <?php foreach(Tpl::$_tpl_vars["icon_size"] as Tpl::$_tpl_vars["len"]){; ?>
                  <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["len"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["stuffInfo"]->crop == Tpl::$_tpl_vars["len"]){; ?>selected="selected"<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["len"], ENT_QUOTES); ?>x<?php echo htmlspecialchars(Tpl::$_tpl_vars["len"], ENT_QUOTES); ?></option>
                  <?php }; ?>
                </select>
              </div>
            </div>
            <!-- end -->
            <!-- start inmobi视频类型 -->
            <div class="form-group mt-30" style="display:none;" id="videoIconDiv">
              <label for="ad-type" class="col-sm-2 control-label">icon</label>
              <div class="col-sm-10">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                  <div class="input-group">
                    <div class="form-control uneditable-input">
                      <i class="fa fa-file fileupload-exists"></i>
                      <span class="fileupload-preview"></span>
                    </div>
                    <div class="input-group-btn">
                      <div class="btn btn-light-grey btn-file">
                        <span class="fileupload-new"><i class="fa fa-folder-open-o"></i>选择文件</span>
                        <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i>修改</span>
                        <input type="file" id="ad-video-icon-file" class="ad-video-icon-file" class="file-input" name="ad-video-icon-file" onchange="appInit.getIconFileName(1);">
                      </div>
                      <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                        <i class="fa fa-times"></i>删除
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <label for="ad-type" class="col-sm-2 control-label">icon尺寸</label>
              <div class="col-sm-10">
                <select id="stuff_size_4" name="stuff_size4" class="form-control" >
                  <option value="0">请选择</option>
                  <?php foreach(Tpl::$_tpl_vars["inmobi_stuff_size4"] as Tpl::$_tpl_vars["key"] => Tpl::$_tpl_vars["item"]){; ?>
                  <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>" class="stuff_size_<?php echo htmlspecialchars(intval(Tpl::$_tpl_vars["key"]/100), ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"], ENT_QUOTES); ?></option>
                  <?php }; ?>
                </select>
              </div>
            </div>
            <!-- end -->
            <div class="form-group mt-30" id="stuff_size_form">
              <label for="adType" class="col-sm-2 control-label">素材尺寸</label>
              <div class="col-sm-10">
                <select id="stuff_size_1" name="stuff_size1" class="form-control" <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id']>0){; ?> disabled<?php }; ?>>
                  <option value="0">请选择</option>
                  <?php foreach(Tpl::$_tpl_vars["inmobi_stuff_size1"] as Tpl::$_tpl_vars["key"] => Tpl::$_tpl_vars["item"]){; ?>
                  <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>" class="stuff_size_<?php echo htmlspecialchars(intval(Tpl::$_tpl_vars["key"]/100), ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"], ENT_QUOTES); ?></option>
                  <?php }; ?>
                </select>
                <select id="stuff_size_2" name="stuff_size2" class="form-control" <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id']>0){; ?> disabled<?php }; ?>>
                  <option value="0">请选择</option>
                  <?php foreach(Tpl::$_tpl_vars["inmobi_stuff_size2"] as Tpl::$_tpl_vars["key"] => Tpl::$_tpl_vars["item"]){; ?>
                  <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>" class="stuff_size_<?php echo htmlspecialchars(intval(Tpl::$_tpl_vars["key"]/100), ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"], ENT_QUOTES); ?></option>
                  <?php }; ?>
                </select>
                <select id="stuff_size_3" name="stuff_size3" class="form-control" <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id']>0){; ?> disabled<?php }; ?>>
                  <option value="0">请选择</option>
                  <?php foreach(Tpl::$_tpl_vars["inmobi_stuff_size3"] as Tpl::$_tpl_vars["key"] => Tpl::$_tpl_vars["item"]){; ?>
                  <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["key"], ENT_QUOTES); ?>" class="stuff_size_<?php echo htmlspecialchars(intval(Tpl::$_tpl_vars["key"]/100), ENT_QUOTES); ?>"><?php echo htmlspecialchars(Tpl::$_tpl_vars["item"], ENT_QUOTES); ?></option>
                  <?php }; ?>
                </select>
                <div class="alert alert-info mt-10" style="margin-bottom: 0;">
                  <button data-dismiss="alert" class="close">×</button>
                  <strong>提示：</strong><span>建议覆盖广告素材列表top5尺寸</span>
                </div>
              </div>
            </div>
            <div class="form-group mt-30">
              <label for="ad-type" class="col-sm-2 control-label"><span style="color:red;vertical-align: middle;">*</span>素材</label>
                <div class="col-sm-10">
                	<?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id'] > 0){; ?>
                		<img src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['addr'], ENT_QUOTES); ?>" width="250px" style="max-height: 250px;"/>
                	<?php }; ?>
                  <div class="fileupload fileupload-new" data-provides="fileupload" <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id']>0){; ?> style='display:none;'<?php }; ?>>
                    <div class="input-group">
                      <div class="form-control uneditable-input">
                          <i class="fa fa-file fileupload-exists"></i>
                          <span class="fileupload-preview"></span>
                      </div>
                      <div class="input-group-btn">
                        <div class="btn btn-light-grey btn-file">
                            <span class="fileupload-new"><i class="fa fa-folder-open-o"></i>选择文件</span>
                            <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i>修改</span>
                            <input id="ad-image-file" type="file" class="ad-image-file" class="file-input" name="ad-image-file" onchange="appInit.getFileName();" <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id']>0){; ?> disabled <?php }; ?>>
                        </div>
                        <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                          <i class="fa fa-times"></i>删除
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="alert alert-info mt-10" style="margin-bottom: 0;display:none;" id="pic_warn1">
                    <button data-dismiss="alert" class="close">×</button>
                    <strong>提示：</strong><span>图片或Flash不能超过400K</span>
                  </div>
                  <div class="alert alert-info mt-10" style="margin-bottom: 0;display:none;" id="pic_warn2">
                    <button data-dismiss="alert" class="close">×</button>
                    <strong>提示：</strong><span>1.视频不能超过10MB。2.视频时长不超过15秒。</span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="adname" class="col-sm-2 control-label"><span style="color:red;vertical-align: middle;">*</span>名称</label>
                <div class="col-sm-10">
                  <input id="adname" type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['name'], ENT_QUOTES); ?>"  name="adname" maxlength="20" required>
                </div>
              </div>
              <div class="form-group">
                <label for="ad-title" class="col-sm-2 control-label"><span style="color:red;vertical-align: middle;">*</span>标题</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['title'], ENT_QUOTES); ?>" id="ad-title" name="title" maxlength="50">
                </div>
              </div>
              <div class="form-group">
                <label for="ad-title" class="col-sm-2 control-label">有效时间</label>
                <div class="col-sm-10">
                  <input readonly id="start_date" name="start_date" class="col-sm-4" class="itxt idate fc7" <?php if(Tpl::$_tpl_vars["stuffInfo"]['valid_startTime'] >0){; ?> value="<?php echo htmlspecialchars(date('Y-m-d',Tpl::$_tpl_vars["stuffInfo"]['valid_startTime']), ENT_QUOTES); ?>" <?php }else{; ?> value="开始时间" <?php }; ?> size="12" style="width:36%;height:34px;">
                  <span class="col-sm-1" style="line-height:34px;text-align: center;">-</span>
                   <!--<input readonly id="end_date" name="end_date" class="col-sm-4" class="itxt idate fc7" value="<?php echo htmlspecialchars(tpl_modifier_default(date('Y-m-d',Tpl::$_tpl_vars["stuffInfo"]['valid_endTime']),'结束时间'), ENT_QUOTES); ?>" size="12" style="width:36%;height:34px;">-->
                   <input readonly id="end_date" name="end_date" class="col-sm-4" class="itxt idate fc7" <?php if(Tpl::$_tpl_vars["stuffInfo"]['valid_endTime'] >0){; ?> value="<?php echo htmlspecialchars(date('Y-m-d',Tpl::$_tpl_vars["stuffInfo"]['valid_endTime']), ENT_QUOTES); ?>" <?php }else{; ?> value="结束时间" <?php }; ?> size="12" style="width:36%;height:34px;">
                </div>
              </div>
              
              
              <div class="form-group mt-30">
                <label for="adType" class="col-sm-2 control-label">行业</label>
                <div class="col-sm-10">
                  <select  name="industry_id" class="form-control" >
                    <option value="0">请选择</option>
                    <?php foreach(Tpl::$_tpl_vars["industry_list"] as Tpl::$_tpl_vars["industry"]){; ?>
                    <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["industry"]['id'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["stuffInfo"]['industry_id'] == Tpl::$_tpl_vars["industry"]['id']){; ?> selected <?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["industry"]['industry_name'], ENT_QUOTES); ?></option>
                    <?php }; ?>
                  </select>
                </div>
              </div>

            <div class="form-group">
              <label for="tel_number" class="col-sm-2 control-label">电话</label>
              <div class="col-sm-10">
                <input type="text" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['tel_number'], ENT_QUOTES); ?>" class="form-control" id="tel_number" name="tel_number" maxlength="15">
              </div>
            </div>
              
              <div class="form-group">
                <label for="deeplink-url" class="col-sm-2 control-label">DeeplinkURL</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['deeplinkurl'], ENT_QUOTES); ?>" id="deeplink-url" name="deeplink-url" maxlength="60">
                </div>
              </div>
              <div class="form-group">
                <label for="ad-action" class="col-sm-2 control-label">广告交互类型:</label>
                <div class="col-sm-10">
                  <span class="ad_type"><input name="ad_action" value="1"   type="radio"  <?php if(Tpl::$_tpl_vars["stuffInfo"]['ad_action'] == 1){; ?>checked<?php }; ?> id="ad_action" /> <label  for="ad_action">打开网页</label></span>
                  <span class="ad_seat"><input name="ad_action"  value="2"  type="radio" <?php if(Tpl::$_tpl_vars["stuffInfo"]['ad_action'] == 2){; ?>checked<?php }; ?>  id="ad_action_seat1" /> <label  for="ad_action_seat1">下载</label></span>
                  <span class="ad_seat"><input name="ad_action"  value="3"  type="radio" <?php if(Tpl::$_tpl_vars["stuffInfo"]['ad_action'] == 3){; ?>checked<?php }; ?>  id="ad_action_seat2" /> <label  for="ad_action_seat2">电话</label></span>
                  <span class="ad_seat"><input name="ad_action"  value="5"  type="radio" <?php if(Tpl::$_tpl_vars["stuffInfo"]['ad_action'] == 5){; ?>checked<?php }; ?>  id="ad_action_seat3" /> <label  for="ad_action_seat3">deeplink</label></span>
                </div>
              </div>
              <div id="appInfo">
                <div class="form-group">
                  <label for="ad-action" class="col-sm-2 control-label">应用类型:</label>
                  <div class="col-sm-10">
                    <span class="ad_type"><input name="app_type" value="0"   type="radio"  <?php if(Tpl::$_tpl_vars["plan"]->ad_pos_id<=0){; ?>checked<?php }; ?> id="ad_type" /> <label  for="ad_type">Android</label></span>
                    <span class="ad_seat"><input name="app_type"  value="1" type="radio" <?php if(Tpl::$_tpl_vars["plan"]->ad_pos_id>0){; ?>checked<?php }; ?>  id="ad_type_seat" /> <label  for="ad_type_seat">IOS</label></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="deeplink-url" class="col-sm-2 control-label">应用包名称：</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['packagename'], ENT_QUOTES); ?>" id="packagename" name="packagename" maxlength="60" required>
                    <span style="color:red;margin-left:5px;">*</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="deeplink-url" class="col-sm-2 control-label">应用名称：</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['appname'], ENT_QUOTES); ?>" id="appname" name="appname" maxlength="60" required>
                    <span style="color:red;margin-left:5px;">*</span>
                  </div>
                </div>
                <div class="form-group" id="app_intro_url">
                  <label for="deeplink-url" class="col-sm-2 control-label">Android应用介绍URL：</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['app_intro_url'], ENT_QUOTES); ?>" id="app_intro_url" name="app_intro_url" maxlength="60" required>
                    <span style="color:red;margin-left:5px;">*</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="app_size" class="col-sm-2 control-label">应用大小：</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['app_size'], ENT_QUOTES); ?>" id="app_size" name="app_size" maxlength="60" placeholder="应用大小单位为MB" required>
                    <span style="margin-left:5px;">MB</span>
                    <span style="color:red;margin-left:5px;">*</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="app_ver" class="col-sm-2 control-label">应用版本：</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['app_ver'], ENT_QUOTES); ?>" id="app_ver" name="app_ver" maxlength="60" required>
                    <span style="color:red;margin-left:5px;">*</span>
                  </div>
                </div>
                <div class="form-group" id="itunesId">
                  <label for="app_ver" class="col-sm-2 control-label">IOS应用 App Store ID：</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['itunesId'], ENT_QUOTES); ?>" id="itunesId" name="itunesId" maxlength="60" required>
                    <span style="color:red;margin-left:5px;">*</span>
                  </div>
                </div>
                <div class="form-group" id="app_id">
                  <label for="app_ver" class="col-sm-2 control-label">Android应用在应用商店上架的appid：</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['app_id'], ENT_QUOTES); ?>" id="app_id" name="app_id" maxlength="60" required>
                    <span style="color:red;margin-left:5px;">*</span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">描述</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="desc"><?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['description'], ENT_QUOTES); ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="landing_page" class="col-sm-2 control-label">目标地址</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['landing_page'], ENT_QUOTES); ?>" placeholder="请填写以http或者https开头的URL地址" id="landing_page" name="landing_page">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">展示监控</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="show_js" placeholder="请填写以http或者https开头的URL地址"><?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['show_js'], ENT_QUOTES); ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">点击监控</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="click_js" placeholder="请填写以http或者https开头的URL地址"><?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['click_js'], ENT_QUOTES); ?></textarea>
                </div>
              </div>
              <div class="form-group mt-30">
                <label for="ad-type" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                  <input type="button" <?php if((Tpl::$_tpl_vars["btn_disable"]==1)&&(!(user_api::auth("admin")))){; ?> disabled <?php }; ?>   class="btn btn-squared btn-success fr" style="width:100px;" value="保存" onclick="appInit.saveAll(0)">
                    <input type="button" <?php if((Tpl::$_tpl_vars["btn_disable"]==1)&&(!(user_api::auth("admin")))){; ?> disabled <?php }; ?>  class="btn btn-squared btn-success fr" style="width:100px;margin-right:10px;" id="submit_or_not" value="保存并提交" onclick="appInit.saveAll(1)"/>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>  
  </div>
  <div class="clear"></div>
  <input type="hidden" name="ad_json" id="ad_types_json" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["adTypesInfoJson"], ENT_QUOTES); ?>"/>
  <script type="text/javascript">
    var adTypesInfo = $("#ad_types_json").val();
    var appInit = {
      init:function(){
        this.onEvents();
        this.layoutDate();
        this.triggerEvents();
        this.layoutThridScript();
        this.layoutComShow();
        this.changeAdType();
      },
      layoutDate: function(){
        if($("#start_date").val()=="开始时间"){
            $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
        }
        $("#start_date").datepicker({ dateFormat: "yy-mm-dd" ,minDate:0,
        onSelect:function(dateText,inst){
           $("#end_date").datepicker("option","minDate",dateText);
        }});
        $("#end_date").datepicker({ dateFormat: "yy-mm-dd",minDate:new Date(Date.parse($("#start_date").val())) });
      },
      getRules: function () {
      	var obj = new Object();
      	obj.rules = {
      		view_type:{
      			required: true,
      			min:1
      		},
      		adname: {
      			required: true,
      			maxlength: 20
      		},
      		title: {
      			required: true,
      			maxlength:50
      		},
      		"deeplink-url": {
      			url: true
      		},
      		landing_page: {
      			url: true
      		},
      		show_js: {
      			url: true
      		},
      		click_js: {
      			url: true
      		}
      	};
      	obj.messages = {
      		view_type: { 
      			required: '请选择广告类型',
      			min: '请选择广告类型'
      		},
      		adname: {
      			required: '请输入素材名称',
      			maxlength: '最多可以输入 20 个字符'
      		},
      		title: {
      			required: '请输入标题',
      			maxlength: '最多可以输入 50 个字符'
      		},
      		"deeplink-url": {
      			url: "请填写以http或者https开头的URL地址"
      		},
      		landing_page: {
      			url: "请填写以http或者https开头的URL地址"
      		},
      		show_js: {
      			url: "请填写以http或者https开头的URL地址"
      		},
      		click_js: {
      			url: "请填写以http或者https开头的URL地址"
      		}
      	};
      	<?php if(empty(Tpl::$_tpl_vars["stuffInfo"]['stuff_id'])){; ?>
	      	Object.assign(obj.rules, {
	      		"ad-image-file": "required"
	      	});
	      	Object.assign(obj.messages, {
	      		"ad-image-file": "请上传素材"
	      	})
      		
      	<?php }; ?>
      	
      	return obj;
      },
      onEvents: function() {
        $("form").validate(Object.assign( this.getRules(), { 
          submitHandler: function(form){
            form.submit();
          },
          errorClass:"fcr",
          errorPlacement:function(error,element) { 
          	element.addClass(this.errorClass);
          	if(element.attr('type') === 'file'){
          		let $e = element.closest('.input-group'),$t = $e.find('.uneditable-input');
			      	error.insertAfter($e);
			      	$t.addClass(this.errorClass);
          	}
          	else{
          		error.insertAfter(element);
          	}
			    },
			    success: function(error, element){
			    	$(element).removeClass(this.errorClass);
			    	$(error).remove();
			    	if($(element).attr('type') === 'file'){
          		let $e = $(element).closest('.input-group'),$t = $e.find('.uneditable-input');
          		$t.removeClass(this.errorClass);
          	}
			    }
        }));
        
        $("[name=ad_icon_group]").on("click",function(){
          if($(this).val() == 1){
            if($(this).prop("checked")){
              $("#adLogoDiv").show();
            }
            else{
              $("#adLogoDiv").hide();
            }
          }
          if($(this).val() == 2){
            if($(this).prop("checked")){
              $("#adIconDiv").show();
            }
            else{
              $("#adIconDiv").hide();
            }
          }
        });
        
        $("[name=app_type]").on('click',function(){
          if($(this).val() == 0){
            $("#app_intro_url").show();
            $("#app_id").show();
            $("#itunesId").hide();
          }
          else{
            $("#app_intro_url").hide();
            $("#app_id").hide();
            $("#itunesId").show();
          }
        });
        
        $("[name=ad_action]").on('click',function(){
          if($(this).val() == 1){
            $("#appInfo").hide();
          }
          else{
            $("#appInfo").show();
          }
        });
        
        $('[data-dismiss="fileupload"]').on('click',function(){
        	$(this).prev().find('input[type=file]').val('');
        	$(this).prev().find('input[type=file]').valid();
        });
        
        
      },
      triggerEvents: function() {
        $("[name=app_type][value=0]").prop("checked",true).trigger("click");
        $("[name=ad_action][value=1]").prop("checked",true).trigger("click");
      },
      layoutThridScript: function() {
        $('.icheck').iCheck({
          checkboxClass: 'icheckbox_minimal-aero',
          radioClass: 'iradio_flat-blue',
          increaseArea: '-10%'
        });
      },
      layoutComShow: function() {
        $("[name=ad_icon_group]:checked").each(function(){
          if($(this).val() == 1){
            $("#adLogoDiv").show();
          }
          else if($(this).val() == 2){
            $("#adIconDiv").show();
          }
        });
        $("#stuff_size_form").hide();
        $("#stuff_size_1").hide();
        $("#stuff_size_2").hide();
        $("#stuff_size_3").hide();
        $("#stuff_size_4").hide();
      },
      changeAdType: function() {
        var adType = $("#adType").val();
        if(adType == 1002) {
          $('#isLogoOrIcon').show();
          $("[name=ad_icon_group]:checked").each(function(){
            if($(this).val() == 1){
              $("#adLogoDiv").show();
            }
            else if($(this).val() == 2){
              $("#adIconDiv").show();
            }
          });
        }else {
          $('#isLogoOrIcon').hide();
          $("#adLogoDiv").hide();
          $("#adIconDiv").hide();
        }
        
        if(adType == 1002 || adType == 1003) {
          $("#stuff_size_form").show();
          $("#stuff_size_1").show();
          <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id'] > 0){; ?>
          	var size = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['width'], ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['height'], ENT_QUOTES); ?>";
	          $("#stuff_size_1").find('option').each(function(index,item){
	          	if($(item).text().indexOf(size)> -1) $("#stuff_size_1").val($(item).attr('value'))
	          })
          <?php }; ?>
          $("#stuff_size_2").hide();
          $("#stuff_size_3").hide();
          $("#stuff_size_4").hide();
          $("#pic_warn1").show();
          $("#pic_warn2").hide();
          $("#ad_action_seat").prop("disabled",false);
        }else if(adType ==1001) {
          $("#stuff_size_form").show();
          $("#stuff_size_1").hide();
          $("#stuff_size_2").show();
          <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id'] > 0){; ?>
          	var size = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['width'], ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['height'], ENT_QUOTES); ?>";
	          $("#stuff_size_2").find('option').each(function(index,item){
	          	if($(item).text().indexOf(size)> -1) $("#stuff_size_2").val($(item).attr('value'))
	          })
          <?php }; ?>
          $("#stuff_size_3").hide();
          $("#stuff_size_4").hide();
          $("#pic_warn1").show();
          $("#pic_warn2").hide();
          $("#ad_action_seat").prop("disabled",true);
          $("[name=ad_action][value=1]").prop("checked",true).trigger("click");
        }else if(adType == 1004) {
          $("#stuff_size_form").show();
          $("#stuff_size_1").hide();
          $("#stuff_size_2").hide();
          $("#stuff_size_3").show();
          <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id'] > 0){; ?>
          	var size = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['width'], ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['height'], ENT_QUOTES); ?>";
	          $("#stuff_size_3").find('option').each(function(index,item){
	          	if($(item).text().indexOf(size)> -1) $("#stuff_size_3").val($(item).attr('value'))
	          })
          <?php }; ?>
          $("#stuff_size_4").show();
          $("#pic_warn1").hide();
          $("#pic_warn2").show();
          $("#ad_action_seat").prop("disabled",true);
          $("[name=ad_action][value=1]").prop("checked",true).trigger("click");
        }else if(adType == 1005) {
          $("#stuff_size_form").show();
          $("#stuff_size_1").hide();
          $("#stuff_size_2").show();
          <?php if(Tpl::$_tpl_vars["stuffInfo"]['stuff_id'] > 0){; ?>
          	var size = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['width'], ENT_QUOTES); ?>*<?php echo htmlspecialchars(Tpl::$_tpl_vars["stuffInfo"]['height'], ENT_QUOTES); ?>";
	          $("#stuff_size_2").find('option').each(function(index,item){
	          	if($(item).text().indexOf(size)> -1) $("#stuff_size_2").val($(item).attr('value'))
	          })
          <?php }; ?>
          $("#stuff_size_3").hide();
          $("#stuff_size_4").hide();
          $("#pic_warn1").show();
          $("#pic_warn2").hide();
          $("#ad_action_seat").prop("disabled",false);
        }else {
          $("#stuff_size_form").hide();
          $("#pic_warn1").hide();
          $("#pic_warn2").hide();
          $("#ad_action_seat").prop("disabled",false);
        }
        
        if( typeof(adTypesInfo[adType]) === "object" && typeof(adTypesInfo[adType].tip) !== "undefined" ){
          $("#tip").text(adTypesInfo[adType].tip);
          $("#tip-container").show();
        }else{
          $("#tip").text("");
          $("#tip-container").hide();
        }
      },
      getFileName: function() {
        var file = $("#ad-image-file").val();
        var pos = file.lastIndexOf("\\");
        fileName = file.substring(pos + 1);
        var pos = fileName.lastIndexOf(".");
        fileName = fileName.substring(0,pos);
        $("#adname").val(fileName);
        $("#adname").valid();
      },
      getIconFileName: function(type,$el) {
        var file = null;
        if(type ==0){
          file = $("#ad-icon-file").val();
        }else {
          file = $("#ad-video-icon-file").val();
        }
        if($el)file = $($el).val();
        var pos = file.lastIndexOf("\\");
        fileName = file.substring(pos + 1);
        var pos = fileName.lastIndexOf(".");
        fileName = fileName.substring(0,pos);
      },
      saveAll: function(flag) {
        var error = 0;
        var msg = "";
//      if($("input[name='adname']").val().length < 1) {
//        $("input[name='adname']").css("border","1px solid #FF7E82");
//        error++;
//        msg += error+'.请填写广告名称<br>';
//      }
//      else if($("input[name='adname']").val().length > 50) {
//        error++;
//        msg += error+'.广告名称不能超过50个字符（25个汉字）<br>';
//      }
//      else {
//        $("input[name='adname']").css("border","1px solid #E6E8E");
//      }
//      if($("input[name='landing_page']").val().length < 1) {
//        error++;
//        msg += error+'.目标地址不能为空<br>';
//      }
//      adType = $("#adType").val();
//      if(adType == 0) {
//        error++;
//        msg += error+'.未选择广告类型';
//      }
        stuff_size_1 = $("#stuff_size_1").val();
        stuff_size_2 = $("#stuff_size_2").val();
//      if((adType == 1001 && stuff_size_2 == 0)||(adType == 1002 && stuff_size_1 == 0)||(adType == 1003 && stuff_size_1 == 0)){
//        error++;
//        msg += error+'.未选择素材尺寸';
//      }
        if(error == 0) {
          if(flag==1) {
            layer.confirm('提交审核后将不可再修改素材，是否继续？', function(){
            $("#submit_or_not").val(1);
            $("#stuffs_form").submit();
            }); 
          }else {
            $("#submit_or_not").val(0);
            $("#stuffs_form").submit();
          }
        }else {
          layer.alert(msg);
          return false;
        }
      }
    };
    $(document).ready(function(){
      appInit.init(); 
    });
  </script>  
  <?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
</html>

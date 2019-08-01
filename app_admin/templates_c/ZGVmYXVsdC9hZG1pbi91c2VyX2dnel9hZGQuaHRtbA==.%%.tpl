<!DOCTYPE html>
<html>

<head>
    <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
    <script src="/baichuan_advertisement_manage/assets_admin/js/jquery.form.min.js"></script>
    <style>
        .scll {
            width: 200px;
            height: 25px;
            font-family: STXihei;
            font-size: 16px;
        }

        .hrll {
            border-top: 2px solid gray;
            margin-bottom: 10px;
        }

        .dvll {
            margin-bottom: 20px;
            margin-left: 100px;
            margin-right: 10px;
            width: 700px;
            font-size: 14px;
        } 	 	 	
        .dvll > span:first-child:not(.tips),.dvll span.label-name{
        	display: inline-block;
        	width:150px;
        	text-align: right;
        }
        span.label-textarea{
        	vertical-align: top;
        }
        .fl{
        	float:left;
        }
    </style>

    <link rel="stylesheet" href="/baichuan_advertisement_manage/assets_admin/v5/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
    <script src="/baichuan_advertisement_manage/assets_admin/v5/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
</head>

<body>
    <?php echo htmlspecialchars(tpl_function_part("/main.main.nav.admin"), ENT_QUOTES); ?>
    <!--main-->
    <div class="main">
        <!--side-->
        <div class="side">
            <?php echo htmlspecialchars(tpl_function_part(("/admin.user.left")), ENT_QUOTES); ?>
        </div>

        <div class="mcon">
            <div class="toolbar-bc fl mb-10">
                <div class="fl sub-title sc-title">
                    <a href="/baichuan_advertisement_manage/admin.user.list" style="margin-left:10px;">高级管理</a>
                    <i class="fa fa-angle-double-right" style="margin-left:6px;"></i>
                    <a href="/baichuan_advertisement_manage/admin.user.list" style="margin-left:10px;">账户管理</a>
                    <i class="fa fa-angle-double-right" style="margin-left:6px;"></i>
                    <?php if(Tpl::$_tpl_vars["operate"]==1){; ?>创建账户<?php }elseif((Tpl::$_tpl_vars["operate"]==2)){; ?>编辑账户<?php }; ?>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-md-12">
                    <!-- start: FORM VALIDATION 1 PANEL -->
                    <div class="panel panel-white">
                        <div class="panel-heading" style="display:none;">
                            <h4 class="panel-title">创建用户</h4>
                        </div>
                        <div class="panel-body" style="padding-right:100px; padding-top: 0;">
                            <form action="/admin.user.edit.<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->uid, ENT_QUOTES); ?>" method="post" role="form" enctype="multipart/form-data" id="useradd">
                                <input type="hidden" id="names" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["names"], ENT_QUOTES); ?>" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if(Tpl::$_tpl_vars["error"]['count']>0){; ?>
                                        <div class="errorHandler alert alert-danger">
                                            <i class="fa fa-times-sign"></i> 表单包含错误信息，请仔细核对：<?php echo htmlspecialchars(Tpl::$_tpl_vars["error"]['msg'], ENT_QUOTES); ?>
                                        </div>
                                        <?php }; ?>
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> 表单包含错误信息，请仔细核对：
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> 表单验证通过!
                                        </div>
                                    </div>
                                    <div style="width:800px;margin-top:10px;margin-left:10px;">
                                        <h4>• 账户信息</h4>
                                        <hr class="hrll"> <?php /* 注释 权限说明 10000 =>'name'=>"系统管理员", 1000 =>'name'=>"运营账户", 18 =>'name'=>"子运营账户",
                                        11 =>'name'=>"客服", 12 =>'name'=>"客户经理", 13 =>'name'=>"广告主", 14 =>'name'=>"运维", 15
                                        =>'name'=>"黑白名管理员", 16 =>'name'=>"稽核员", 17 =>'name'=>"产品经理", */?>


                                        <div class="dvll" style="display: auto;">
                                            <span>用户来源：</span>
                                            <select class="scll" id="selYear" name="source">
                                                <!--<option value="0">&#45;&#45;选择用户来源&#45;&#45;</option>-->
                                                <?php foreach(Tpl::$_tpl_vars["sourceInfo"] as Tpl::$_tpl_vars["source"]){; ?>
                                                <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["source"]['id'], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["source"][ 'id']==Tpl::$_tpl_vars["user"]->source){; ?> selected<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["source"]["source_name"], ENT_QUOTES); ?></option>
                                                <?php }; ?>
                                            </select>

                                        </div>
                                        <?php if(Tpl::$_tpl_vars["operate"]==2){; ?>
                                        <div class="dvll" id="account_type" style="display: auto;">
                                            <span>账户类型：</span>
                                            <select class="scll" name="role_id" <?php if(Tpl::$_tpl_vars["operate"]==2){; ?> disabled <?php }; ?>>
                                                <?php foreach(Tpl::$_tpl_vars["roleList"] as Tpl::$_tpl_vars["roleId"] => Tpl::$_tpl_vars["role"]){; ?>
                                                <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["roleId"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["user"]->role_id==Tpl::$_tpl_vars["roleId"]){; ?>selected="selected"<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["role"]['name'], ENT_QUOTES); ?></option>
                                                <?php }; ?>
                                            </select>
                                            <span class="text-red"> *</span>
                                        </div>
                                        <?php }; ?> <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18])){; ?>
                                        <div class="dvll" id="account_type" style="display: auto;">
                                            <span>账户类型：</span>
                                            <select class="scll" name="role_id" <?php if(Tpl::$_tpl_vars["operate"]==2){; ?> disabled <?php }; ?>>
                                                <!--<select class="scll" name="role_id" <?php if(Tpl::$_tpl_vars["operate"]==2){; ?> disabled <?php }; ?>>-->
                                                <?php foreach(Tpl::$_tpl_vars["roleList"] as Tpl::$_tpl_vars["roleId"] => Tpl::$_tpl_vars["role"]){; ?> <?php if(Tpl::$_tpl_vars["info"]->role_id==10000 or (Tpl::$_tpl_vars["info"]->role_id==1000 and in_array(Tpl::$_tpl_vars["roleId"],[18,17,13,12])
                                                ) or (Tpl::$_tpl_vars["info"]->role_id==18 and in_array(Tpl::$_tpl_vars["roleId"],[17,13,12]) ) or (Tpl::$_tpl_vars["info"]->role_id==12
                                                and in_array(Tpl::$_tpl_vars["roleId"],[17,13]) )){; ?>
                                                <option value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["roleId"], ENT_QUOTES); ?>" <?php if(Tpl::$_tpl_vars["user"]->role_id==Tpl::$_tpl_vars["roleId"]){; ?>selected="selected"<?php }; ?>><?php echo htmlspecialchars(Tpl::$_tpl_vars["role"]['name'], ENT_QUOTES); ?></option>
                                                <?php }; ?> <?php }; ?>
                                            </select>
                                            <span class="text-red"> *</span>
                                        </div>
                                        <?php }; ?> <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000])){; ?>
                                        <div class="dvll" id="account_provider" <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000])){; ?> style="display: none;"<?php }; ?>>
                                            <span>所属账户：</span>
                                            <select class="scll" name="account_provider" <?php if(Tpl::$_tpl_vars["operate"]==2){; ?> disabled<?php }; ?>>
                                                <option value="--请选择所属【子运营商】账户--">--请选择所属【子运营商】账户--</option>
                                            </select>
                                            <span class="text-red"> *</span>
                                        </div>
                                        <?php }; ?><?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18])){; ?>
                                        <div class="dvll" id="account_manager" <?php if(in_array(Tpl::$_tpl_vars["info"]->role_id,[10000,1000,18])){; ?> style="display: none;"<?php }; ?>>
                                            <span>所属账户：</span>

                                            <select class="scll" name="account_manager" <?php if(Tpl::$_tpl_vars["operate"]==2){; ?> disabled<?php }; ?>>
                                                <option value="">--请选择所属【客户经理】账户--</option>
                                            </select>
                                            <span class="text-red"> *</span>
                                        </div>
                                        <?php }; ?>

                                        <div class="dvll">
                                            <span>账户名称：</span>
                                            <input class="scll" id="user_name" <?php if(Tpl::$_tpl_vars["operate"]==2){; ?> disabled<?php }; ?> placeholder="用来登录系统的用户名" style="line-height:25px;" type="text"
                                                name="user_name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->user_name, ENT_QUOTES); ?>" maxlength="28" required></input>
                                            <span class="text-red"> *
                                                <span id="name_tip" style="color: red;display: none;">(该账户名称已存在，请重新输入)</span>
                                            </span>
                                        </div>
                                        <?php if(Tpl::$_tpl_vars["operate"]==2){; ?>
                                        <div class="dvll">
                                            <span>所属账户：</span>
                                            <input class="scll" disabled style="line-height:25px;" type="text" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["creator"], ENT_QUOTES); ?>"></input>
                                            <span class="text-red"> *</span>
                                        </div>
                                        <?php }; ?>
                                        <div class="dvll">
                                            <span>账户状态：</span>
                                            <label>
                                                <input style="line-height:25px;" type="radio" value="1" <?php if(Tpl::$_tpl_vars["user"]->account_status==1){; ?>checked<?php }; ?> name="account_status" checked="checked"></input>
                                                启用
                                            </label>
                                            <label style="margin-left:50px;">
                                                <input style="line-height:25px;" type="radio" value="2" <?php if(Tpl::$_tpl_vars["user"]->account_status==2){; ?>checked<?php }; ?> name="account_status"></input>
                                                禁用
                                            </label>
                                        </div>
                                        <div class="dvll">
                                            <div class="tips" style="margin-left: 80px;color: #eaa;">密码至少八位大小写字母或数字及其他字符组合</div>
                                            <span class="label-name">设置密码：</span>
                                            <input class="scll" style="line-height:25px;" id="password" type="password" name="passwd" <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?>></input>
                                            <span class="text-red"> *</span>
                                            <span>密码强度: </span>
                                            <span class="text-red" id="passwdStrong"></span>
                                        </div>
                                        <div class="dvll">
                                            <span>确认密码：</span>
                                            <input class="scll" style="line-height:25px;" type="password" name="passwd_again" id="passwd_again" <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?>></input>
                                            <span class="text-red"> *</span>
                                        </div>
                                    </div>
                                    <div style="width:800px;margin-top:10px;margin-left:10px;">
                                        <h4>• 基本资料</h4>
                                        <hr class="hrll">
                                        <div class="show_wabang" style="display: none">
                                            <div class="dvll">
                                                <span>广告主网站名称：</span>
                                                <input class="scll" <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?> style="line-height:25px;" type="text" name="site_name"
                                                value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->site_name, ENT_QUOTES); ?>"></input>
                                                <span class="text-red"> *</span>
                                            </div>
                                            <div class="dvll">
                                                <span>网站域名：</span>
                                                <input class="scll" <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?> style="line-height:25px;" type="text" name="site_url"
                                                value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->site_url, ENT_QUOTES); ?>"></input>
                                                <span class="text-red"> *</span>
                                            </div>
                                            <div class="dvll">
                                                <span>资质类型：</span>
                                                <select class="scll" <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?> style="line-height:25px;" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->type, ENT_QUOTES); ?>" name="type" id="type">
                                                    <option value="1">营业执照（个体工商）</option>
                                                    <option value="2">营业执照（企业单位）</option>
                                                    <option value="3">香港企业同等效力资质</option>
                                                    <option value="4">台湾企业同等效力资质</option>
                                                    <option value="5">澳门企业同等效力资质</option>
                                                    <option value="6">事业单位法人登记证</option>
                                                    <option value="7">民办非企业单位登记证</option>
                                                    <option value="8">社会团体法人登记证</option>
                                                    <option value="9">民办学校办学许可证</option>
                                                    <option value="10">国外同等效力主体资质</option>
                                                </select>
                                                <!-- <input class="scll" <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?> style="line-height:25px;" type="text" name="type" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->type, ENT_QUOTES); ?>"></input> -->
                                                <span class="text-red"> *</span>
                                            </div>
                                            <div class="dvll">
                                                <span>资质名称：</span>
                                                <input class="scll" <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?> style="line-height:25px;" type="text" name="name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->name, ENT_QUOTES); ?>" readonly></input>
                                                <span class="text-red"> *</span>
                                            </div>
                                            <div class="dvll">
                                                <span>企业资质编号：</span>
                                                <input class="scll" <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?> style="line-height:25px;" type="text" name="number" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->number, ENT_QUOTES); ?>"></input>
                                                <span class="text-red"> *</span>
                                            </div>
                                            <div class="dvll" style="margin-bottom: 20px;">
                                                <span for="ad-title">有效期：</span>
                                                <input  readonly id="start_date" name="start_date" class="itxt idate fc7" <?php if(Tpl::$_tpl_vars["stuffInfo"]['valid_startTime']>0){; ?> value="<?php echo htmlspecialchars(date('Y-m-d',Tpl::$_tpl_vars["stuffInfo"]['valid_startTime']), ENT_QUOTES); ?>" <?php }else{; ?> value="开始时间"<?php }; ?> size="12"  <?php if(!Tpl::$_tpl_vars["user"]->uid){; ?>required<?php }; ?>>
                                                <span class="text-red"> *</span>
                                            </div>

                                            <!--上传资质图片-->
                                            <div class="dvll clearfix" style="margin-bottom:10px;">
                                                <span for="ad-type" class="fl">主体资质文件：</span>
                                                <div class="col-sm-8" style="max-width:500px; padding:0 5px;">
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
                                                                    <input id="ad-image-file" type="file" class="ad-image-file" class="file-input" name="ad-image-file" onchange="appInit.getFileName();">
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

                                            <!--end-->


                                        </div>

                                        <div class="dvll">
                                            <span>联系人公司名称：</span>
                                            <input class="scll" style="line-height:25px;" type="text" name="company_name" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->company_name, ENT_QUOTES); ?>"></input>
                                            <span class="text-red show_wabang" style="display: none"> *</span>
                                        </div>
                                        <div class="dvll">
                                            <span>联系人姓名：</span>
                                            <input class="scll" style="line-height:25px;" type="text" name="host" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->host, ENT_QUOTES); ?>"></input>
                                        </div>
                                        <div class="dvll">
                                            <span>联系电话：</span>
                                            <input class="scll" style="line-height:25px;" type="text" name="cell_phone" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->cell_phone, ENT_QUOTES); ?>"></input>
                                        </div>
                                        <div class="dvll">
                                            <span>联系地址：</span>
                                            <input class="scll" style="line-height:25px;" type="text" name="address" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->address, ENT_QUOTES); ?>"></input>
                                        </div>
                                        <div class="dvll">
                                            <span class="label-textarea">其他备注：</span>
                                            <textarea rows="10" name="colum2"><?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->colum2, ENT_QUOTES); ?></textarea>
                                        </div>
                                    </div>
                                    <input style="width:200px;height:38px;line-height:38px;background-color:green;color:white;margin:30px 300px 0px 260px; text-align:center;border: 0;"
                                        type="submit" value="确定提交">

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end: FORM VALIDATION 1 PANEL -->
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.icheck').iCheck({
                //checkboxClass : 'icheckbox_minimal-green',
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_minimal',
                increaseArea: '-10%'
            });
            var strongMaps = ['很弱', '较弱', '一般', '强', '很强', '非常强'];
            $('#password').on('input', function () {
                var res = pwStrong = strongCheck($(this).val());
                $('#passwdStrong').text(strongMaps[res]);
            });
            $("#useradd").validate({
                errorClass: "fcr",
                debug: true,
                submitHandler: function (form) {
                    if (<?php echo htmlspecialchars(Tpl::$_tpl_vars["user"]->uid? 'false':'true', ENT_QUOTES); ?>
                         || $('#password').val() != '') {
                        if (pwStrong < 2) {
                            return alert('密码太弱');
                        }
                        if ($('#password').val() != $('#passwd_again').val())
                            return alert('请确认重复密码是一致的');
                    }
                    form.submit();
                }
            });

            $('#selYear').on('change',function () {
                if ($(this).val() == 5) {
                    $(".show_wabang").show();
                } else {
                    $(".show_wabang").hide();
                }
            })
            $('#type').on('change',function () {
                var that = this;
                if ($(this).val() != null) {
                    console.log($('#type option:selected').attr('label'))
                    console.log($('#type option:selected').text())
                    $("input[name='name']").val($(that).find('option:selected').text());
                } else {
                    $("input[name='name']").val();
                }
            })
             function layoutDate(){
        if($("#start_date").val()=="开始时间"){
            $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
        }
        $("#start_date").datepicker({ dateFormat: "yy-mm-dd" ,minDate:0,
        onSelect:function(dateText,inst){
           $("#end_date").datepicker("option","minDate",dateText);
        }});
        $("#end_date").datepicker({ dateFormat: "yy-mm-dd",minDate:new Date(Date.parse($("#start_date").val())) });
      }
            // function layoutDate() {
            //     if ($("#start_date").val() == "开始时间") {
            //         $("#start_date").val("<?php echo htmlspecialchars(date("Y-m-d"), ENT_QUOTES); ?>");
            //     }
            //     $("#start_date").datepicker({
            //         dateFormat: "yy-mm-dd",
            //         minDate: 0,
            //         onSelect: function (dateText, inst) {
            //             $("#end_date").datepicker("option", "minDate", dateText);
            //         }
            //     });
            //     $("#end_date").datepicker({
            //         dateFormat: "yy-mm-dd",
            //         minDate: new Date(Date.parse($("#start_date").val()))
            //     });
            // }
            layoutDate();
        });


        $("#user_name").change(function () {
            var names = $("#names").val();
            var user_name = $.trim($("#user_name").val());
            var names_arr = names.split(',');
            var num = $.inArray(user_name, names_arr);
            if (num != -1) {
                $("#name_tip").show();
                return false;
            } else {
                $("#name_tip").hide();
            }

            // console.log(names);
            // console.log(55555);
            // console.log(names_arr);
            // console.log(122222);

        });


        var pwStrong = 0;

        var mediumReg = /^(?![\d]+$)(?![a-zA-Z]+$)(?![^\da-zA-Z]+$).+$/;
        var strongReg = /^(?![\d]+$)(?![a-zA-Z]+$)(?![^\da-zA-Z]+$)(?![^a-zA-Z]+$)(?![^\d]+$)(?![\da-zA-Z]+$).+$/;

        function strongCheck(sValue) {
            // 1 2 3 4 5
            var modes = 0;
            if (!sValue) return modes;
            if (sValue.length > 7) modes++;
            if (sValue.length > 11) modes++;
            if (mediumReg.test(sValue)) modes++;
            if (strongReg.test(sValue)) modes = modes + 2;
            return modes;
        }

        function appendOptions(jqel, data, def) {
            jqel.empty();
            if (def) jqel.append(def);
            for (var i = data.length - 1; i >= 0; i--) {
                jqel.append($("<option ></option>").text(data[i]['user_name']).attr('value', data[i]['uid']));
            }
        }

        var MarketList, ManagerList;
        $.ajax({
            method: 'get',
            url: "/admin.user.GetMarketList",
            success: function (rep) {
                try {
                    MarketList = $.parseJSON(rep);
                    appendOptions(account_provider_el.find('select'), MarketList,
                        '<option value="">--请选择所属【子运营商】账户--</option>');
                } catch (e) {
                    alert('加载子运营商出错');
                }
            }
        });
        $.ajax({
            method: 'get',
            url: "/admin.user.GetmanagerListById",
            success: function (rep) {
                try {
                    ManagerList = $.parseJSON(rep);
                    appendOptions(account_manager_el.find('select'), ManagerList,
                        '<option value="">--请选择所属【客户经理】账户--</option>');
                } catch (e) {
                    alert('加载客户经理出错');
                }
            }
        });



        var account_type_el = $('#account_type');
        var account_provider_el = $('#account_provider');
        var account_manager_el = $('#account_manager');
        account_type_el.find('select').on('change', function () {
            if (this.value == 12) {
                account_manager_el.hide().find('select').val('');
                account_provider_el.show();
            } else if (this.value == 13) {
                account_provider_el.hide().find('select').val('');
                account_manager_el.show();
            } else {
                account_provider_el.hide().find('select').val('');
                account_manager_el.hide().find('select').val('');
            }
        })



        FormValidator.init();
    </script>
    <?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>

</html>
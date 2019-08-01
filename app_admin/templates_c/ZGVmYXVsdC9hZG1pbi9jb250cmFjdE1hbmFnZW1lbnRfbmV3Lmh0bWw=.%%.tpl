<!doctype html>
<!--1待审核 2通过 3拒绝-->
<head>
    <meta https-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta https-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="https://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/contractManagement_list.css" />
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/bootstrap-fileinput/css/fileinput.css" />
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/bootstrap-fileinput/js/fileinput.js" />
    <link rel="stylesheet" type="text/css" href="/baichuan_advertisement_manage/assets_admin/bootstrap-fileinput/js/fileinput.js" />
    <script  type="text/javascript" src="/baichuan_advertisement_manage/assets_admin/v5/plugins/jquery-validation/dist/jquery.validate.js/jquery.validate.min.js"></script>
    <script  type="text/javascript" src="/baichuan_advertisement_manage/assets_admin/v5/js/form-validation.js"></script>
    <title>广告投放管理平台</title>
    <style type="text/css">
        * {
            margin: 0px;
            padding:0px;
        }
        .Unit_price {
            display: inline-block;
            /*border: 1px solid red;*/
            width: 380px;height: 30px;line-height: 30px;
            position: absolute;top:302px;left: 418px;
        }
        #form1 lable {
            display: inline-block;
            width: 120px;
            text-align: right;

        }

        #form1 {
           padding-left: 50px;
        }
        .left_nav2 ul li {
            width: 652px;
            height: 34px;
            /* text-align: center; */
            text-indent: 2em;
            line-height: 34px;
            /* margin-top: 1px; */
            cursor: pointer;
            position: relative;
            cursor: pointer;
            text-align: center;
        }
        .left_nav2 {
            top:0;
            left: 0;
        }
       .save_new,.reset_new,.return_new {
            top:0;
            /*left: 0;*/
            position: relative;
        }

    </style>
    <head>
        <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
    </head>
<body>
<?php echo htmlspecialchars(tpl_function_part("/main.main.nav.ad"), ENT_QUOTES); ?>
<div class="left_nav">
    <ul>
        <li class="left_nav_1">新建合同</li>
        <!--<li class="left_nav_2" style="background: #666666;">-->
            <!--&lt;!&ndash;<span class="glyphicon glyphicon-star" aria-hidden="true"></span>&ndash;&gt;-->
            <!--<a href="" style="color: #fff;">-->
                <!--合同计划审核-->
            <!--</a>-->
        <!--</li>-->
        <!--<li class="left_nav_3"><span style="color: #1182d1;" > ▪ </span>待审核</li>-->
        <!--<li class="left_nav_4"><a href=""><span style="color: #1182d1;" > ▪ </span>已通过</a></li>-->
        <!--<li class="left_nav_5"><a href=""><span style="color: #1182d1;" > ▪ </span>未通过</a></li>-->
    </ul>
</div>
<div class="top_nav">
    <a href="/baichuan_advertisement_manage/admin.contract.list?nav=7">
        合同管理
    </a><span style="color:#3f3333">>></span> 新建合同
    <!--<span class="CreateContract_btn" style="position: relative;">-->
        <!--<a href="/baichuan_advertisement_manage/admin.contract.list">-->
            <!--<span style="position: absolute;left: -13px;top:2px;" class="glyphicon glyphicon-share-alt" aria-hidden="true">返回合同列表</span>-->
        <!--</a>-->
    <!--</span>-->

</div>
<div class="new_contract_form">
    <form style="position: relative;"  method="post" id="form1" action="/admin.contract.new">
        <br>
        <lable>合同类型：</lable>
        <select name="contract_type" id="contract_type" class="" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 50px;">
            <option value="2">合约制广告合同</option>
            <option value="1">竞价制广告合同</option>
    </select> <br><br>
         <lable>客户经理姓名:</lable><input id="manager_name" name="manager_name" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 50px;" type="text" class="form-control" placeholder="请输入客户经理姓名" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["manager_info"]->user_name, ENT_QUOTES); ?>" disabled="disabled"><br><br>
         <lable>客户经理联系电话:</lable><input id="manager_phone_number" name="manager_phone_number" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 50px;" type="text" class="form-control" placeholder="请输入客户经理联系电话" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["manager_info"]->cell_phone, ENT_QUOTES); ?>" disabled="disabled"><br><br>
         <lable>客户经理所属分公司：</lable><input id="company_name" name="company_name" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 63px;" type="text" class="form-control" placeholder="请输入所属分公司" value="<?php echo htmlspecialchars(Tpl::$_tpl_vars["manager_info"]->company_name, ENT_QUOTES); ?>" disabled="disabled"><br><br>
         <lable><span style="color:red;margin-right:10px;">*</span>合同名称：</lable><input  name="contract_name" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 50px;" type="text" class="form-control" placeholder="请输入合同名称"><br><br>
         <lable><span style="color:red;margin-right:10px;">*</span>客户公司名称：</lable><input  name="contact_company_name" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 36px;" type="text" class="form-control" placeholder="请输入客户公司名称"><br><br>
         <lable><span style="color:red;margin-right:10px;">*</span>客户名称：</lable><input  name="contact_person" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 36px;" type="text" class="form-control" placeholder="请输入客户名称"><br><br>
         <lable><span style="color:red;margin-right:10px;">*</span>客户联系电话：</lable><input  name="contact_person_phone_number" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 36px;" type="text" class="form-control" placeholder="请输入客户联系电话"><br><br>
         <lable><span style="color:red;margin-right:10px;">*</span>客户CA：</lable><input  name="contact_ca" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 78px;" type="text" class="form-control" placeholder="请输入客户CA"><br><br>

        <div id="contract_type1">
            <lable>合同折扣前总价：</lable>
            <input  class="total_budget" name="total_budget" style="height: 37px;" type="text" class="form-control total_pricebefore" placeholder="填写">
            <span  style="padding:0 5px;">元</span><lable>折扣率：</lable><input  name="discount_rate"   style="height: 37px;" type="text" max="100"  class="discount_rate" placeholder="填写折扣率"><span  style="padding: 0 5px">%</span>
            <br><br>
            <lable>折扣后总价：</lable><input readonly  name="discount_after" style="height: 37px;" type="text" class=" Concessional_rate1" placeholder="无需手动填写" value=""><span  style="padding-left: 5px;">元</span>
        </div>
        <div id="contract_type2" class="">
            <!--<div class="contract_type2_box_price">-->
                                <!--<lable>广告折扣前单价：</lable><input class="price" name="price[]" style="height: 37px;" type="text" class="form-control" placeholder="填写"><span  style="padding:0 5px;">元</span><lable>购买量1：</lable><input  name="buy_amount[]" style="height: 37px;" type="text" class="buy_amount" ><select name="unit[]" id=""  style="height: 37px;width:54px;">-->
                                        <!--<option value="2">cpm</option>-->
                                        <!--<option value="4">cpt</option>-->
                                    <!--</select><br><br>-->
                            <!--</div>-->
                       <!--<div class="left_nav2">-->
                            <!--<ul>-->
                                   <!--<li id="add_contract_type2" class="left_nav_1" style="background: #12c043;color: #fff;margin-bottom: 10px;"><a style="color: #fff;">+ 添加单价</a></li>-->
                                <!--</ul>-->
                        <!--</div>-->
                        <!--<lable>合同折扣前总价：</lable><input readonly class="total_budget" name="total_budget" style="height: 37px;" type="text" class="form-control" placeholder="填写"><span  style="padding:0 5px;">元</span><lable>折扣率：</lable><input    name="discount_rate"  max="100" style="height: 37px;" type="text" class="discount_rate" placeholder="填写折扣率"><span  style="padding: 0 5px">%</span><lable>折扣后总价：</lable><input readonly name="discount_after" style="height: 37px;" type="text" class=" Concessional_rate" value=""><span  style="padding-left: 5px;">元</span>-->
                        <!--<br><br>-->

        </div>
        <div style="position: relative;height: 180px;">
            <br><br><br><span class="return return_new" style="line-height: 23px;"><a href="/baichuan_advertisement_manage/admin.contract.list" style="line-height: 23px;"><span style="line-height: 23px;" class="glyphicon glyphicon-share-alt" aria-hidden="true">返回</span></a></span>
            <span class="reset reset_new">重置</span>
            <span class="save save_new" style="width: 75px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;确认提交</span>

        </div>

        <!--&#45;&#45;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广告预算：<input class="advertising_budget" name="contact_email" style="display:inline-block;width: 288px;height: 37px;border-radius: 5px;margin-right: 65px;" type="text" class="form-control" placeholder="请输入广告预算"><br><br>-->
        <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合同文件：<input type="text" class="contract_file" name="test" id="test" placeholder="合同文件" style="margin-right: 92px;">-->

        <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备注：-->

    </form>

</div>
<?php echo htmlspecialchars(tpl_function_part("/main.main.footer"), ENT_QUOTES); ?>
</body>
</html>
<script>

$(function(){
    init()
});
function init (){
//    表单验证
    //    解决多个相同name的问题；
    if ($.validator) {
        $.validator.prototype.elements = function () {
            var validator = this,
                rulesCache = new Object();

            // select all valid inputs inside the form (no submit or reset buttons)
            return $(this.currentForm)
                .find("input, select, textarea")
                .not(":submit, :reset, :image, [disabled]")
                .not(this.settings.ignore)
                .filter(function () {
                    if (!this.name && validator.settings.debug && window.console) {
                        console.error("%o has no name assigned", this);
                    }
                    //注释这行代码
                    // select only the first element for each name, and only those with rules specified
                    //if ( this.name in rulesCache || !validator.objectLength($(this).rules()) ) {
                    //    return false;
                    //}
                    rulesCache[this.name] = true;
                    return true;
                });
        }
    }
 var input_valid=function () {
     var valid1=new Object();
     $("input[name='price[]']").keyup(  valid1.v=function () {
         if(this.value){
             this.value=(this.value.replace(/[^0-9]+/,''))

         }

     }).blur(valid1.v);
     
     $("input[name='buy_amount[]']").keyup(   valid1.t=function () {
         if(this.value) {
             this.value=this.value.replace(/[^0-9]+/,'');
         }

     }).blur(valid1.t());
     $("input[name='discount_rate']").keyup(   valid1.t=function () {
         if(this.value) {
             this.value=this.value.replace(/[^0-9]+/,'');
             limitInput(this);
             get_discount();
         }

     }).blur(valid1.t());

     $("input[name='total_budget']").keyup(   valid1.t=function () {
       if($(this).prop("readonly"))return false;
         if(this.value) {
             this.value=this.value.replace(/[^0-9]+/,'');
             get_discount();
         }

     }).blur(valid1.t());

     $("#form1").validate({
         rules: {
             manager_name: {
                 required: true
             },
             company_name:{
                 required: true
             },
             contract_name:{
                 required:true
             },
             contact_person:{
                 required:true
             },
             contact_ca:{
                 required:true
             },
             "price[]":{
                 required:true,
                 min:1,
                 number:true,
             },
             "buy_amount[]":{
                 required:true,
                 min:1,
                 number:true,
             },
             discount_rate:{
                 required:true
             }
         },
         messages: {
             manager_name: {
                 required: "请输入客户经理姓名"
             },
             company_name: {
                 required: "请输入所属分公司"
             },
             contract_name:{
                 required: "请输入合同名称"
             },
             contact_person:{
                 required: "请输入客户名称"
             },
             contact_ca:{
                 required: "请输入客户CA"
             },
             "price[]":{
                 required: "单价不能为空",
                 digits: "只能输入整数",
             },
             "buy_amount[]":{
                 required: "购买量不能为空",
                 digits: "只能输入整数"
             },
             discount_rate:{
                 required: "请输入不大于100的数字"
             }

         },
         errorPlacement: function(error, element) {
             if(element.is(':radio')||element.is(':checkbox')) {
                 //var eid = element.attr("name");不知道为啥从网上找到的会有这一行
                 error.appendTo(element.parent());
             }else{
                 //var selector = "[name='" + element.attr("name") + "']";
                 //error.insertAfter($(selector)); 这两句是原来工程里的代码，我改成了下面这个也没错，
                 error.insertAfter(element);
             }
         }
     });
    };



    function limitInput(o){
        var value=o.value;
        var min=0;
        var max=100;
        if(parseInt(value)<min||parseInt(value)>max){

            o.value=100;
        }
    }
//计算总价
   function get_tototal_budget() {
       $(".new_contract_form").on('blur',"input[name='buy_amount[]'],input[name='price[]']",function(){
         get_all();
         get_discount();
       })
   }

    function get_all(){
        var elem_buy_amount=$("#contract_type2 .buy_amount");
        var elem_price=$("#contract_type2 .price");
        var total=0;
        for(var t=0;t<elem_price.length;t++) {
            var prrice1 = elem_price[t].value;
            var buy_amount1 =elem_buy_amount[t].value;
            if(prrice1&&buy_amount1){
                total_budget=prrice1*buy_amount1;
                total=total+total_budget;
                $("#contract_type2 input[name='total_budget']").val(total.toFixed(2));

            }
        }
        var dsp= $("#contract_type2 .buy_amount")[0];

    }






    function contract_type_select(){

        if($("#contract_type").val()==1){
            $("#contract_type1").show();
            $("#contract_type2").empty();
           // get_discount_after();
        }
        if($("#contract_type").val()==2) {
            $("#contract_type2").append('<div class="contract_type2_box_price">' +
                '                <lable><span style="color:red;margin-right:10px;">*</span>广告折扣前单价：</lable><input class="price" name="price[]" maxlength="7" style="height: 37px;" type="text" class="form-control" placeholder="填写"><span  style="padding:0 5px;">元</span><lable><span style="color:red;margin-right:10px;">*</span>购买量：</lable><input  name="buy_amount[]" maxlength="7" style="height: 37px;" type="text" class="buy_amount" ><select name="unit[]" id=""  style="height: 37px;width:54px;">' +
                '                    <option value="2">cpm</option>' +
                '                    <option value="4">cpt</option>' +
                '                </select><br><br>' +
                '            </div>' +
                '            <div class="left_nav2">' +
                '                <ul>' +
                '                    <li id="add_contract_type2" class="left_nav_1" style="background: #12c043;color: #fff;margin-bottom: 10px;"><a style="color: #fff;">+ 添加单价</a></li>' +
                '                </ul>' +
                '            </div>' +
//                '            <lable>合同折扣前总价：</lable><input readonly class="total_budget" name="total_budget" style="height: 37px;" type="text" class="form-control" placeholder="填写"><span  style="padding:0 5px;">元</span><lable>折扣率：</lable><input    name="discount_rate"  max="100" style="height: 37px;" type="text" class="discount_rate" placeholder="填写折扣率"><span  style="padding: 0 5px">%</span><br><br><lable>折扣后总价：</lable><input readonly name="discount_after" style="height: 37px;" type="text" class=" Concessional_rate" value=""><span  style="padding-left: 5px;">元</span>' +
                '            <lable>合同折扣前总价：</lable><input readonly class="total_budget" name="total_budget" style="height: 37px;" type="text" class="form-control"><span  style="padding:0 5px;">元</span><lable>折扣率：</lable><input    name="discount_rate"  max="100" style="height: 37px;" type="text" class="discount_rate" placeholder="填写折扣率"><span  style="padding: 0 5px">%</span><br><br><lable>折扣后总价：</lable><input readonly name="discount_after" style="height: 37px;" type="text" class=" Concessional_rate" value=""><span  style="padding-left: 5px;">元</span>' +
                '            <br><br>');
            $("#contract_type1").hide();


            //get_tototal_budget();
           // get_discount_after();

        }
    }
//    初始化执行
    contract_type_select();
    input_valid();

    var i=1;
//    添加单价
    function add_price(){
        $("#add_contract_type2").click(function () {

            i++
            var price_input= '<span class="price_close" style="display:block;"><lable>广告折扣前单价：</lable><input required="required" maxlength="7" class="price" name="price[]" style="height: 37px;" type="text" class="form-control" placeholder="填写"><span  style="padding:0 5px;">元</span><lable>购买量：</lable><input required="required" maxlength="7" name="buy_amount[]" style="height: 37px;" type="text" class="buy_amount" >'+
                '<select name="unit[]" id=""  style="height: 37px;width:54px;">'+
                '<option value="2">cpm</option>'+
                '<option value="4">cpt</option>'+
                '</select> <i class="i_close" style="color: red;display: none;">x点击这儿可删除这条广告单价</i><br><br></span>'
            $(".contract_type2_box_price").append(price_input);
            //    删除操作

            if($(".price_close")&&$(".i_close")){
                $(".i_close").click(function () {
                    $(this).parent().empty();
                    get_all();
                    get_discount();
                });
                $(".price_close").hover(function () {
                    $(this).find(".i_close").show()
                },function () {
                    $(this).find(".i_close").hide()
                });
            }
            //get_tototal_budget();/*点击添加元素 重新绑定计算公式生效*/
           // get_discount_after();
            input_valid();
        });

    }
    add_price();/*初始化绑定点击添加单价事件*/

//合同类型选择change事件
    $("#contract_type").change(function () {
        if($("#contract_type").val()==1){
            $("#contract_type1").show();
            $("#contract_type2").empty();
           // get_discount_after();
        }
        if($("#contract_type").val()==2) {
            $("#contract_type2").append('<div class="contract_type2_box_price">' +
                '               <lable>广告折扣前单价：</lable><input class="price" name="price[]" style="height: 37px;" type="text" class="form-control" placeholder="填写"><span  style="padding:0 5px;">元</span><lable>购买量：</lable><input  name="buy_amount[]" style="height: 37px;" type="text" class="buy_amount" ><select name="unit[]" id=""  style="height: 37px;width:54px;">' +
                '                    <option value="2">cpm</option>' +
                '                    <option value="4">cpt</option>' +
                '                </select><br><br>' +
                '            </div>' +
                '            <div class="left_nav2">' +
                '                <ul>' +
                '                    <li id="add_contract_type2" class="left_nav_1" style="background: #12c043;color: #fff;margin-bottom: 10px;"><a style="color: #fff;">+ 添加单价</a></li>' +
                '                </ul>' +
                '            </div>' +
                '            <lable>合同折扣前总价：</lable><input readonly class="total_budget" name="total_budget" style="height: 37px;" type="text" class="form-control" placeholder="填写"><span  style="padding:0 5px;">元</span><lable>折扣率：</lable><input    name="discount_rate"  max="100" style="height: 37px;" type="text" class="discount_rate" placeholder="填写折扣率"><span  style="padding: 0 5px">%</span><br><br><lable>折扣后总价：</lable><input readonly name="discount_after" style="height: 37px;" type="text" class=" Concessional_rate" value=""><span  style="padding-left: 5px;">元</span>' +
                '            <br><br>');
            $("#contract_type1").hide();

            add_price();/*合同类型改变后，重新绑定添加单价点击事件*/

           // get_discount_after();/* 添加元素后重新绑定计算折扣后价格*/
    }
    });

    $("#add_adOrder").change(function () {

    });

//计算折扣后总价
     function get_discount_after() {
       // $("input[name='discount_rate'],input[name='buy_amount[]'],input[name='price[]']").on("blur",get_discount);
        
        $(".new_contract_form").on('blur',"input[name='discount_rate']",get_discount)
        
    };
    function get_discount(){
        var va1 = $("#contract_type1 input[name='total_budget']").val();
        var va2 = $("#contract_type1 input[name='discount_rate']").val();
        var va3 = $("#contract_type2 input[name='total_budget']").val();
        var va4 = $("#contract_type2 input[name='discount_rate']").val();
//        toFixed(2)保留小数后2位
        if(va1&&va2){
            var d1=(va1*(va2*0.01));
            $("#contract_type1 input[name='discount_after']").val(d1.toFixed(2));

        }
        if(va3&&va4){
            var d2=(va3*(va4*0.01));
            $("#contract_type2 input[name='discount_after']").val(d2.toFixed(2));

        }
    }
    get_tototal_budget();
    get_discount_after();

}
//    合同单价 单位选择  end


//    上传文件  js
function insertTitle(path){
    var test1 = path.lastIndexOf("/");  //对路径进行截取
    var test2 = path.lastIndexOf("\\");  //对路径进行截取
    var test= Math.max(test1, test2);
    if(test<0){
        document.getElementById("test").value = path;
    }else{
        document.getElementById("test").value = path.substring(test + 1); //赋值文件名
    }
}
//    上传文件  end
    $(function(){
//        提交表单
        //jQuery提交
        $(".save").click(function(){
                $("#manager_name").removeAttr("disabled");
                $("#manager_phone_number").removeAttr("disabled");
                $("#company_name").removeAttr("disabled");
            $("form").submit();
        });
//        重置
        $(".reset").click(function () {
            $("input[name='manager_name']").val("");
            $("input[name='company_name']").val("");
            $("input[name='contract_name']").val("");
            $("input[name='contact_person']").val("");
            $("input[name='contact_ca']").val("");
            $("input[name='total_budget']").val("");
            $("input[name='discount_after']").val("");
            $("input[name='price[]']").val("");
            $("input[name='buy_amount[]']").val("");
            $("input[name='discount_rate']").val("");
        });

        $(".left_nav_2").click(function () {
            $(".left_nav_3").stop().toggle();
            $(".left_nav_4").stop().toggle();
            $(".left_nav_5").stop().toggle();

        });
       // get_tototal_budget();
    });
</script>